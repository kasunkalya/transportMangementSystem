<?php
namespace Sammy\TransportLorryMaintain\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Sammy\TransportRoute\Http\Requests\TransportRouteRequest;
use Sammy\TransportRoute\Models\TransportRoute;
use Sammy\TransportCompany\Models\TransportCompany;
use App\Models\Maker;
use App\Models\LorryModel;
use App\Models\InsuranceCompanies;
use App\Models\EmissionCompanies;
use App\Models\LeasingCompanies;
use Sammy\TransportLorry\Models\TransportLorry;
use Sammy\TransportLorry\Http\Requests\TransportLorryRequest;
use Sammy\TransportLorryMaintain\Http\Requests\TransportLorryMaintainRequest;
use Sammy\TransportLorryMaintain\Models\TransportLorryMaintain;
use Sammy\TransportSupplier\Models\TransportSupplier;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;

class TransportLorryMaintainController extends Controller {

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
        $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
        $service =TransportSupplier::where('type',3)->lists('suppliers_name' , 'id' );
            return view( 'transportLorryMaintain::add' )->with([
                'lorry' => $lorry,
                'service' => $service    
		]);
	
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportLorryRequest $request)
	{
                $user = Sentinel::getUser();
                
                $attachmentFile=$request->file('document');
                $attachment='';
                            if($attachmentFile !=""){
                                    $destinationPath = 'lorryServiceRecords/'.$request->lorry;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_Service_'.date('Y_m_d').$request->lorry.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            }                   
               
                    $transportaRoute= TransportLorryMaintain::create([
                            'lorry'=>$request->lorry,
                            'servicesDate'=>$request->servicedate,  
                            'serviceStation'=>$request->serviceStation,  
                            'miter'=>$request->vehicleMeter,  
                            'servicesDiscription'=>$request->discription,
                            'serviceCharge'=>$request->serviceChargers,
                            'nextServiceMilage'=>$request->nextServiceMilage,
                            'bill'=>$attachment,
                            'created_by'=>$user->id		
                    ]);
               

		return redirect( 'transportLorryMaintain/add' )->with([ 'success' => true,
			'success.message' => 'Maintain record added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportLorryMaintain::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLorryMaintain::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                    $lorry= TransportLorry::where('id',$value->lorry)->first(); 
                    $supplier= TransportSupplier::where('id',$value->serviceStation)->first(); 
                    $licence_plate=$lorry['licence_plate'];
				array_push($rowData,$i);                               
                                array_push($rowData,$licence_plate);                
				array_push($rowData,$value->servicesDate);
				array_push($rowData,$supplier['suppliers_name']);
				array_push($rowData,$value->serviceCharge);
				array_push($rowData,$value->nextServiceMilage);				

				$permissions = Permission::whereIn('name', ['lorryMaintain.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryMaintain/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Maintain Record"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
                                $permissions = Permission::whereIn('name', ['lorryMaintain.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryMaintain/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Maintain Record"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-eye"></i></a>');
				}


				$permissions = Permission::whereIn('name', ['lorryMaintain.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Maintain Record"><i class="fa fa-trash-o"></i></a>');
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

			$lorry = TransportLorryMaintain::find($id);
			if($lorry){
				$lorry->delete();
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
		$maintain= TransportLorryMaintain::find($id);
                $service =TransportSupplier::all()->where('type',3)->lists('supplier_name','id');
                $lorry = TransportLorry::all()->lists('licence_plate','id' );
		if($maintain){
            return view( 'transportLorryMaintain::edit' )->with([
                'maintain'=>$maintain,
                'service'=>$service,
                'lorry'=>$lorry
            ]);
		}else{
			return view( 'errors.404' )->with(['lorry' => $lorry ]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportLorryRequest $request, $id)
	{
            
                $user = Sentinel::getUser();  
		$LorryMaintain = TransportLorryMaintain::find($id);  
                $attachmentFile=$request->file('document');
                $attachment=$LorryMaintain->bill;
                            if($attachmentFile !=""){
                                    $destinationPath = 'lorryServiceRecords/'.$request->lorry;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_Service_'.date('Y_m_d').$request->lorry.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            }   
                       
                            $LorryMaintain->lorry=$request->lorry;
                            $LorryMaintain->servicesDate=$request->servicedate;
                            $LorryMaintain->serviceStation=$request->serviceStation;
                            $LorryMaintain->miter=$request->vehicleMeter;
                            $LorryMaintain->servicesDiscription=$request->discription;
                            $LorryMaintain->serviceCharge=$request->serviceChargers;
                            $LorryMaintain->nextServiceMilage=$request->nextServiceMilage;
                            $LorryMaintain->bill=$attachment;
                            $LorryMaintain->updated_by=$user->id;	
							$LorryMaintain->save();    
		return redirect('transportLorryMaintain/list')->with([ 'success' => true,
			'success.message'=> 'Lorry Maintain Record Update successfully!',
			'success.title' => 'Well Done!']);
	}

        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
		$maintain= TransportLorryMaintain::find($id);
                $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
                $service =TransportSupplier::all()->where('type',3)->lists('suppliers_name','id');
		if($maintain){
                return view( 'transportLorryMaintain::view' )->with([
                    'maintain'=>$maintain,
                    'service'=>$service,
                    'lorry'=>$lorry
                ]);
		}else{
			return view( 'errors.404' )->with(['lorry' => $lorry ]);
		}
	}
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonexpireList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLorry::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();    
                                
                                $lorry= TransportLorryMaintain::where('lorry',$value->id)->orderBy('id', 'desc')->first(); 
                                $users = DB::table('muthumala_transport_trips')
                                        ->join('muthumala_transport_routes', 'muthumala_transport_trips.route_id', '=', 'muthumala_transport_routes.id')
                                        ->where('muthumala_transport_trips.lorry_id','=',$lorry['lorry'])
                                        ->whereDate('muthumala_transport_trips.invoice_date','>=',$lorry['servicesDate'])
                                        ->sum('muthumala_transport_routes.minDistance')
                                        ;
                                
                                $curetnRunMilage=$lorry['miter'] + $users;                                
                                $differance=$lorry['nextServiceMilage'] - $curetnRunMilage;
                                
                                
                                if($differance <= 500 && $differance > 0){
                                    array_push($rowData,$value->licence_plate);
                                    array_push($rowData,$lorry['miter']);
                                    array_push($rowData,$lorry['nextServiceMilage']);
                                    array_push($rowData,$curetnRunMilage);
                                    array_push($rowData,$differance);
                                    array_push($rowData,$users);
                                    array_push($rowData,'U'); 
                                    array_push($jsonList, $rowData);
                                }
                                elseif($differance <= 0 && $users !=''){
                                    array_push($rowData,$value->licence_plate);
                                    array_push($rowData,$lorry['miter']);
                                    array_push($rowData,$lorry['nextServiceMilage']);
                                    array_push($rowData,$curetnRunMilage);
                                    array_push($rowData,$differance);
                                    array_push($rowData,$users);
                                    array_push($rowData,'D'); 
                                    array_push($jsonList, $rowData);
                                }
                                
				
				$i++;

			}
                     
			return Response::json($jsonList);

		//}else{
			//return Response::json(array('data'=>[]));
		//}
	}

         

}
