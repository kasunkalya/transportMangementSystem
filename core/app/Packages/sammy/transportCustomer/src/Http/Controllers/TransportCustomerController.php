<?php
namespace Sammy\TransportCustomer\Http\Controllers;

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
use Illuminate\Support\Facades\DB;
use Sentinel;

class TransportCustomerController extends Controller {

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
		$muthumalaInvoice= DB::table('muthumala_document_layout')->where('document_type_id','=',1)->lists('document_name' , 'document_layout_id' );  	
		$muthumalaInvoiceSummary= DB::table('muthumala_document_layout')->where('document_type_id','=',2)->lists('document_name' , 'document_layout_id' );  	
		return view( 'transportCustomer::add' )->with(['muthumalaInvoice' => $muthumalaInvoice,'muthumalaInvoiceSummary' => $muthumalaInvoiceSummary]);
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportCustomerRequest $request)
	{
                $user = Sentinel::getUser();
                
                $isadd=TransportCustomer::where('customer_name','=',$request->name)->get();
                $isaddCount=$isadd->count();                 
                if($isaddCount == 0){
                    $customerlist = TransportCustomer::withTrashed()->get();
                    $customerlistCount = $customerlist->count();  
                    $value=$customerlistCount+1;
                    $customerCode='CU'.$value;
                    
                    $attachmentFile=$request->file('customer_contract_document');
                    $attachment='';
                    if($attachmentFile !=""){
                        $destinationPath = 'contractdocument/'.$customerCode;
                        $attachmentFilename = $attachmentFile->getClientOriginalName();
                        $extension = $attachmentFile->getClientOriginalExtension();
                        $attachmentFilename='contract_document'.$customerCode.'.'.$extension;
                        $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                        $attachment=$attachmentFilename;
                    }   
                    
                    
                    $transportaRoute= TransportCustomer::create([
                            'customer_name'=>$request->name,
                            'customer_code'=>$customerCode,
                            'invoice_code'=>$request->invoice_code,
                            'other_name'=>$request->othername,
                            'address'=>$request->address,
                            'telephone_number'=>$request->telephone,
                            'fax_number'=>$request->fax,
                            'email'=>$request->email,
                            'contract_document'=>$attachment,
                            'website'=>$request->website,
                            'vatNumber'=>$request->vatNumber,
                            'customer_since'=>$request->start_date,    
							'invoiceLayoutId'=>$request->invoice,    
							'invoiceSummaryLayoutId'=>$request->invoiceSummary,    
                            'created_by'=>$user->id                    
                    ])->id;
                    
                     if(isset($request->c_name)){
                        $count=sizeof($request->c_name)-1;                    
                          for ($x = 0; $x <= $count; $x++) {                      
                              if($request->c_name[$x] !=' '){
                                  $cntactlist = companyContact::where('name','=',$request->c_name[$x])->where('companyId','=',$transportaRoute)->where('companyType','=','C')->get();
                                  $cntactlistCount = $cntactlist->count();                          
                                  if($cntactlistCount !=0){
                                      $contact = companyContact::find($cntactlist[0]->id);      
                                      $contact->name=$request->c_name[$x];
                                      $contact->companyId=$transportaRoute; 
                                      $contact->department=$request->c_department[$x]; 
                                      $contact->contactNo=$request->c_number[$x]; 
                                      $contact->email=$request->c_email[$x];                                
                                      $contact->updated_by=$user->id;  
                                      $Company->save();    
                                  }else{
                                      $companyContact= companyContact::create([			
                                              'name'=>$request->c_name[$x],
                                              'companyId'=>$transportaRoute,                       
                                              'department'=>$request->c_department[$x], 
                                              'contactNo'=>$request->c_number[$x], 
                                              'email'=>$request->c_email[$x], 
                                              'companyType'=>'C',                                      					
                                              'created_by'=>$user->id
                                      ]);
                                  }
                              }
                          } 
                    }

                    return redirect( 'transportCustomer/add' )->with([ 'success' => true,
                            'success.message' => 'Customer added successfully!',
                            'success.title'   => 'Well Done!' ]);
                }else{
                    return redirect( 'transportCustomer/add' )->with([ 'error' => true,
			'error.message' => 'Customer alredy added !',
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
		return view( 'transportCustomer::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
			$data = TransportCustomer::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
				array_push($rowData,$i);
				array_push($rowData,$value->customer_code);
				array_push($rowData,$value->customer_name);
				$permissions = Permission::whereIn('name', ['customer.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportCustomer/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Customer"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

                                $permissions = Permission::whereIn('name', ['customer.view', 'admin'])->where('status', '=', 1)->lists('name');

                                if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportCustomer/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Customer"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-eye"></i></a>');
				}

                                
				$permissions = Permission::whereIn('name', ['customer.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Customer"><i class="fa fa-trash-o"></i></a>');
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
			$Customer = TransportCustomer::find($id);
			if($Customer){
                            $Customer->delete();
                            $contacts = companyContact::where('companyId','=',$id)->where('companyType','=','C');
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
		$muthumalaInvoice= DB::table('muthumala_document_layout')->where('document_type_id','=',1)->lists('document_name' , 'document_layout_id' );  	
		$muthumalaInvoiceSummary= DB::table('muthumala_document_layout')->where('document_type_id','=',2)->lists('document_name' , 'document_layout_id' ); 		
		$customer = TransportCustomer::find($id);
        $companyContact= companyContact::where('companyId','=',$id)->where('companyType','=','C')->get();
		if($customer){
			return view( 'transportCustomer::edit' )->with(['customer' => $customer,'companyContact' =>$companyContact,'muthumalaInvoice' => $muthumalaInvoice,'muthumalaInvoiceSummary' => $muthumalaInvoiceSummary]);
		}else{
			return view( 'errors.404' )->with(['customer' => $customer,'companyContact' =>$companyContact,'muthumalaInvoice' => $muthumalaInvoice,'muthumalaInvoiceSummary' => $muthumalaInvoiceSummary]);
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
                $Customer = TransportCustomer::find($id);                 
                $customerCode=$request->code;
                   $attachmentFile=$request->file('customer_contract_document');
                    $attachment=$Customer->contract_document;
                    if($attachmentFile !=""){
                        $destinationPath = 'contractdocument/'.$customerCode;
                        $attachmentFilename = $attachmentFile->getClientOriginalName();
                        $extension = $attachmentFile->getClientOriginalExtension();
                        $attachmentFilename='contract_document'.$customerCode.'.'.$extension;
                        $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                        $attachment=$attachmentFilename;
                    }  
                
             
                 $Customer->invoice_code=$request->invoice_code;        
                $Customer->customer_name=$request->name;		
                $Customer->other_name=$request->othername;
                $Customer->address=$request->address;
                $Customer->telephone_number=$request->telephone;
                $Customer->fax_number=$request->fax;
                $Customer->email=$request->email;
                $Customer->website=$request->website;
                $Customer->contract_document=$attachment;                        
                $Customer->customer_since=$request->start_date;
                $Customer->vatNumber=$request->vatNumber;				
				$Customer->invoiceLayoutId=$request->invoice;   
				$Customer->invoiceSummaryLayoutId=$request->invoiceSummary;		
                $Customer->updated_by=$user->id;      
				$Customer->save(); 
            
               if($request->c_name != ''){ 
                $contactCount=sizeof($request->c_name);
                $count=$contactCount-1;                    
                    for ($x = 0; $x <= $count; $x++) {                      
                        if($request->c_name[$x] !=' '){
                            $cntactlist = companyContact::where('name','=',$request->c_name[$x])->where('companyId','=',$id)->where('companyType','=','C')->get();
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
                                        'companyType'=>'C',                                      					
                                        'created_by'=>$user->id
                                ]);
                            }
                        }
                    }     
               
            }
		return redirect('transportCustomer/list')->with([ 'success' => true,
			'success.message'=> 'Customer Update successfully!',
			'success.title' => 'Well Done!']);
	}
        
        /**
	 * Show the menu view screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
		$customer = TransportCustomer::find($id);
                $companyContact= companyContact::where('companyId','=',$id)->where('companyType','=','C')->get();
		if($customer){
			return view( 'transportCustomer::view' )->with(['customer' => $customer,'companyContact' =>$companyContact]);
		}else{
			return view( 'errors.404' )->with(['customer' => $customer,'companyContact' =>$companyContact]);
		}
	}
}
