<?php
namespace Sammy\TransportRoute\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Response;

use Sammy\TransportRoute\Http\Requests\TransportRouteRequest;
use Sammy\TransportRoute\Models\TransportRoute;
use Sentinel;

class TransportRouteController extends Controller {

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
		return view( 'transportRoute::add' );
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportRouteRequest $request)
	{
                $user = Sentinel::getUser();
                $routelist = TransportRoute::withTrashed()->get();
                $routelistCount = $routelist->count();  
                $value=$routelistCount+1;
                $routeCode='RU-'.$value;
                
		$transportaRoute= TransportRoute::create([
			'route_code'=>$routeCode,
                        'route_name'=>$request->name,
                        'minDistance'=>$request->minDistance,
                        'driver_rate'=>$request->driver_rate,
                        'helper_rate'=>$request->helper_rate,
                        'created_by'=>$user->id
                    
		]);

		return redirect( 'transportRoute/add' )->with([ 'success' => true,
			'success.message' => 'Transport route added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportRoute::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportRoute::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
				array_push($rowData,$i);
				array_push($rowData,$value->route_code);
				array_push($rowData,$value->route_name);

				$permissions = Permission::whereIn('name', ['route.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportRoute/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Type"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
                                $permissions = Permission::whereIn('name', ['route.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportRoute/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Type"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-eye"></i></a>');
				}

				$permissions = Permission::whereIn('name', ['route.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Type"><i class="fa fa-trash-o"></i></a>');
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

			$Route = TransportRoute::find($id);
			if($Route){
				$Route->delete();
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
		$transportRoute = TransportRoute::where('id','=',$id)->get();
		if($transportRoute){
			return view( 'transportRoute::edit' )->with(['transportRoute' => $transportRoute ]);
		}else{
			return view( 'errors.404' )->with(['transportRoute' => $transportRoute ]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportRouteRequest $request, $id)
	{
                $user = Sentinel::getUser();
		$Route =  TransportRoute::find($id);		
                $Route->route_code=$request->code;
                $Route->route_name=$request->name;
                $Route->minDistance=$request->minDistance;
                $Route->driver_rate=$request->driver_rate;
                $Route->helper_rate=$request->helper_rate;                        
                $Route->updated_by=$user->id;
		$Route->save();    
		return redirect('transportRoute/list')->with([ 'success' => true,
			'success.message'=> 'Route Update successfully!',
			'success.title' => 'Well Done!']);
	}
        
        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
		$transportRoute = TransportRoute::where('id','=',$id)->get();
		if($transportRoute){
			return view( 'transportRoute::view' )->with(['transportRoute' => $transportRoute ]);
		}else{
			return view( 'errors.404' )->with(['transportRoute' => $transportRoute ]);
		}
	}

}
