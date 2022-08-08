<?php
namespace Sammy\TransportLogSheet\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Sammy\TransportRoute\Http\Requests\TransportRouteRequest;
use Sammy\TransportRoute\Models\TransportRoute;
use Sammy\TransportCompany\Models\TransportCompany;
use App\Models\Maker;
use App\Models\LorryModel;
use Sammy\TransportLogSheet\Models\TransportLogSheet;
use Sammy\TransportLogSheet\Models\TransportLogSheetRout;
use App\Models\InsuranceCompanies;
use App\Models\EmissionCompanies;
use App\Models\LeasingCompanies;
use Sammy\TransportLorry\Models\TransportLorry;
use Sammy\TransportLorry\Http\Requests\TransportLorryRequest;
use Sammy\TransportLorryMaintain\Http\Requests\TransportLorryMaintainRequest;
use Sammy\TransportLorryMaintain\Models\TransportLorryMaintain;
use Sammy\TransportChargin\Models\TransportChargin;
use Sammy\TransportCustomer\Models\TransportCustomer;
use Sammy\TransportLorryRepair\Http\Requests\TransportLorryRepairRequest;
use Sammy\TransportLorryRepair\Models\TransportLorryRepair;
use Sammy\TransportLorryRepair\Models\TransportPartRepair;
use Sammy\TransportLorryFule\Http\Requests\TransportLorryFuleRequest;
use Sammy\TransportLorryFule\Models\TransportLorryFule;
use Sammy\TransportSupplier\Models\TransportSupplier;
use Sammy\TransportEmployee\Models\TransportEmployee;
use Sammy\TransportLorryFule\Models\TransportLorryFuleInvoice;
use Sammy\TransportLogSheet\Http\Requests\TransportLogSheetRequest;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;
use Dompdf\Dompdf;
class TransportLogSheetController extends Controller {

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
        $route= TransportRoute::all()->lists('route_name' , 'id' ); 
        $driver= TransportEmployee::all()->lists('full_name' , 'id' );
            return view( 'transportLogSheet::add' )->with([
                    'lorry' => $lorry,
                    'driver'=>$driver,
                    'route' => $route   
		]);
	
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportLogSheetRequest $request)
	{
                $user = Sentinel::getUser();
                
                    $transportaRoute= TransportLogSheet::create([
                            'logsheetdate'=>$request->date,
                            'logsheetNo'=>$request->sheetNumber,
                            'driverid'=>$request->driver,
                            'helperid'=>$request->helper,  
                            'lorryId'=>$request->lorry,
                            'invoiceNo'=>$request->invoice,
                            'startTime'=>$request->startTime,
                            'endTime'=>$request->endDate,
                            'startMiter'=>$request->startVehicleMeter,
                            'endMiter'=>$request->endVehicleMeter,
                            'tripDescription'=>$request->tripdescription,
                            'costDescription'=>$request->costdescription,
                            'costTotal'=>$request->chargers,
                            'paymentStatus'=>$request->payable,
                            'description'=>$request->otherdescription,
                            'created_by'=>$user->id	
                            
                            
                    ])->id;
                    
                    
                    foreach ($request->route as $key => $value) {			
                        $route= TransportLogSheetRout::create([
                            'logsheet'=>$transportaRoute,
                            'route'=>$value,                            
                            'created_by'=>$user->id	
                            ])->id;   
                    }
                    
                    
                    
		return redirect( 'transportLogSheet/add' )->with([ 'success' => true,
			'success.message' => 'Log sheet added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportLogSheet::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLogSheet::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $lorry= TransportLorry::where('id',$value->lorryId)->first(); 
                                $licence_plate=$lorry['licence_plate'];
                   
				array_push($rowData,$i);                               
                                array_push($rowData,$licence_plate);                
				array_push($rowData,$value->logsheetNo);			
				array_push($rowData,$value->logsheetdate);
                                
                                if($value->paymentStatus ==1){
                                    array_push($rowData,'Payable');
                                }else{
                                    array_push($rowData,'Non-Payable');
                                }
                                
                                
                                
				$permissions = Permission::whereIn('name', ['logsheet.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLogSheet/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Fule Record"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

                                
                                $permissions = Permission::whereIn('name', ['logsheet.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLogSheet/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Fule Record"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-eye"></i></a>');
				}
                                
				$permissions = Permission::whereIn('name', ['logsheet.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Fule Record"><i class="fa fa-trash-o"></i></a>');
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
			$logsheet = TransportLogSheet::find($id);                         
			if($logsheet){
                                    $logsheet->delete();
                                    $lorry = TransportLogSheetRout::where('logsheet','=',$id);		
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
            $logsheet= TransportLogSheet::find($id);
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $route= TransportRoute::all()->lists('route_name' , 'id' ); 
            $driver= TransportEmployee::all()->lists('full_name' , 'id' );            
            $curUserold =TransportLogSheetRout::where('logsheet','=',$logsheet->id)->get();              
	    $srole = array();
	    foreach ($curUserold as $key => $value) {
	    	array_push($srole, $value->route);
	    }                      
            
            if($logsheet){   
                return view( 'transportLogSheet::edit' )->with([
                        'lorry' => $lorry,
                        'driver'=>$driver,
                        'route' => $route,
                        'srole'=>$srole,
                        'logsheet'=>$logsheet
                    ]);
            }else{
			return view( 'errors.404' )->with(['logsheet' => $logsheet ]);
            }      
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportLogSheetRequest $request, $id)
	{
          
            
                            $user = Sentinel::getUser();
                            $Logsheet = TransportLogSheet::find($id);  
                            $Logsheet->logsheetdate=$request->date;
                            $Logsheet->logsheetNo=$request->sheetNumber;
                            $Logsheet->driverid=$request->driver;							
                            $Logsheet->helperid=$request->helper;
                            $Logsheet->lorryId=$request->lorry;
                            $Logsheet->invoiceNo=$request->invoice;
                            $Logsheet->startTime=$request->startTime;
                            $Logsheet->endTime=$request->endDate;                     
                            $Logsheet->startMiter=$request->startVehicleMeter;
                            $Logsheet->endMiter=$request->endVehicleMeter;
                            $Logsheet->tripDescription=$request->tripdescription;
                            $Logsheet->costDescription=$request->costdescription;
                            $Logsheet->costTotal=$request->chargers;                            
                            $Logsheet->paymentStatus=$request->payable;
                            $Logsheet->description=$request->otherdescription;                            
                            $Logsheet->save(); 
                            
                    $lorry = TransportLogSheetRout::where('logsheet','=',$id);		
                    $lorry->delete();         
                    
                    foreach ($request->route as $key => $value) {			
                        $route= TransportLogSheetRout::create([
                            'logsheet'=>$id,
                            'route'=>$value,                            
                            'created_by'=>$user->id	
                            ])->id;   
                    }       
                                                                                   
                            
		return redirect('transportLogSheet/list')->with([ 'success' => true,
			'success.message'=> 'Log sheet update successfully!',
			'success.title' => 'Well Done!']);
	}

        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
            $logsheet= TransportLogSheet::find($id);
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $route= TransportRoute::all()->lists('route_name' , 'id' ); 
            $driver= TransportEmployee::all()->lists('full_name' , 'id' );            
            $curUserold =TransportLogSheetRout::where('logsheet','=',$logsheet->id)->get();              
	    $srole = array();
	    foreach ($curUserold as $key => $value) {
	    	array_push($srole, $value->route);
	    } 
            
            if($logsheet){   
                return view( 'transportLogSheet::view' )->with([
                        'lorry' => $lorry,
                        'driver'=>$driver,
                        'route' => $route,
                        'srole'=>$srole,
                        'logsheet'=>$logsheet
                ]);
            }else{
			return view( 'errors.404' )->with(['logsheet' => $logsheet ]);
            }           
            
	}   
        
        
           /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsongetlogsheetlist($lorry,$trip)
	{
            
                    $data =DB::table('muthumala_logsheet')  
                          ->join('muthumala_logsheet_routes','muthumala_logsheet_routes.logsheet','=','muthumala_logsheet.id')
                          ->where(['muthumala_logsheet.lorryId' => $lorry, 'muthumala_logsheet_routes.route' => $trip])
                          ->select('muthumala_logsheet_routes.*','muthumala_logsheet.*','muthumala_logsheet.id as logsheetId')  
                          ->get();
                        $jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                              
                                $transport= TransportRoute::where('id',$value->route)->first(); 
                                $transportRout=$transport['route_name'];
                                
                               
				array_push($rowData,$i);                               
                                array_push($rowData,$transportRout);                
				array_push($rowData,$value->logsheetNo);
                                array_push($rowData,$value->logsheetId);
                                if($value->paymentStatus==1){
                                    array_push($rowData,'Payable');
                                }else{
                                    array_push($rowData,'Non-Payable');
                                }
                                
//				array_push($rowData,$supplier['suppliers_name']);
//				array_push($rowData,$value->amount);			
//                                array_push($rowData,$value->vehicleMeter);
//				array_push($rowData, '<input type="checkbox" class="messageCheckbox" name="trip[]" value="' . $value->id . '">');
                                array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json($jsonList);

		//}else{
			//return Response::json(array('data'=>[]));
		//}
	}
        
        
        
        
        
}
