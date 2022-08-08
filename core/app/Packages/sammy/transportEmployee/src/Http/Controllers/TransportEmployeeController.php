<?php
namespace Sammy\TransportEmployee\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Response;

use Sammy\TransportRoute\Http\Requests\TransportRouteRequest;
use Sammy\TransportRoute\Models\TransportRoute;
use Sammy\TransportCompany\Models\TransportCompany;
use Sammy\TransportEmployee\Models\Designation;
use Sammy\TransportEmployee\Models\TransportEmployee;
use Sammy\TransportEmployee\Http\Requests\TransportEmployeeRequest;
use Sentinel;

class TransportEmployeeController extends Controller {

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
                $designation= Designation::all()->lists('designation' , 'id' );
		return view( 'transportEmployee::add' )->with([
                    'designation' => $designation,                   
		]);
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportEmployeeRequest $request)
	{
                $user = Sentinel::getUser();
                
                $attachmentFile=$request->file('document');
                $attachment='';
                            if($attachmentFile !=""){
                                    $destinationPath = 'employeee/'.$request->nic;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='employeee_'.date('Y_m_d').$request->nic.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            } 
                
                $Employeelist = TransportEmployee::withTrashed()->get();
                $EmployeelistCount = $Employeelist->count();  
                $value=$EmployeelistCount+1;
                $employeeCode='EMP'.$value;
		$transportaRoute= TransportEmployee::create([
                        'employee_code'=>$employeeCode,
			'first_name'=>$request->first_name,
			'employee_no'=>$request->employee_number,
                        'last_name'=>$request->last_name,
                        'full_name'=>$request->full_name,
                        'nickName'=>$request->nickName,
                        'designation'=>$request->designation,
                        'startDate'=>$request->startDate,
                        'nic'=>$request->nic,
                        'image'=>$attachment,
                        'passport'=>$request->Passport,
                        'epf_number'=>$request->epf_number,
                        'address'=>$request->address,
                        'street'=>$request->street,
                        'city'=>$request->city,
                        't_telephone_numbers'=>$request->t_telephone_numbers,
                        'eip'=>$request->eip,
                        'emergency_contact'=>$request->emergency_numbers,                   
                        'branch'=>$request->branch,
                        'bankName'=>$request->bankName,
                        'bankAccount'=>$request->bankAccount,                    
                        'contact_mobile'=>$request->telephone_numbers,
                        'created_by'=>$user->id
                    
		]);

		return redirect( 'transportEmployee/add' )->with([ 'success' => true,
			'success.message' => 'Employee added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportEmployee::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportEmployee::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
				array_push($rowData,$i);
				array_push($rowData,$value->employee_code);
				array_push($rowData,$value->employee_no);
				array_push($rowData,$value->full_name);
                                array_push($rowData,$value->nic);
                                array_push($rowData,$value->epf_number);

				$permissions = Permission::whereIn('name', ['employee.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportEmployee/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Employee"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
				
				$permissions = Permission::whereIn('name', ['employee.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportEmployee/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Employee"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-eye"></i></a>');
				}

				$permissions = Permission::whereIn('name', ['employee.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Employee"><i class="fa fa-trash-o"></i></a>');
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

			$permission = TransportEmployee::find($id);
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
	{	$designation= Designation::all()->lists('designation' , 'id' );
		
		$transportEmployee= TransportEmployee::where('id','=',$id)->first();
		if($transportEmployee){
			return view( 'transportEmployee::edit' )->with(['transportEmployee' => $transportEmployee,'designation' => $designation ]);
		}else{
			return view( 'errors.404' )->with(['transportEmployee' => $transportEmployee,'designation' => $designation ]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportEmployeeRequest $request, $id)
	{
                $user = Sentinel::getUser();
		$Employee = TransportEmployee::find($id);
                $attachmentFile=$request->file('document');
                $attachment=$Employee->image;
                            if($attachmentFile !=""){
                                    $destinationPath = 'employeee/'.$request->nic;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='employeee_'.date('Y_m_d').$request->nic.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            }             
                                   
                $Employee->designation=$request->designation;
                $Employee->startDate=$request->startDate;
                $Employee->nickName=$request->nickName;
                $Employee->street=$request->street;                
                $Employee->city=$request->city;
                $Employee->t_telephone_numbers=$request->t_telephone_numbers;
                $Employee->eip=$request->eip;
                $Employee->emergency_contact=$request->emergency_numbers;
                $Employee->branch=$request->branch;
                $Employee->bankName=$request->bankName;
                $Employee->bankAccount=$request->bankAccount;                      
                $Employee->image=$attachment;      
                $Employee->first_name=$request->first_name;
		$Employee->employee_no=$request->employee_number;
                $Employee->last_name=$request->last_name;
                $Employee->full_name=$request->full_name;
                $Employee->nic=$request->nic;
                $Employee->passport=$request->Passport;
                $Employee->epf_number=$request->epf_number;
                $Employee->address=$request->address;
                $Employee->contact_mobile=$request->telephone_numbers;
                $Employee->updated_by=$user->id;	
		$Employee->save();    
		return redirect('transportEmployee/list')->with([ 'success' => true,
			'success.message'=> 'Employee Update successfully!',
			'success.title' => 'Well Done!']);
	}
	
	/**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
		$transportEmployee= TransportEmployee::where('id','=',$id)->first();
                $designation= Designation::all()->lists('designation' , 'id' );
		if($transportEmployee){
			return view( 'transportEmployee::view' )->with(['transportEmployee' => $transportEmployee,'designation' => $designation ]);
		}else{
			return view( 'errors.404' )->with(['transportEmployee' => $transportEmployee,'designation' => $designation ]);
		}
	}
}
