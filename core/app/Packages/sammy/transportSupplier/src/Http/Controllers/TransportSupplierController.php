<?php
namespace Sammy\TransportSupplier\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Response;
use App\Models\companyContact;
use Sammy\TransportChargin\Http\Requests\TransportCharginRequest;
use Sammy\TransportChargin\Models\TransportChargin;
use Sammy\TransportCustomer\Http\Requests\TransportCustomerRequest;
use Sammy\TransportCustomer\Models\TransportCustomer;
use Sammy\TransportSupplier\Http\Requests\TransportSupplierRequest;
use Sammy\TransportSupplier\Models\TransportSupplier;
use Sentinel;


class TransportSupplierController extends Controller {

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
		return view( 'transportSupplier::add' );
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportSupplierRequest $request)
	{
            
                $user = Sentinel::getUser();
                
                $isadd= TransportSupplier::where('suppliers_name','=',$request->name)->where('type','=',$request->type)->get();
                $isaddCount=$isadd->count();                 
                if($isaddCount == 0){
                    $customerlist = TransportSupplier::withTrashed()->get();
                    $customerlistCount = $customerlist->count();  
                    $value=$customerlistCount+1;
                    $customerCode='SUP'.$value;
                  
                    $transportaRoute= TransportSupplier::create([
                            'suppliers_name'=>$request->name,
                            'supplier_code'=>$customerCode,
                            'type'=>$request->type,
                            'address'=>$request->address,
                            'telephone_number'=>$request->telephone,
                            'fax_number'=>$request->fax,
                            'email'=>$request->email,
                            'vatNumber'=>$request->vat,
                            'bankAccount'=>$request->bankAccount,
                            'branch'=>$request->branch,
                            'creditLimit'=>$request->credit,
                            'created_by'=>$user->id                    
                    ])->id;
                    
                     if(isset($request->c_name)){
                        $count=sizeof($request->c_name)-1;                    
                          for ($x = 0; $x <= $count; $x++) {                      
                              if($request->c_name[$x] !=' '){
                                  $cntactlist = companyContact::where('name','=',$request->c_name[$x])->where('companyId','=',$transportaRoute)->where('companyType','=','S')->get();
                                  $cntactlistCount = $cntactlist->count();                          
                                  if($cntactlistCount !=0){
                                      $contact = companyContact::find($cntactlist[0]->id);      
                                      $contact->name=$request->c_name[$x];
                                      $contact->companyId=$transportaRoute; 
                                      $contact->department=$request->c_department[$x]; 
                                      $contact->contactNo=$request->c_number[$x]; 
                                      $contact->email=$request->c_email[$x];                                
                                      $contact->updated_by=$user->id;  
                                      $contact->save();    
                                  }else{
                                      $companyContact= companyContact::create([			
                                              'name'=>$request->c_name[$x],
                                              'companyId'=>$transportaRoute,                       
                                              'department'=>$request->c_department[$x], 
                                              'contactNo'=>$request->c_number[$x], 
                                              'email'=>$request->c_email[$x], 
                                              'companyType'=>'S',                                      					
                                              'created_by'=>$user->id
                                      ]);
                                  }
                              }
                          } 
                    }

                    return redirect( 'transportSupplier/add' )->with([ 'success' => true,
                            'success.message' => 'Supplier added successfully!',
                            'success.title'   => 'Well Done!' ]);
                }else{
                    return redirect( 'transportSupplier/add' )->with([ 'error' => true,
			'error.message' => 'Supplier alredy added !',
			'error.title'   => 'Try again!' ]);
                }
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportSupplier::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
			$data = TransportSupplier::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
				array_push($rowData,$i);
				array_push($rowData,$value->supplier_code);
				array_push($rowData,$value->suppliers_name);
				$permissions = Permission::whereIn('name', ['supplier.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportSupplier/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Supplier"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

                                $permissions = Permission::whereIn('name', ['supplier.view', 'admin'])->where('status', '=', 1)->lists('name');

                                if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportSupplier/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Supplier"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-eye"></i></a>');
				}

                                
				$permissions = Permission::whereIn('name', ['supplier.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Supplier"><i class="fa fa-trash-o"></i></a>');
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
			$Customer = TransportSupplier::find($id);
			if($Customer){
                            $Customer->delete();
                            $contacts = companyContact::where('companyId','=',$id)->where('companyType','=','S');
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
		$customer = TransportSupplier::find($id);
                $companyContact= companyContact::where('companyId','=',$id)->where('companyType','=','S')->get();
		if($customer){
			return view( 'transportSupplier::edit' )->with(['customer' => $customer,'companyContact' =>$companyContact]);
		}else{
			return view( 'errors.404' )->with(['customer' => $customer,'companyContact' =>$companyContact]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportCustomerRequest $request, $id)
	{
		$user = Sentinel::getUser(); 
                $Customer = TransportSupplier::find($id);     
                $Customer->suppliers_name=$request->name;		
                $Customer->type=$request->type;
                $Customer->address=$request->address;
                $Customer->telephone_number=$request->telephone;
                $Customer->fax_number=$request->fax;
                $Customer->email=$request->email;   
                $Customer->vatNumber=$request->vat;
                $Customer->bankAccount=$request->bankAccount;
                $Customer->branch=$request->branch;
                $Customer->creditLimit=$request->credit;
                $Customer->updated_by=$user->id;      
		$Customer->save(); 
                            
               if($request->c_name != ''){ 
                $contactCount=sizeof($request->c_name);
                $count=$contactCount-1;                    
                    for ($x = 0; $x <= $count; $x++) {                      
                        if($request->c_name[$x] !=' '){
                            $cntactlist = companyContact::where('name','=',$request->c_name[$x])->where('companyId','=',$id)->where('companyType','=','S')->get();
                            $cntactlistCount = $cntactlist->count();                          
                            if($cntactlistCount !=0){
                                $contact = companyContact::find($cntactlist[0]->id);      
                                $contact->name=$request->c_name[$x];
                                $contact->companyId=$id; 
                                $contact->department=$request->c_department[$x]; 
                                $contact->contactNo=$request->c_number[$x]; 
                                $contact->email=$request->c_email[$x];                                
                                $contact->updated_by=$user->id;  
                                $contact->save();    
                            }else{
                                $companyContact= companyContact::create([			
                                        'name'=>$request->c_name[$x],
                                        'companyId'=>$id,                       
                                        'department'=>$request->c_department[$x], 
                                        'contactNo'=>$request->c_number[$x], 
                                        'email'=>$request->c_email[$x], 
                                        'companyType'=>'S',                                      					
                                        'created_by'=>$user->id
                                ]);
                            }
                        }
                    }     
               
            }
		return redirect('transportSupplier/list')->with([ 'success' => true,
			'success.message'=> 'Supplier Update successfully!',
			'success.title' => 'Well Done!']);
	}
        
        /**
	 * Show the menu view screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
		$customer = TransportSupplier::find($id);
                $companyContact= companyContact::where('companyId','=',$id)->where('companyType','=','S')->get();
		if($customer){
			return view( 'transportSupplier::view' )->with(['customer' => $customer,'companyContact' =>$companyContact]);
		}else{
			return view( 'errors.404' )->with(['customer' => $customer,'companyContact' =>$companyContact]);
		}
	}
}
