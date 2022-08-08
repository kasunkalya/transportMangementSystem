<?php
namespace Sammy\TransportEmissionCompany\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use App\Models\companyContact;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Sammy\TransportRoute\Http\Requests\TransportRouteRequest;
use Sammy\TransportRoute\Models\TransportRoute;
use Sammy\TransportCompany\Models\TransportCompany;
use Sammy\TransportCompany\Http\Requests\TransportCompanyRequest;
use Sammy\TransportEmissionCompany\Http\Requests\TransportEmissionCompanyRequest;
use Sammy\TransportEmissionCompany\Models\TransportEmissionCompany;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;


class TransportEmissionCompanyController extends Controller {

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
		return view( 'transportEmissionCompany::add' );
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportEmissionCompanyRequest $request)
	{
                 $user = Sentinel::getUser();          
                	$transportCompany=TransportEmissionCompany::create([			
                        'emission_company_name'=>$request->name,
                        'address'=>$request->address,                       
                        'contact_details'=>$request->telephone_numbers,   						
                        'created_by'=>$user->id
                    
					])->id;
				if(isset($request->c_name)){
                    $count=sizeof($request->c_name)-1;                    
                      for ($x = 0; $x <= $count; $x++) {                      
                          if($request->c_name[$x] !=' '){
                              $cntactlist = companyContact::where('name','=',$request->c_name[$x])->where('companyId','=',$transportCompany)->where('companyType','=','E')->get();
                              $cntactlistCount = $cntactlist->count();                          
                              if($cntactlistCount !=0){
                                  $contact = companyContact::find($cntactlist[0]->id);      
                                  $contact->name=$request->c_name[$x];
                                  $contact->companyId=$transportCompany; 
                                  $contact->department=$request->c_department[$x]; 
                                  $contact->contactNo=$request->c_number[$x]; 
                                  $contact->email=$request->c_email[$x];                                
                                  $contact->updated_by=$user->id;  
                                  $Company->save();    
                              }else{
                                  $companyContact= companyContact::create([			
                                          'name'=>$request->c_name[$x],
                                          'companyId'=>$transportCompany,                       
                                          'department'=>$request->c_department[$x], 
                                          'contactNo'=>$request->c_number[$x], 
                                          'email'=>$request->c_email[$x], 
                                          'companyType'=>'E',                                      					
                                          'created_by'=>$user->id
                                  ]);
                              }
                          }
                      } 
                }
		return redirect( 'transportEmissionCompany/add' )->with([ 'success' => true,
			'success.message' => 'Company added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportEmissionCompany::list' );
	}
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function isAddLeasingcompany($name)
	{
        
            $companylist = TransportEmissionCompany::where('emission_company_name','=',$name)->get();
            $companylistCount = $companylist->count(); 
            return $companylistCount;
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportEmissionCompany::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
				array_push($rowData,$i);
				array_push($rowData,$value->emission_company_name);
				array_push($rowData,$value->address);
                array_push($rowData,$value->contact_details);
				$permissions = Permission::whereIn('name', ['emissioncompany.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportEmissionCompany/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Emission Company"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
				
				$permissions = Permission::whereIn('name', ['emissioncompany.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportEmissionCompany/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Emission Company"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>');
				}

				$permissions = Permission::whereIn('name', ['emissioncompany.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Emission Company"><i class="fa fa-trash-o"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
				}

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

		//}else{
			//return Response::json(array('data'=>[]));
		//}
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

			$company = TransportEmissionCompany::find($id);
			if($company){
				$company->delete();
				$contacts = companyContact::where('companyId','=',$id)->where('companyType','=','E');
                $contacts->delete();
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
		$transportEmissionCompany= TransportEmissionCompany::find($id);
		$companyContact= companyContact::where('companyId','=',$id)->where('companyType','=','E')->get();
		if($transportEmissionCompany){
			return view( 'transportEmissionCompany::edit' )->with(['transportCompany' => $transportEmissionCompany,'companyContact' =>$companyContact]);
		}else{
			return view( 'errors.404' )->with(['transportCompany' => $transportEmissionCompany,'companyContact' =>$companyContact]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportCompanyRequest $request, $id)
	{
                    $user = Sentinel::getUser();
                    $Company = TransportEmissionCompany::find($id);      
                        $Company->emission_company_name=$request->name;
                        $Company->address=$request->address;                       
                        $Company->contact_details=$request->telephone_numbers; 										
                        $Company->updated_by=$user->id;  
                    $Company->save();    
		if($request->c_name != ''){		
                    $count=sizeof($request->c_name) -1;
                    
                    for ($x = 0; $x <= $count; $x++) {                      
                        if($request->c_name[$x] !=' '){
                            $cntactlist = companyContact::where('name','=',$request->c_name[$x])->where('companyId','=',$id)->where('companyType','=','E')->get();
                            $cntactlistCount = $cntactlist->count();                          
                            if($cntactlistCount !=0){
                                $contact = companyContact::find($cntactlist[0]->id);      
                                $contact->name=$request->c_name[$x];
                                $contact->companyId=$id; 
                                $contact->department=$request->c_department[$x]; 
                                $contact->contactNo=$request->c_number[$x]; 
                                $contact->email=$request->c_email[$x];                                
                                $contact->updated_by=$user->id;  
                                $Company->save();    
                            }else{
                                $companyContact= companyContact::create([			
                                        'name'=>$request->c_name[$x],
                                        'companyId'=>$id,                       
                                        'department'=>$request->c_department[$x], 
                                        'contactNo'=>$request->c_number[$x], 
                                        'email'=>$request->c_email[$x], 
                                        'companyType'=>'E',                                      					
                                        'created_by'=>$user->id
                                ]);
                            }
                        }
                    }
                }
					
		return redirect('transportEmissionCompany/list')->with([ 'success' => true,
			'success.message'=> 'Emission Company Update successfully!',
			'success.title' => 'Well Done!']);
	}
	
	/**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
		$transportEmissionCompany= TransportEmissionCompany::find($id);
		$companyContact= companyContact::where('companyId','=',$id)->where('companyType','=','E')->get();
		if($transportEmissionCompany){
			return view( 'transportEmissionCompany::view' )->with(['transportCompany' => $transportEmissionCompany,'companyContact' =>$companyContact]);
		}else{
			return view( 'errors.404' )->with(['transportCompany' => $transportEmissionCompany,'companyContact' =>$companyContact]);
		}
	}
	
	
}
