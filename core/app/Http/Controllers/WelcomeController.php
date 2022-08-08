<?php namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;

use Sammy\Permissions\Models\Permission;
use Sammy\TransportLorry\Models\TransportLorry;
use Sammy\TransportRoute\Models\TransportRoute;
use Sammy\TransportEmployee\Models\TransportEmployee;
use Sentinel;
use Response;
class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
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
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()	{	
            $lorry=  TransportLorry::all()->count();
            $route= TransportRoute::all()->count();
            $employee=TransportEmployee::all()->count();
            return view('dashboard')->with(['lorry' => $lorry,'route'=>$route,'employee'=>$employee ]);
            //return $limitpending;
	}

        
       

	public function test()
	{
            return 'Hooray';
	}


	

}
