<?php
namespace Sammy\TransportChargin\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Response;

use Sammy\TransportChargin\Http\Requests\TransportCharginRequest;
use Sammy\TransportChargin\Models\TransportChargin;
use Sammy\TransportChargin\Models\TransportCharginSub;
use Sentinel;

class TransportCharginController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Permission Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function addView()
	{
		return view( 'transportChargin::add' );
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportCharginRequest $request)
	{
                $user = Sentinel::getUser();     
                $charginlist = TransportChargin::withTrashed()->get();
                $charginlistCount = $charginlist->count();  
                $value=$charginlistCount+1;
                $charginCode='C -'.$value;
		$transportaRoute= TransportChargin::create([
			'charging_code'=>$charginCode,
                        'type_name'=>$request->name,
                        'multiply'=>$request->mbtqt,
                        'created_by'=>$user->id                    
		])->id;
                
                if(isset($request->c_name)){
                    $count=sizeof($request->c_name)-1;                    
                      for ($x = 0; $x <= $count; $x++) {                      
                          if($request->c_name[$x] !=' '){
                              $cntactlist = TransportCharginSub::where('type_name','=',$request->c_name[$x])->where('charging_type','=',$transportaRoute)->get();
                              $cntactlistCount = $cntactlist->count();                          
                              if($cntactlistCount !=0){
                                  $contact = TransportCharginSub::find($cntactlist[0]->id);      
                                  $contact->type_name=$request->c_name[$x];
                                  $contact->charging_type=$transportaRoute;                                                               
                                  $contact->updated_by=$user->id;  
                                  $contact->save();    
                              }else{
                                  $companyContact= TransportCharginSub::create([			
                                          'type_name'=>$request->c_name[$x],
                                          'charging_type'=>$transportaRoute, 				
                                          'created_by'=>$user->id
                                  ]);
                              }
                          }
                      } 
                }

		return redirect( 'transportChargin/add' )->with([ 'success' => true,
			'success.message' => 'Transport charging type added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportChargin::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
			$data = TransportChargin::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
				array_push($rowData,$i);
				array_push($rowData,$value->charging_code);
				array_push($rowData,$value->type_name);
				if($value->multiply ==1){
					array_push($rowData,'Yes');
				}else{
					array_push($rowData,'No');
				}

				$permissions = Permission::whereIn('name', ['charging.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportChargin/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Charging Type"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

				$permissions = Permission::whereIn('name', ['charging.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Charging Type"><i class="fa fa-trash-o"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
				}

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}



	/**
	 * Delete a Menu
	 * @param  Request $request menu id
	 * @return Json           	json object with status of success or failure
	 */
	public function delete(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');

			$permission = TransportChargin::find($id);
			if($permission){
				$permission->delete();
				return response()->json(['status' => 'success']);
			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
	}

	/**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function editView($id)
	{	
		$transportChargin = TransportChargin::where('id','=',$id)->get();
                $transportSubChargin = TransportCharginSub::where('charging_type','=',$id)->get();
		if($transportChargin){
			return view( 'transportChargin::edit' )->with(['transportChargin' => $transportChargin,'transportSubChargin'=>$transportSubChargin]);
		}else{
			return view( 'errors.404' )->with(['transportChargin' => $transportChargin,'transportSubChargin'=>$transportSubChargin]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportCharginRequest $request, $id)
	{
		$user = Sentinel::getUser(); 
                $Chargin = TransportChargin::find($id);                
		$Chargin->type_name = $request->name;
		$Chargin->multiply = $request->mbtqt;	
                $Chargin->updated_by = $user->id;	
		$Chargin->save();  
                
                
                if(isset($request->c_name)){
                    $count=sizeof($request->c_name)-1;                    
                      for ($x = 0; $x <= $count; $x++) {                      
                          if($request->c_name[$x] !=' '){                                                   
                              if($request->c_id[$x] != 0 ){
                                  $contact = TransportCharginSub::find($request->c_id[$x]);      
                                  $contact->type_name=$request->c_name[$x];
                                  $contact->charging_type=$id;                                                               
                                  $contact->updated_by=$user->id;  
                                  $contact->save();    
                              }else{
                                  $companyContact= TransportCharginSub::create([			
                                          'type_name'=>$request->c_name[$x],
                                          'charging_type'=>$id, 				
                                          'created_by'=>$user->id
                                  ]);
                              }
                          }
                      } 
                }
                
		return redirect('transportChargin/list')->with([ 'success' => true,
			'success.message'=> 'Transport charging type Update successfully!',
			'success.title' => 'Well Done!']);
	}
}
