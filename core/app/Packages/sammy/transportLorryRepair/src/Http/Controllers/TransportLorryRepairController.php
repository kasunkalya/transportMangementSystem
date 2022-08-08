<?php
namespace Sammy\TransportLorryRepair\Http\Controllers;

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
use Sammy\TransportLorryRepair\Http\Requests\TransportLorryRepairRequest;
use Sammy\TransportLorryRepair\Models\TransportLorryRepair;
use Sammy\TransportLorryRepair\Models\TransportPartRepair;
use Sammy\TransportSupplier\Models\TransportSupplier;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;

class TransportLorryRepairController extends Controller {

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
        $service = TransportSupplier::where('type',2)->lists('suppliers_name' , 'id' );
            return view( 'transportLorryRepair::add' )->with([
                'lorry' => $lorry,
                'service' => $service                       
		]);
	
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportLorryRepairRequest $request)
	{
                $user = Sentinel::getUser();
                
                $attachmentFile=$request->file('document');
                $attachment='';
                            if($attachmentFile !=""){
                                    $destinationPath = 'lorryRepairRecords/'.$request->lorry;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_Repair_'.date('Y_m_d').$request->lorry.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            }                   
               
                    $transportaRoute= TransportLorryRepair::create([
                            'lorry'=>$request->lorry,
                            'repairDate'=>$request->repairdate,  
                            'garage'=>$request->garage,
                            'repairDiscription'=>$request->discription,
                            'repairCharge'=>$request->serviceChargers,
                            'vehicleMeter'=>$request->vehicleMeter,
                            'bill'=>$attachment,
                            'created_by'=>$user->id		
                    ])->id;
               
			   
                                    if(isset($request->part_name)){
						$count=sizeof($request->part_name)-1;                    
						  for ($x = 0; $x <= $count; $x++) {                      
							  if($request->part_name[$x] !=' '){                             
									  $companyContact= TransportPartRepair::create([			
											  'item'=>$request->part_name[$x],
											  'repair_id'=>$transportaRoute,                       
											  'serialcode'=>$request->serial_number[$x],
											  'created_by'=>$user->id
									  ]);
							  }
						  } 
					}
			   
			   

		return redirect( 'transportLorryRepair/add' )->with([ 'success' => true,
			'success.message' => 'Repair record added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportLorryRepair::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLorryRepair::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                    $lorry= TransportLorry::where('id',$value->lorry)->first(); 
                    $licence_plate=$lorry['licence_plate'];
                    $supplier= TransportSupplier::where('id',$value->garage)->first(); 
				array_push($rowData,$i);                               
                                array_push($rowData,$licence_plate);                
				array_push($rowData,$value->repairDate);
				array_push($rowData,$supplier['suppliers_name']);
				array_push($rowData,$value->repairCharge);			
                                array_push($rowData,$value->vehicleMeter);
				$permissions = Permission::whereIn('name', ['lorryRepair.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryRepair/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Repair Record"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

                                
                                $permissions = Permission::whereIn('name', ['lorryRepair.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryRepair/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Repair Record"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
				$permissions = Permission::whereIn('name', ['lorryRepair.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Repair Record"><i class="fa fa-trash-o"></i></a>');
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

			$lorry = TransportLorryRepair::find($id);
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
            $maintain= TransportLorryRepair::find($id);
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $spairpart = TransportPartRepair::where('repair_id','=',$id)->get();
            $service = TransportSupplier::where('type',1)->lists('suppliers_name' , 'id' );
            if($maintain){
                    return view( 'transportLorryRepair::edit' )->with([
                        'maintain'=>$maintain,
                        'spairpart'=>$spairpart,
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
				$LorryMaintain = TransportLorryRepair::find($id);  
                $attachmentFile=$request->file('document');
                $attachment=$LorryMaintain->bill;
                            if($attachmentFile !=""){
                                    $destinationPath = 'lorryRepairRecords/'.$request->lorry;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_Repair_'.date('Y_m_d').$request->lorry.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            }   
                       
                            $LorryMaintain->lorry=$request->lorry;
                            $LorryMaintain->repairDate=$request->repairdate;
                            $LorryMaintain->garage=$request->garage;							
                            $LorryMaintain->repairDiscription=$request->discription;
                            $LorryMaintain->repairCharge=$request->serviceChargers;
                            $LorryMaintain->vehicleMeter=$request->vehicleMeter;
                            $LorryMaintain->bill=$attachment;
                            $LorryMaintain->updated_by=$user->id;	
                            $LorryMaintain->save();                              
                           
                            \Illuminate\Support\Facades\DB::table('muthumala_repair_parts')->where('repair_id',$id)->delete();
                                
                                        if(isset($request->part_name)){
						$count=sizeof($request->part_name)-1;                    
						  for ($x = 0; $x <= $count; $x++) {                      
							  if($request->part_name[$x] !=' '){                             
									  $companyContact= TransportPartRepair::create([			
											  'item'=>$request->part_name[$x],
											  'repair_id'=>$id,                       
											  'serialcode'=>$request->serial_number[$x],
											  'created_by'=>$user->id
									  ]);
							  }
						  } 
					}        
                            
		return redirect('transportLorryRepair/list')->with([ 'success' => true,
			'success.message'=> 'Lorry Repair Record Update successfully!',
			'success.title' => 'Well Done!']);
	}

        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
            $maintain= TransportLorryRepair::find($id);
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $spairpart = TransportPartRepair::where('repair_id','=',$id)->get();
            $service = TransportSupplier::where('type',1)->lists('suppliers_name' , 'id' );
            if($maintain){
                return view( 'transportLorryRepair::view' )->with([
                    'maintain'=>$maintain,
                    'spairpart'=>$spairpart,
                    'service'=>$service,
                    'lorry'=>$lorry
                ]);
		}else{
			return view( 'errors.404' )->with(['lorry' => $lorry ]);
		}
	}

}
