<?php
namespace Sammy\TransportLorryChargers\Http\Controllers;

use Sammy\Permissions\Models\Permission;
use Sammy\TransportLorryChargers\Models\TransportLorryChargers;
use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Sammy\TransportRoute\Http\Requests\TransportRouteRequest;
use Sammy\TransportLorryChargers\Http\Requests\TransportLorryChargersRequest;
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
use Sammy\TransportChargin\Models\TransportChargin;
use Sammy\TransportChargin\Models\TransportCharginSub;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;

class TransportLorryChargersController extends Controller {

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
            $chargesType= TransportChargin::all()->lists('type_name' , 'id' );                                 
            return view( 'transportLorryChargers::add' )->with([
                'lorry' => $lorry,
                'route' => $route,
                'chargesTypes' => $chargesType
		]);
	
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportLorryChargersRequest $request)
	{
                $user = Sentinel::getUser();    
                    $transportaRoute= TransportLorryChargers::create([
                            'lorry_id'=>$request->lorry,
                            'charging_type_id'=>$request->chargingType,  
                            'charging_sub_type'=>$request->category, 
                            'route_id'=>$request->route,
                            'charges'=>$request->chargers,                            
                            'created_by'=>$user->id		
                    ]);
               

		return redirect( 'transportLorryChargers/add' )->with([ 'success' => true,
			'success.message' => 'Charging rule added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportLorryChargers::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLorryChargers::orderBy('lorry_id', 'desc')->get();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $lorry= TransportLorry::where('id',$value->lorry_id)->first(); 
                                $licence_plate=$lorry['licence_plate'];
                                
                                $route= TransportRoute::where('id',$value->route_id)->first(); 
                                $route_name=$route['route_name'];
                                
                                $chargesType= TransportChargin::where('id',$value->charging_type_id)->first(); 
                                $chargesType_name=$chargesType['type_name'];
                                
                                
				array_push($rowData,$i);                               
                                array_push($rowData,$licence_plate);                
				array_push($rowData,$route_name);
				array_push($rowData,$chargesType_name);
				array_push($rowData,$value->charges);			

				$permissions = Permission::whereIn('name', ['chargingRules.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryChargers/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Charging Rules "><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

                                $permissions = Permission::whereIn('name', ['chargingRules.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryChargers/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Charging Rules"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>');
				}
                                
				$permissions = Permission::whereIn('name', ['chargingRules.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Charging Rules"><i class="fa fa-trash-o"></i></a>');
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

			$lorry = TransportLorryChargers::find($id);
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
            $chargers= TransportLorryChargers::find($id);
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );  
            $route= TransportRoute::all()->lists('route_name' , 'id' ); 
            $chargesType= TransportChargin::all()->lists('type_name' , 'id' );                                 
            if($chargers){
                return view( 'transportLorryChargers::edit' )->with([
                'lorry' => $lorry,
                'route' => $route,
                'chargers' => $chargers,    
                'chargesTypes' => $chargesType
		]);
            }
            else{
                return view( 'errors.404' )->with(['lorry' => $lorry ]);
            }            
           
	}
        
        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
            $chargers= TransportLorryChargers::find($id);
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );  
            $route= TransportRoute::all()->lists('route_name' , 'id' ); 
            $chargesType= TransportChargin::all()->lists('type_name' , 'id' );                                 
            if($chargers){
                return view( 'transportLorryChargers::view' )->with([
                'lorry' => $lorry,
                'route' => $route,
                'chargers' => $chargers,    
                'chargesTypes' => $chargesType
		]);
            }
            else{
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
                            $LorryChargers = TransportLorryChargers::find($id);                         
                            $LorryChargers->lorry_id=$request->lorry;
                            $LorryChargers->route_id=$request->route;
                            $LorryChargers->charging_sub_type=$request->category; 
                            $LorryChargers->charges=$request->chargers;	
                            $LorryChargers->charging_type_id=$request->chargingType;	
                            $LorryChargers->updated_by=$user->id;	
                            $LorryChargers->save();    
                    return redirect('transportLorryChargers/list')->with([ 'success' => true,
			'success.message'=> 'Charging rules update successfully!',
			'success.title' => 'Well Done!']);
	}
        
           /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function isAddRule($lorry,$route,$chargingType,$chargers)
	{
            $lorryChargers = TransportLorryChargers::where('lorry_id','=',$lorry)->where('route_id','=',$route)->where('charging_type_id','=',$chargingType)->where('charges','=',$chargers)->get();           
            $lorryChargersCount = $lorryChargers->count(); 
            return $lorryChargersCount;
	}

          /** 
	 * get model data to database
	 *
	 * @return 
	 */
        public function getCategory($id){     
   
               $model = TransportCharginSub::where("charging_type",$id)->lists("id","type_name");             
                return json_encode($model);
        }
}
