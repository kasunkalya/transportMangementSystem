<?php
namespace Sammy\Permissions\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Response;

use Sentinel;

class PermissionController extends Controller {

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
		return view( 'permissions::permission.add' );
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(PermissionRequest $request)
	{
		$name = $request->get( 'permissions' );
                $user = Sentinel::getUser();
		$permission = Permission::create([
			'name'	=> $request->get( 'permission' ),
                        'description'=>$request->get( 'description' ),
                        'status'=>1,
                        'created_by'=>$user
                    
		]);

		return redirect( 'permission/add' )->with([ 'success' => true,
			'success.message' => 'Permission added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'permissions::permission.list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		if($request->ajax()){
			$permissions = Permission::where('name','!=','admin')->get();
			$user = Sentinel::getUser();
			$jsonList = array();
			$i=1;
			foreach ($permissions as $key => $permission) {
				$dd = array();
				array_push($dd, $i);

				array_push($dd, $permission->name);
				array_push($dd, ($permission->description != null || $permission->description != '')? $permission->description : '-');

				if($permission->status == 1){
					array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Deactivate"><input class="permission-activate" type="checkbox" checked value="'.$permission->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
				}else{
					array_push($dd, '<label class="switch switch-sm" data-toggle="tooltip" data-placement="top" title="Activate"><input class="permission-activate" type="checkbox" value="'.$permission->id.'"><span style="position:inherit;"><i class="handle" style="position:inherit;"></i></span></label>');
				}

				$permissions = Permission::whereIn('name',['permission.edit','admin'])->where('status','=',1)->lists('name');
				if(Sentinel::hasAnyAccess($permissions)){
					array_push($dd, '<a href="#" class="blue" onclick="window.location.href=\''.url('permission/edit/'.$permission->id).'\'" data-toggle="tooltip" data-placement="top" title="Edit Permission"><i class="fa fa-pencil"></i></a>');
				}else{
					array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

				$permissions = Permission::whereIn('name',['permission.delete','admin'])->where('status','=',1)->lists('name');
				if(Sentinel::hasAnyAccess($permissions)){
					array_push($dd, '<a href="#" class="red permission-delete" data-id="'.$permission->id.'" data-toggle="tooltip" data-placement="top" title="Delete Permission"><i class="fa fa-trash-o"></i></a>');
				}else{
					array_push($dd, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
				}

				array_push($jsonList, $dd);
				$i++;
			}
			return Response::json(array('data'=>$jsonList));
		}else{
			return Response::json(array('data'=>[]));
		}
	}

	/**
	 * List of permissions
	 *
	 * @return Response
	 */
	public function apiList(Request $request)
	{
		if($request->ajax()){
			$permissions = Permission::where('name','!=','admin')->lists('name');
			
			return Response::json($permissions);
		}else{
			return Response::json([]);
		}
	}


	/**
	 * Activate or Deactivate Menu
	 * @param  Request $request menu id with status to change
	 * @return Json           	json object with status of success or failure
	 */
	public function status(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');
			$status = $request->input('status');

			$permission = Permission::find($id);
			if($permission){
				$permission->status = $status;
				$permission->save();
				return response()->json(['status' => 'success']);
			}else{
				return response()->json(['status' => 'invalid_id']);
			}
		}else{
			return response()->json(['status' => 'not_ajax']);
		}
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

			$permission = Permission::find($id);
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
	{	
		$permissions = Permission::find($id);               
		if($permissions){
			return view( 'permissions::permission.edit' )->with(['permissions' => $permissions ]);
		}else{
			return view( 'errors.404' )->with(['permissions' => $permissions ]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(PermissionRequest $request, $id)
	{
		$Permission =  Permission::find($id);
		$Permission->name = $request->get( 'permission' );
		$Permission->description = $request->get( 'description' );	
		$Permission->save();    
		return redirect('permission/list')->with([ 'success' => true,
			'success.message'=> 'Permission Update successfully!',
			'success.title' => 'Well Done!']);
	}
}
