<?php
namespace Sammy\TransportCompany\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Sammy\TransportRoute\Http\Requests\TransportRouteRequest;
use Sammy\TransportRoute\Models\TransportRoute;
use Sammy\TransportCompany\Models\TransportCompany;
use Sammy\TransportCompany\Http\Requests\TransportCompanyRequest;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;


class TransportCompanyController extends Controller {

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
		return view( 'transportCompany::add' );
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportCompanyRequest $request)
	{
                $user = Sentinel::getUser();
                $companylist = TransportCompany::withTrashed()->get();
                $companylistCount = $companylist->count();  
                $value=$companylistCount+1;
                $companyCode='COM-'.$value;
                $brAttachment=$request->file('brcopy');
                $attachment='';

                            if($brAttachment !=""){
                                    $destinationPath = 'companyAttachments/'.$companyCode;
                                    $brAttachmentname = $brAttachment->getClientOriginalName();
                                    $extension = $brAttachment->getClientOriginalExtension();
                                    $brAttachmentname='company_atachmnet_'.$companyCode.'.'.$extension;
                                    $upload_success = $brAttachment->move($destinationPath,$brAttachmentname);
                                    $attachment=$brAttachmentname;
                            }
                
		$transportCompany= TransportCompany::create([
			'company_code'=>$companyCode,
                        'company_name'=>$request->name,
                        'company_address'=>$request->address,
                        'register_number'=>$request->register_number,                       
                        'vat_number'=>$request->vat_number,
			'etf_number'=>$request->etf_number,
			'epf_number'=>$request->epf_number,
                        'br_number'=>$request->br_number,
                        'short_code'=>$request->short_code,
                        'start_date'=>$request->start_date,
                        'telephone_numbers'=>$request->telephone_numbers,
                        'fax_numbers'=>$request->fax_numbers,
                        'email'=>$request->email,
                        'websites'=>$request->websites,
                        'brcopy'=>$attachment,
                        'created_by'=>$user->id
                    
		]);

		return redirect( 'transportCompany/add' )->with([ 'success' => true,
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
		return view( 'transportCompany::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportCompany::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
				array_push($rowData,$i);
				array_push($rowData,$value->company_code);
				array_push($rowData,$value->company_name);

				$permissions = Permission::whereIn('name', ['company.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportCompany/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Company"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
                                $permissions = Permission::whereIn('name', ['company.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportCompany/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Company"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-eye"></i></a>');
				}

				$permissions = Permission::whereIn('name', ['company.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Company"><i class="fa fa-trash-o"></i></a>');
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

			$company = TransportCompany::find($id);
			if($company){
				$company->delete();
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
		$transportCompany= TransportCompany::find($id);
		if($transportCompany){
			return view( 'transportCompany::edit' )->with(['transportCompany' => $transportCompany ]);
		}else{
			return view( 'errors.404' )->with(['transportCompany' => $transportCompany ]);
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
                    $Company =  TransportCompany::find($id);                     
                    $brAttachment=$request->file('brcopy');        
                    $companyCode=$Company->company_code;
                    $attachment=$Company->brcopy;
                            if($brAttachment !=""){
                                    $destinationPath = 'companyAttachments/'.$companyCode;
                                    $brAttachmentname = $brAttachment->getClientOriginalName();
                                    $extension = $brAttachment->getClientOriginalExtension();
                                    $brAttachmentname='company_atachmnet_'.$companyCode.'.'.$extension;
                                    $upload_success = $brAttachment->move($destinationPath,$brAttachmentname);
                                    $attachment=$brAttachmentname;
                            }
                
                        $Company->company_name=$request->get( 'name' );
                        $Company->company_address=$request->get( 'address' );
                        $Company->register_number=$request->get( 'register_number' );                       
                        $Company->vat_number=$request->get( 'vat_number' );
			$Company->epf_number=$request->get( 'epf_number' );
			$Company->etf_number=$request->get( 'etf_number' );
                        $Company->br_number=$request->get( 'br_number' );
                        $Company->short_code=$request->get( 'short_code' );
                        $Company->start_date=$request->get( 'start_date' );
			$Company->telephone_numbers=$request->get( 'telephone_numbers' );
                        $Company->fax_numbers=$request->get( 'fax_numbers' );
                        $Company->email=$request->get( 'email' );
                        $Company->websites=$request->get( 'websites' );
                        $Company->brcopy=$attachment;    
                        $Company->updated_by=$user->id;  
		$Company->save();    
		return redirect('transportCompany/list')->with([ 'success' => true,
			'success.message'=> 'Company Update successfully!',
			'success.title' => 'Well Done!']);
	}
        
        
        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
		$transportCompany= TransportCompany::find($id);
		if($transportCompany){
			return view( 'transportCompany::view' )->with(['transportCompany' => $transportCompany ]);
		}else{
			return view( 'errors.404' )->with(['transportCompany' => $transportCompany ]);
		}
	}
}
