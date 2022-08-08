<?php
namespace Sammy\TransportManagement\Http\Controllers;

use Sammy\Permissions\Models\Permission;
use App\Models\companyContact;
use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Response;
use Barryvdh\DomPDF\Facade as PDF;
use Sammy\TransportChargin\Http\Requests\TransportCharginRequest;
use Sammy\TransportChargin\Models\TransportChargin;
use Sammy\TransportLorryChargers\Models\TransportLorryChargers;
use Sammy\TransportLorry\Models\TransportLorry;
use Sammy\TransportRoute\Models\TransportRoute;
use Sammy\TransportEmployee\Models\TransportEmployee;
use Sammy\TransportManagement\Models\TransportManagement;
use Sammy\TransportManagement\Models\TransportInvoice;
use Sammy\TransportCompany\Models\TransportCompany;
use Sammy\TransportCustomer\Models\TransportCustomer;

use Sammy\TransportManagement\Http\Requests\TransportManagementRequest;
use Illuminate\Support\Facades\Storage;
use Sammy\TransportManagement\Models\TransportLogsheet;
use Sammy\TransportManagement\Models\TransportInvoiceList;
use Sentinel;
use Dompdf\Dompdf;

class TransportManagementController extends Controller {

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
                $company = TransportCompany::all()->lists('company_name' , 'id' );
                $customer =TransportCustomer::all()->lists('customer_name' , 'id' );
                $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
                $route =TransportRoute::all()->lists('route_name' , 'id' );
				$employee=TransportEmployee::all()->lists('full_name' , 'id' );
                $transportChargin= TransportChargin::all()->lists('type_name' , 'id' );
                return view( 'transportManagement::add' )->with([
                    'company' => $company,
                    'lorry'=>$lorry,
                    'route'=>$route,
                    'employee'=>$employee,
                    'customer'=>$customer,
                    'transportChargin'=>$transportChargin
		]);
		
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportManagementRequest $request)
	{
        
                $user = Sentinel::getUser();
                
                $charginType=  TransportChargin::find($request->chargingType);
                $invoicelist = TransportManagement::withTrashed()->get();
                $invoicelistCount = $invoicelist->count();  
                $value=$invoicelistCount+1;
                
                $newInvoiceNo='TRP-'.sprintf('%04d', $value);
                
				$transportaRoute= TransportManagement::create([
                    'invoice_no'=>$newInvoiceNo,
                    'invoice_date'=>$request->invoicedate,
                    'companyid'=>$request->company,
                    'customer_id'=>$request->customer,
                    'contactperson'=>$request->contactPerson,                    
                    'lorry_id'=>$request->lorry,
                    'route_id'=>$request->route,
                    'charging_type_id'=>$request->chargingType,                  
                    'invoice_numbers'=>$request->refInvoiceNumber,
                    'gate_passes'=>$request->gatePass,
                    'start_date'=>$request->startDate,
                    'strat_time'=>$request->startTime,
                    'end_date'=>$request->endDate,
                    'end_time'=>$request->endTime,
                    'vat_percent'=>$request->vat,                    
                    'dis_percent'=>$request->discount,
                    'qty'=>$request->qty,
                    'rate'=>'',
                    'multiply'=>$charginType->multiply,
                    'total'=>'',
                    'load_remarks'=>$request->onLoading,
                    'unload_remarks'=>$request->onUnloading,
                    'notes'=>$request->specialNotes,
                    'paymentAmount'=>$request->chargers,
                    'paymentDiscount'=>$request->discountAmount,
                    'workOderNo'=>$request->workNumber,
                    'charging_sub_type_id'=>$request->category,
                    'description'=>$request->description,
                    'driver_rate'=>$request->dRate,
                    'helper_rate'=>$request->hRate,
                    'created_by'=>$user->id,
		])->id;

                if(isset($request->logsheet )){
                    foreach ($request->logsheet as $key => $value) {			
                            $route= TransportLogsheet::create([
                                'tripId'=>$transportaRoute,
                                'logSheetId'=>$value  
                                ])->id;   
                    }
                }
                    
                
                
		return redirect( 'transportManagement/add' )->with([ 'success' => true,
			'success.message' => 'Transport request added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportManagement::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
                        $data = TransportManagement::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $lorry=  TransportLorry::where('id',$value->lorry_id)->first();                              
                                $licencePlate=$lorry['licence_plate'];                                
				array_push($rowData,$i);
				array_push($rowData,$value->invoice_no);
				array_push($rowData,$value->invoice_date);
                                array_push($rowData,$value->start_date);	
                                array_push($rowData,$licencePlate);
				$permissions = Permission::whereIn('name', ['transportRequest.edit', 'admin'])->where('status', '=',1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportManagement/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Transport Request"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
				
                                $permissions = Permission::whereIn('name', ['transportRequest.view', 'admin'])->where('status', '=',1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportManagement/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Transport Request"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>');
				}

				$permissionsDelete = Permission::whereIn('name', ['transportRequest.delete', 'admin'])->where('status', '=',1)->lists('name');
				if (Sentinel::hasAnyAccess($permissionsDelete)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Transport Request"><i class="fa fa-trash-o"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
				}

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}


        public function jsonDailylist(Request $request)
	{
            $date=date('Y-m-d');
            $data =  \Illuminate\Support\Facades\DB::table('muthumala_transport_trips')
                ->whereDate('invoice_date','=',$date )
                ->get();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                $lorry=  TransportLorry::where('id',$value->lorry_id)->first();                              
                $licencePlate=$lorry['licence_plate'];
                                
                $route= TransportRoute::where('id',$value->route_id)->first();                              
                $routeName=$route['route_name'];
                                
				array_push($rowData,$i);
				array_push($rowData,$value->invoice_no);
				array_push($rowData,$value->invoice_date);	
                                array_push($rowData,$licencePlate);	
                                array_push($rowData,$routeName);	

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}
        
        
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function contactpersonList($id)
	{
		$data = TransportCustomer::find($id);			            
                return json_encode($data);

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

			$transport = TransportManagement::find($id);
			if($transport){
				$transport->delete();
                                $lorry = TransportLogsheet::where('tripId','=',$id);		
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
		$transportChargin= TransportChargin::all()->lists('type_name' , 'id' );           
                $company = TransportCompany::all()->lists('company_name' , 'id' );
                $customer =TransportCustomer::all()->lists('customer_name' , 'id');
                $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
                $route =TransportRoute::all()->lists('route_name' , 'id' );
		$employee=TransportEmployee::all()->lists('full_name' , 'id' );
                $transportRequest= TransportManagement::find($id);
                if($transportRequest){
                    return view( 'transportManagement::edit' )->with([
                        'transportRequest'=>$transportRequest,
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'transportChargin'=>$transportChargin
                    ]);
                
		
		}else{
			return view( 'errors.404' )->with(['transportRequest' => $transportRequest ]);
		}
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportManagementRequest $request, $id)
	{
                    $user = Sentinel::getUser();
                    $charginType=  TransportChargin::find($request->chargingType);
                    $Transport = TransportManagement::find($id);               
                    $Transport->invoice_date=$request->invoicedate;
                    $Transport->companyid=$request->company;
                    $Transport->customer_id=$request->customer;
                    $Transport->contactperson=$request->contactPerson;                    
                    $Transport->lorry_id=$request->lorry;
                    $Transport->route_id=$request->route;
                    $Transport->charging_type_id=$request->chargingType;
                    $Transport->invoice_numbers=$request->refInvoiceNumber;
                    $Transport->gate_passes=$request->gatePass;
                    $Transport->start_date=$request->startDate;
                    $Transport->strat_time=$request->startTime;
                    $Transport->end_date=$request->endDate;
                    $Transport->end_time=$request->endTime;
                    $Transport->vat_percent=$request->vat;
                    $Transport->dis_percent=$request->discount;
                    $Transport->qty=$request->qty;
                    $Transport->multiply=$charginType->multiply;
                    $Transport->load_remarks=$request->onLoading;
                    $Transport->unload_remarks=$request->onUnloading;
                    $Transport->notes=$request->specialNotes;
                    $Transport->paymentAmount=$request->chargers;
                    $Transport->paymentDiscount=$request->discountAmount;
                    $Transport->workOderNo=$request->workNumber;      
                    $Transport->charging_sub_type_id=$request->category;
                    $Transport->driver_rate=$request->dRate;
                    $Transport->description=$request->description;
                    $Transport->helper_rate=$request->hRate;
                    $Transport->updated_by=$user->id;
                    $Transport->save();    
                    
                    
                    $lorry = TransportLogsheet::where('tripId','=',$id);		
                    $lorry->delete();   
                    
                    if(isset($request->logsheet)){
                      foreach ($request->logsheet as $key => $value) {			
                        $route= TransportLogsheet::create([
                            'tripId'=>$id,
                            'logSheetId'=>$value  
                            ])->id;   
                        }
                    }
                    
                    
                    
                    
		return redirect('transportManagement/list')->with([ 'success' => true,
			'success.message'=> 'Transport request update successfully!',
			'success.title' => 'Well Done!']);
	}
	
	/**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
				$transportChargin= TransportChargin::all()->lists('type_name' , 'id' );           
                $company = TransportCompany::all()->lists('company_name' , 'id' );
                $customer =TransportCustomer::all()->lists('customer_name' , 'id' );
                $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
                $route =TransportRoute::all()->lists('route_name' , 'id' );
				$employee=TransportEmployee::all()->lists('full_name' , 'id' );
                $transportRequest= TransportManagement::find($id);
                if($transportRequest){
                    return view( 'transportManagement::view' )->with([
                        'transportRequest'=>$transportRequest,
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'transportChargin'=>$transportChargin
                    ]);
                
		
		}else{
			return view( 'errors.404' )->with(['transportRequest' => $transportRequest ]);
		}
	}

        /** 
	 * get model data to database
	 *
	 * @return 
	*/
        public function getCustomer($id){     
               $model = companyContact::where("companyId","=",$id)->where('companyType','=','C')->lists("id","name");             
                return json_encode($model);
        }
        
        
        
         /** 
	 * get model data to database
	 *
	 * @return 
	*/
        public function jsonlogsheetList($logsheet,$request){     
               $model = TransportLogsheet::where("tripId","=",$request)->where('logSheetId','=',$logsheet)->get();             
                return $model->count();
        }
        
        /** 
	 * get model data to database
	 *
	 * @return 
	*/
        public function getChargingType($lorry,$route,$chargingType,$subCategoryValue){    
            //return $lorry.'/'.$route.'/'.$chargingType;
        if($subCategoryValue !=0){
             $model = TransportLorryChargers::where("lorry_id","=",$lorry)->where("route_id","=",$route)->where("charging_type_id","=",$chargingType)->where("charging_sub_type","=",$subCategoryValue)->get();      
        }else{
             $model = TransportLorryChargers::where("lorry_id","=",$lorry)->where("route_id","=",$route)->where("charging_type_id","=",$chargingType)->get();      
        }
            return json_encode($model);
        }
        
        
         /** 
	 * get model data to database
	 *
	 * @return 
	*/
        public function getRoutingType($route){    
            //return $lorry.'/'.$route.'/'.$chargingType;
            $model = TransportRoute::find($route);             
            return json_encode($model);
        }
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function addDriverView()
	{
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $transportChargin= TransportChargin::all()->lists('type_name' , 'id' );           
            $company = TransportCompany::all()->lists('company_name' , 'id' );
            $customer =TransportCustomer::all()->lists('customer_name' , 'id' );
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $route =TransportRoute::all()->lists('route_name' , 'id' );
            $employee=TransportEmployee::all()->lists('full_name' , 'id' );
           
            return view( 'transportManagement::addDriver' )->with([
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'transportChargin'=>$transportChargin
                    ]);
	}
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonSearchList($type,$fromDate,$toDate,$lorry,$invoiceNumber)
	{
        
                        if($type ==1){
                            $data = TransportManagement::whereBetween('invoice_date', [$fromDate, $toDate])->where('driver_id','=',NULL)->get();
                        }
                        elseif($type ==2){
                            $data = TransportManagement::where('lorry_id','=',$lorry)->where('driver_id','=',NULL)->get();
                        }
                        elseif($type ==3){
                            $data = TransportManagement::where('invoice_no','=',$invoiceNumber)->where('driver_id','=',NULL)->get();
                        }
                        else{
                            $data = TransportManagement::where('driver_id','=',NULL)->get();
                        }
						
					
                        
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $lorry=  TransportLorry::where('id',$value->lorry_id)->first();                              
                                $licencePlate=$lorry['licence_plate'];                                
				array_push($rowData,$i);
				array_push($rowData,$value->invoice_no);
				array_push($rowData,$value->invoice_date);	
                                array_push($rowData,$licencePlate);
				array_push($rowData, '<input type="checkbox" class="messageCheckbox" name="trip[]" value="' . $value->id . '">');
				

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}
        
        
        /** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function addDriver($id,$driver,$helper)
	{
                    $user = Sentinel::getUser();                
                    $Transport = TransportManagement::find($id);               
                    $Transport->driver_id=$driver;
                    $Transport->helper_id=$helper;
                    $Transport->status=1;
                    $Transport->updated_by=$user->id;
                    $Transport->save();   

	}
        
        
          /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function editDriverView()
	{
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $transportChargin= TransportChargin::all()->lists('type_name' , 'id' );           
            $company = TransportCompany::all()->lists('company_name' , 'id' );
            $customer =TransportCustomer::all()->lists('customer_name' , 'id' );
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $route =TransportRoute::all()->lists('route_name' , 'id' );
            $employee=TransportEmployee::all()->lists('full_name' , 'id' );
           
            return view( 'transportManagement::editDriver' )->with([
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'transportChargin'=>$transportChargin
                    ]);
	}
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonEditSearchList($type,$fromDate,$toDate,$lorry,$invoiceNumber)
	{
        
                        if($type ==1){
                            $data = TransportManagement::whereBetween('invoice_date', [$fromDate, $toDate])->where('driver_id','!=',' ')->get();
                        }
                        elseif($type ==2){
                            $data = TransportManagement::where('lorry_id','=',$lorry)->where('driver_id','!=',' ')->get();
                        }
                        elseif($type ==3){
                            $data = TransportManagement::where('invoice_no','=',$invoiceNumber)->where('driver_id','!=',' ')->get();
                        }
                        else{
                            $data = TransportManagement::where('driver_id','!=',' ')->get();
                        }
                        
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $lorry=  TransportLorry::where('id',$value->lorry_id)->first(); 
                                $driver=TransportEmployee::find($value->driver_id);
                                $helper=TransportEmployee::find($value->helper_id);
                                $licencePlate=$lorry['licence_plate'];                                
								array_push($rowData,$i);
								array_push($rowData,$value->invoice_no);
								array_push($rowData,$value->invoice_date);	
                                array_push($rowData,$licencePlate);
                                array_push($rowData,$driver['full_name']);
                                array_push($rowData,$helper['full_name']);
								
								
				$permissions = Permission::whereIn('name', ['drivertoinvoice.edit', 'admin'])->where('status', '=',1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<input type="checkbox" class="messageCheckbox" name="trip[]" value="' . $value->id . '">');
				} else {
					array_push($rowData, '<input disabled type="checkbox" class="messageCheckbox" name="trip[]" value="' . $value->id . '">');
				}				
								
				

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}
        
            /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function addInvoiceView()
	{
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $transportChargin= TransportChargin::all()->lists('type_name' , 'id' );           
            $company = TransportCompany::all()->lists('company_name' , 'id' );
            $customer =TransportCustomer::all()->lists('customer_name' , 'id' );
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            //$route =TransportRoute::all()->lists('route_name' , 'id' )->prepend('All Route','all');
			$route =TransportRoute::all()->lists('route_name' , 'id' );
            $employee=TransportEmployee::all()->lists('full_name' , 'id' );
           
            return view( 'transportManagement::addInvoice' )->with([
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'transportChargin'=>$transportChargin
                    ]);
	}
        
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsontripsearchlist($type,$fromDate,$toDate,$lorry,$invoiceNumber,$customer,$route)
	{
        
                        if($type ==1){             
                            if($route !='all'){
                                $data = TransportManagement::whereBetween('invoice_date', [$fromDate, $toDate])->where('route_id','=',$route)->where('status',NULL)->get();
                            }else{
                                $data = TransportManagement::whereBetween('invoice_date', [$fromDate, $toDate])->where('status',NULL)->get();
                            }
                        }
                        elseif($type ==2){
                            if($route !='all'){
                                $data = TransportManagement::where('lorry_id','=',$lorry)->where('route_id','=',$route)->where('status',NULL)->get();
                            }else{
                                $data = TransportManagement::where('lorry_id','=',$lorry)->where('status',NULL)->get();
                            }
                        }
                        elseif($type ==3){
                            if($route !='all'){
                                $data = TransportManagement::where('invoice_no','=',$invoiceNumber)->where('route_id','=',$route)->where('status',NULL)->get();
                            }else{
                                $data = TransportManagement::where('invoice_no','=',$invoiceNumber)->where('status',NULL)->get();
                            }
                        }
                        elseif($type ==4){
                            if($route !='all'){
                                $data = TransportManagement::where('customer_id','=',$customer)->where('route_id','=',$route)->where('status',NULL)->get();
                            }else{
                                $data = TransportManagement::where('customer_id','=',$customer)->where('status',NULL)->get();
                            }
                        }
                        else{
                            $data = TransportManagement::where('status',NULL)->get();
                        }
						
						
                        
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $lorry=  TransportLorry::where('id',$value->lorry_id)->first(); 
                                $driver=TransportEmployee::find($value->driver_id);
                                $helper=TransportEmployee::find($value->helper_id);
                                $licencePlate=$lorry['licence_plate'];                                
								array_push($rowData,$i);
								array_push($rowData,$value->invoice_no);
								array_push($rowData,$value->invoice_date);	
                                array_push($rowData,$licencePlate);
                                array_push($rowData,$value->gate_passes);
                                array_push($rowData,number_format($value->paymentAmount,2,'.',','));
                                array_push($rowData,number_format($value->paymentDiscount,2,'.',','));
//                                array_push($rowData,$driver['full_name']);
//                                array_push($rowData,$helper['full_name']);
				array_push($rowData, '<input type="checkbox" class="messageCheckbox" name="trip[]" value="' . $value->id . '">');
				

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}
        
        
            /** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function createInvoice($id,$vat,$customer,$contact,$routeValue,$company)
	{

           
            $user = Sentinel::getUser();            
            $record = explode(",",$id);
            $sum = 0;
            $discount = 0;
            foreach($record as $key=>$value)
            {
               $value=TransportManagement::find($value);
               $sum += $value['paymentAmount'] ;
               $discount +=$value['paymentDiscount'];
            }
            
                     
            $invoicelist = TransportInvoice::withTrashed()->get();
            $invoicelistCount = $invoicelist->count();  
            $value=$invoicelistCount+1;          
            $customerCOde=TransportCustomer::where('id',$customer)->first(); 
		
            $newInvoiceNo=$customerCOde['invoice_code'].' '.date("y").'/'.date('y', strtotime('+1 year')).'-'.sprintf('%04d', $value);         
            
            

            $transportInvoice= TransportInvoice::create([
                    'invoice_number'=>$newInvoiceNo,
                    'invoice_date'=>date('Y-m-d'),
                    'customer'=>$customer,
                    'contact_person'=>$contact,
                    'request_ids'=>$id,  
                    'route_id'=>$routeValue,    
                    'total_amount'=>$sum,
                    'total_discount'=>$discount,
                    'company'=>$company,
                    'vat_amount'=>$vat,                    
                    'created_by'=>$user->id,
		])->id;
            
            
            foreach($record as $key=>$value)
            {
               $Transport=TransportManagement::find($value);
               $Transport->invoice_id=$transportInvoice;
               $Transport->status=2;
               $Transport->save();  
            }
			
            return Response::json(array('invoiceid' => $transportInvoice,'layoutid'=>$customerCOde['invoiceLayoutId']));
	}
        
            public function printPDF($id)
        {
                
           
                $invoice = TransportInvoice::find($id);      
                $company= TransportCustomer::find($invoice['customer']);
                $contactPerson= companyContact::find($invoice['contact_person']);
                
                $muthuCompany=TransportCompany::find($invoice['company']);
                $companyName=$muthuCompany['company_name'];

                
                $addressline = explode(",", $company['address']);
                $address='';
                foreach($addressline as $v){
                   $address .= "<span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>".$v."<br>"  ;
                } 
                
                $route=  TransportRoute::find($invoice['route_id']); 
                $trips=  TransportManagement::where('invoice_id','=',$invoice['id'])->get();
                $tripList='';
                $sum=0;
                $total=0;
                $discount=0;
                $totalVat=0;
                $amountTotal=0;
                foreach($trips as $t){
                    
                   $lorry=  TransportLorry::where('id',$t['lorry_id'])->first(); 
                    $sum += $t['paymentAmount'] ;
                    $discount += $t['paymentDiscount'] ;
                    $amount =  $t['paymentAmount']-$t['paymentDiscount'];
                    $amountTotal +=  $t['paymentAmount']-$t['paymentDiscount'];
                   $tripList .= "<tr>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['invoice_date']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$lorry['licence_plate']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['gate_passes']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['invoice_no']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($amount,2,'.',',')."</td>  
				</tr>"  ;
                } 
                
                $totalVat=($amountTotal *$invoice['vat_amount'] )/100;
                
                if($route['route_name'] !=''){
                        $from=' from '.$route['route_name'];
                    }else{
                        $from='';
                    }
                
                $total=$totalVat + $sum - $discount;
                $text="<p class=MsoNormal align=center style='text-align:center'><span
                        style='font-size:22.0pt;line-height:107%;font-family:'Arial'>".$companyName."<br>
                        </span><span style='font-size:14.0pt;line-height:107%;font-family:'Arial'>GOVERNMENT
                        TRANSPORT <span style='mso-spacerun:yes'> </span>CONTRACTOR<o:p></o:p></span></p>

                        <p class=MsoNormal align=center style='text-align:center'><span
                        style='font-size:10.0pt;line-height:107%;font-family:'Arial'>No:396,George
                        R De Silva <span class=SpellE>Mawatha</span>, Colombo - 13<br>
                        Tel: 011 2384227,011 2384237, Fax: 011 2387275, Email: <a
                        href='mailto:gmuthumalamotors@gmail.com'>gmuthumalamotors@gmail.com</a><br>
                        Branch:48,Main <span class=SpellE>Street,Ambalanthota</span>. Tel: 042 2223297<o:p></o:p></span></p>
                        <hr>
                        <div style='float:right'>
                            <p class=MsoNormal align=right style='text-align:left'>
                            <span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>Our Vat No : 
                            <span class=SpellE>114459585-7000</span><br>
                            <span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>Date : 
                            <span class=SpellE>".date('Y-m-d')."</span><br>
                            <span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>Invoice No : 
                            <span class=SpellE>".$invoice['invoice_number']."</span><br>
                            </p>
                        </div>
                        <br><br>
                        <div style='float:left'>
                            <p class=MsoNormal align=right style='text-align:left'>
                            <span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>".$contactPerson['name']."</span><br>
                            ".$address." 					
                            </p>
				<h2 style='margin-top:100px'>Transport of ".$company['customer_name']."</h2>
				<p class=MsoNormal align=right style='text-align:left'>
                           	Herewith we forward our transport bills for payments which we transported ".$from." 				
                            </p>
							
					<table style='border-collapse: collapse;' width='700px'>
						<thead>
							<tr>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Date</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Vehicle No</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Gate Pass No</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Trip No</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Rate</th>
							</tr>							
						</thead>
								
						<tbody>".$tripList." 
                                                <tr>
                                                    <td colspan='4' style='border: 1px solid black;' class='text-center' style='font-weight:normal;'><center><b>Total</b></center></td>
                                                    <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($amountTotal,2,'.',',')."</td>
                                                </tr>
                                                <tr>
                                                    <td colspan='4' style='border: 1px solid black;' class='text-center' style='font-weight:normal;'><center><b>VAT(".$invoice['vat_amount']."%)</b></center></td>
                                                    <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($totalVat,2,'.',',')."</td>
                                                </tr>
                                                <tr>
                                                    <td colspan='4' style='border: 1px solid black;' class='text-center' style='font-weight:normal;'><center><b>Total</b></center></td>
                                                    <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($total,2,'.',',')."</td>
                                                </tr>
						</tbody>
					</table>
                                        <center>
                                            <table width='700px' style='margin-top:50px'>

                                                            <tr>
                                                                    <th class='text-center' style='font-weight:normal;'><center>.......................................</center></th>
                                                                    <th class='text-center' style='font-weight:normal;'><center>.......................................</center></th>
                                                                    <th class='text-center' style='font-weight:normal;'><center>.......................................</center></th>

                                                            </tr>
                                                            <tr>
                                                                    <th class='text-center' style='font-weight:normal;'><center>Prepared By</center></th>
                                                                    <th class='text-center' style='font-weight:normal;'><center>Checked By</center></th>
                                                                    <th class='text-center' style='font-weight:normal;'><center>Authorized By</center></th>

                                                            </tr>

                                            </table>	
                        </div>          </center>
                        ";
                
                $dompdf = new Dompdf();
                $dompdf->loadHtml($text);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream($invoice['invoice_number'].'_'.date('h:i:sa').'.pdf');    
                
                exit;

        }
        
      /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function viewInvoiceView()
	{
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $transportChargin= TransportChargin::all()->lists('type_name' , 'id' );           
            $company = TransportCompany::all()->lists('company_name' , 'id' );
            $customer =TransportCustomer::all()->lists('customer_name' , 'id' );
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $route =TransportRoute::all()->lists('route_name' , 'id' )->prepend('All Route','all');;
            $employee=TransportEmployee::all()->lists('full_name' , 'id' );
           
            return view( 'transportManagement::viewInvoice' )->with([
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'transportChargin'=>$transportChargin
                    ]);
	}
        
       
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	//public function jsoninvoicesearchlist($type,$fromDate,$toDate,$lorry,$invoiceNumber,$customer,$route)
	public function jsoninvoicesearchlist(TransportManagementRequest $request)
	{
		$searchvalue= json_decode($request->searchvalue);
   
		$type=$searchvalue[0];
		$fromDate=$searchvalue[1];
		$toDate=$searchvalue[2];
		$lorry=$searchvalue[3];
		$invoiceNumber=$searchvalue[4];
		$customer=$searchvalue[5];
		$route=$searchvalue[6];
	
                        if($type ==1){
							
                            
							if($route !='all'){
								$data = TransportInvoice::whereBetween('invoice_date', [$fromDate, $toDate])->where('route_id','=',$route)->get();
							}else{
								$data = TransportInvoice::whereBetween('invoice_date', [$fromDate, $toDate])->get();
							}
                        }
                        elseif($type ==2){
                            
							if($route !='all'){
								$data = TransportInvoice::where('lorry_id','=',$lorry)->where('route_id','=',$route)->get();
							}else{
								$data =TransportInvoice::where('lorry_id','=',$lorry)->get();
							}
                        }
                        elseif($type ==3){
                            
							if($route !='all'){
								$data = TransportInvoice::where('invoice_number','=',$invoiceNumber)->where('route_id','=',$route)->get();
							}else{
								$data =  TransportInvoice::where('invoice_number','=',$invoiceNumber)->get();
							}
                        }
                        elseif($type ==4){
							if($route !='all'){
								$data = TransportInvoice::where('customer','=',$customer)->where('route_id','=',$route)->get();
							}else{
								$data = TransportInvoice::where('customer','=',$customer)->get();
							}
                        }
                        else{
							
                            $data = TransportInvoice::all();
                        }
                        
			

			
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();     
                                $route=  TransportRoute::find($value->route_id);
                                $customer=  TransportCustomer::find($value->customer);
                                $total=$value->total_amount-$value->total_discount;
                                $vat=($total * $value->vat_amount )/100;
                                $nettotal=$total + $vat;
								array_push($rowData,$i);
								array_push($rowData,$value->invoice_number);
								array_push($rowData,$value->invoice_date);	
                                if($route['route_name'] !=''){
                                    array_push($rowData,$route['route_name']);
                                }else{
                                     array_push($rowData,'All Route');
                                }
                                array_push($rowData,$customer['customer_name']);
                                array_push($rowData,number_format($total,2,'.',','));
                                array_push($rowData,number_format($vat,2,'.',','));
                                array_push($rowData,number_format($nettotal,2,'.',','));
//                                array_push($rowData,$driver['full_name']);
//                                array_push($rowData,$helper['full_name']);
				$permissions = Permission::whereIn('name', ['transportRequest.print', 'admin'])->where('status', '=',1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					//array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportManagement/printpdf/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Print Invoice"><i class="fa fa-print"></i></a>');
				
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('pdf-create/'. $value->id.'/'.$customer['invoiceLayoutId'].'') . '\'" data-toggle="tooltip" data-placement="top" title="Print Invoice"><i class="fa fa-print"></i></a>');
				
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Print Disabled"><i class="fa fa-print"></i></a>');
				}

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}
        
        
            /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function addInvoiceListView()
	{
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $transportChargin= TransportChargin::all()->lists('type_name' , 'id' );           
            $company = TransportCompany::all()->lists('company_name' , 'id' );
            $customer =TransportCustomer::all()->lists('customer_name' , 'id' );
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $route =TransportRoute::all()->lists('route_name' , 'id' )->prepend('All Route','all');
            $employee=TransportEmployee::all()->lists('full_name' , 'id' );
           
            return view( 'transportManagement::addInoiceList' )->with([
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'transportChargin'=>$transportChargin
                    ]);
	}
    
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonInvoicListesearchlist($type,$fromDate,$toDate,$lorry,$invoiceNumber,$customer,$route)
	{
        
                        if($type ==1){                  
                            if($route !='all'){
                                $data = TransportInvoice::whereBetween('invoice_date', [$fromDate, $toDate])->where('route_id','=',$route)->where('status',NULL)->get();
                            }else{
                                $data = TransportInvoice::whereBetween('invoice_date', [$fromDate, $toDate])->where('status',NULL)->get();
                            }
                        }
                        elseif($type ==2){
                            if($route !='all'){
                                $data = TransportInvoice::where('lorry_id','=',$lorry)->where('route_id','=',$route)->where('status',NULL)->get();
                            }else{
                                $data = TransportInvoice::where('lorry_id','=',$lorry)->where('status',NULL)->get();
                            }
                        }
                        elseif($type ==3){
                            if($route !='all'){
                                $data = TransportInvoice::where('invoice_no','=',$invoiceNumber)->where('route_id','=',$route)->where('status',NULL)->get();
                            }else{
                                $data = TransportInvoice::where('invoice_no','=',$invoiceNumber)->where('status',NULL)->get();
                            }
                        }
                        elseif($type ==4){
                            if($route !='all'){
                                $data = TransportInvoice::where('customer_id','=',$customer)->where('route_id','=',$route)->where('status',NULL)->get();
                            }else{
                                 $data = TransportInvoice::where('customer_id','=',$customer)->where('status',NULL)->get();
                            }
                        }
                        else{
                            $data = TransportInvoice::where('status',NULL)->get();
                        }
						
						
                        
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $lorry=  TransportLorry::where('id',$value->lorry_id)->first(); 
                                $driver=TransportEmployee::find($value->driver_id);
                                $helper=TransportEmployee::find($value->helper_id);
                                $licencePlate=$lorry['licence_plate'];    
                                $str_arr = explode (",", $value->request_ids);  
                                
				array_push($rowData,$i);
                                array_push($rowData,$value->invoice_date);	
				array_push($rowData,$value->invoice_number);				
                                array_push($rowData, sizeof($str_arr));                                
                                array_push($rowData,number_format($value->total_amount,2,'.',','));                                
                                $vat=($value->total_amount/100)*$value->vat_amount;    
                                                         
                                array_push($rowData,number_format($vat,2,'.',','));
                                $total=$value->total_amount + $vat;
                                array_push($rowData,number_format($total,2,'.',','));  
//                                array_push($rowData,$driver['full_name']);
//                                array_push($rowData,$helper['full_name']);
				array_push($rowData, '<input type="checkbox" class="messageCheckbox" name="trip[]" value="' . $value->id . '">');
				

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}
        
               /** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function createInvoiceList($id,$customer,$contact,$routeValue,$company)
	{
           
            $user = Sentinel::getUser();            
            $record = explode(",",$id);
            $sum = 0;
            $discount = 0;
            $vat=0;
            foreach($record as $key=>$value)
            {
               $value=TransportInvoice::find($value);
               $sum += $value['total_amount'] ;
               $discount +=$value['total_discount'];
               
               //$vat_single = ($value['total_amount']-$value['total_discount']/100)*$value['vat_amount'];
                $vat_single=($value['total_amount']/100)*$value['vat_amount'];    
               
               $vat +=$vat_single;
            }
            
                     
            $invoicelist = TransportInvoice::withTrashed()->get();
            $invoicelistCount = $invoicelist->count();  
            $value=$invoicelistCount+1;          
            $customerCOde=TransportCustomer::where('id',$customer)->first(); 
            $newInvoiceNo=$customerCOde['invoice_code'].' '.date("y").'/'.date('y', strtotime('+1 year')).'-'.sprintf('%04d', $value);         
            
            

            $transportInvoice= TransportInvoiceList::create([
                    'invoice_list_number'=>$newInvoiceNo,
                    'invoice_date'=>date('Y-m-d'),
                    'customer'=>$customer,
                    'contact_person'=>$contact,
                    'company'=>$company,
                    'invoice_ids'=>$id,  
                    'route_id'=>$routeValue,    
                    'total_amount'=>$sum,
                    'total_discount'=>$discount,
                    'vat_amount'=>$vat,                    
                    'created_by'=>$user->id,
		])->id;
            
            
            foreach($record as $key=>$value)
            {
               $Transport=TransportInvoice::find($value);
               $Transport->invoice_list_id=$transportInvoice;
               $Transport->status=2;
               $Transport->save();  
            }
            return Response::json($transportInvoice);
	}
        
         public function printPDFList($id)
        {
                
           
                $invoice = TransportInvoiceList::find($id);      
                $company= TransportCustomer::find($invoice['customer']);
                $contactPerson= companyContact::find($invoice['contact_person']);
                $muthuCompany=TransportCompany::find($invoice['company']);
                $companyName=$muthuCompany['company_name'];
                
                $addressline = explode(",", $company['address']);
                $address='';
                foreach($addressline as $v){
                   $address .= "<span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>".$v."<br>"  ;
                } 
                
                $route=  TransportRoute::find($invoice['route_id']); 
                $trips=  TransportInvoice::where('invoice_list_id','=',$invoice['id'])->get();
                
                $tripList='';
                $sum=0;
                $total=0;
                $discount=0;
                $totalVat=0;
                $amountTotal=0;
                $totalTrips=0;
                $totalChargers=0;
                $fullTotal=0;
                foreach($trips as $t){
                    
                   $lorry=  TransportLorry::where('id',$t['lorry_id'])->first(); 
                    $sum += $t['paymentAmount'] ;
                    $discount += $t['paymentDiscount'] ;
                    $amount =  $t['paymentAmount']-$t['paymentDiscount'];
                    $amountTotal +=  $t['paymentAmount']-$t['paymentDiscount'];
                    $str_arr = explode (",", $t['request_ids']);  
                    
                    $vat=($t['total_amount']/100)*$t['vat_amount'];    
                    $finalVat=sprintf('%0.2f',floor($vat)); 
                    
                    $total=sprintf('%0.2f',$t['total_amount'] + $finalVat);
                    
                    $fullTotal +=$t['total_amount'] + $finalVat;
                    
                    $totalTrips +=sizeof($str_arr);
                    
                    $totalVat +=$vat;
                    $totalChargers +=$t['total_amount'];
                    
                   $tripList .= "<tr>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['invoice_date']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['invoice_number']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".sizeof($str_arr)."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($t['total_amount'],2,'.',',')."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($vat,2,'.',',')."</td>  
                                <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($total,2,'.',',')."</td>      
				</tr>"  ;
                } 
                    if($route['route_name'] !=''){
                        $from=' from '.$route['route_name'];
                    }else{
                        $from='';
                    }
            
                $text="<p class=MsoNormal align=center style='text-align:center'><span
                        style='font-size:22.0pt;line-height:107%;font-family:'Arial'>".$companyName."<br>
                        </span><span style='font-size:14.0pt;line-height:107%;font-family:'Arial'>GOVERNMENT
                        TRANSPORT <span style='mso-spacerun:yes'> </span>CONTRACTOR<o:p></o:p></span></p>

                        <p class=MsoNormal align=center style='text-align:center'><span
                        style='font-size:10.0pt;line-height:107%;font-family:'Arial'>No:396,George
                        R De Silva <span class=SpellE>Mawatha</span>, Colombo - 13<br>
                        Tel: 011 2384227,011 2384237, Fax: 011 2387275, Email: <a
                        href='mailto:gmuthumalamotors@gmail.com'>gmuthumalamotors@gmail.com</a><br>
                        Branch:48,Main <span class=SpellE>Street,Ambalanthota</span>. Tel: 042 2223297<o:p></o:p></span></p>
                        <hr>
                        <div style='float:right'>
                            <p class=MsoNormal align=right style='text-align:left'>
                            <span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>Our Vat No : 
                            <span class=SpellE>114459585-7000</span><br>
                            <span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>Date : 
                            <span class=SpellE>".date('Y-m-d')."</span><br>
                            <span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>Invoice No : 
                            <span class=SpellE>".$invoice['invoice_list_number']."</span><br>
                            </p>
                        </div>
                        <br><br>
                        <div style='float:left'>
                            <p class=MsoNormal align=right style='text-align:left'>
                            <span style='font-size:10.0pt;line-height:107%;font-family:'Arial'>".$contactPerson['name']."</span><br>
                            ".$address." 					
                            </p>
				<h2 style='margin-top:100px'>Transport of ".$company['customer_name']."</h2>
				<p class=MsoNormal align=right style='text-align:left'>
                           	Herewith we forward our transport bills for payments which we transported ".$from." 				
                            </p>
							
					<table style='border-collapse: collapse;' width='700px'>
						<thead>
							<tr>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Date</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Reference No</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>No of Trips</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Transport Chargers</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Vat</th>
                                                                <th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Total</th>
							</tr>							
						</thead>
								
						<tbody>".$tripList." 
                                                <tr>
                                                    <td colspan='2' style='border: 1px solid black;' class='text-center' style='font-weight:normal;'><center><b>Total</b></center></td>
                                                    <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$totalTrips."</td>
                                                    <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($totalChargers,2,'.',',')."</td>
                                                    <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($totalVat,2,'.',',')."</td>
                                                    <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".number_format($fullTotal,2,'.',',')."</td>     
                                                </tr>                                            
						</tbody>
					</table>
                                        <center>
                                            <table width='700px' style='margin-top:50px'>

                                                            <tr>
                                                                    <th class='text-center' style='font-weight:normal;'><center>.......................................</center></th>
                                                                    <th class='text-center' style='font-weight:normal;'><center>.......................................</center></th>
                                                                    <th class='text-center' style='font-weight:normal;'><center>.......................................</center></th>

                                                            </tr>
                                                            <tr>
                                                                    <th class='text-center' style='font-weight:normal;'><center>Prepared By</center></th>
                                                                    <th class='text-center' style='font-weight:normal;'><center>Checked By</center></th>
                                                                    <th class='text-center' style='font-weight:normal;'><center>Authorized By</center></th>

                                                            </tr>

                                            </table>	
                        </div>          </center>
                        ";
                
                $dompdf = new Dompdf();
                $dompdf->loadHtml($text);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $dompdf->stream($invoice['invoice_number'].'_'.date('h:i:sa').'.pdf');    
                
                exit;

        }
        
         /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function viewInvoiceListView()
	{
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $transportChargin= TransportChargin::all()->lists('type_name' , 'id' );           
            $company = TransportCompany::all()->lists('company_name' , 'id' );
            $customer =TransportCustomer::all()->lists('customer_name' , 'id' );
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $route =TransportRoute::all()->lists('route_name' , 'id' )->prepend('All Route','all');
            $employee=TransportEmployee::all()->lists('full_name' , 'id' );
           
            return view( 'transportManagement::viewInvoiceList' )->with([
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'transportChargin'=>$transportChargin
                    ]);
	}
        
           /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsoninvoiceListsearchlist(TransportManagementRequest $request)
	{
        
		
		$searchvalue= json_decode($request->searchvalue);
   
		$type=$searchvalue[0];
		$fromDate=$searchvalue[1];
		$toDate=$searchvalue[2];
		$lorry=$searchvalue[3];
		$invoiceNumber=$searchvalue[4];
		$customer=$searchvalue[5];
		$route=$searchvalue[6];
		
                        if($type ==1){
                            if($route !='all'){
                                $data = TransportInvoiceList::whereBetween('invoice_date', [$fromDate, $toDate])->where('route_id','=',$route)->get();
                            }else{
                                $data = TransportInvoiceList::whereBetween('invoice_date', [$fromDate, $toDate])->get();
                            }
                        }
                        elseif($type ==2){
                            if($route !='all'){
                                $data = TransportInvoiceList::where('lorry_id','=',$lorry)->where('route_id','=',$route)->get();
                            }else{
                                $data = TransportInvoiceList::where('lorry_id','=',$lorry)->get();
                            }
                        }
                        elseif($type ==3){
                            if($route !='all'){
                            $data = TransportInvoiceList::where('invoice_list_number','=',$invoiceNumber)->where('route_id','=',$route)->get();
                            }else{
                                $data = TransportInvoiceList::where('invoice_list_number','=',$invoiceNumber)->get();
                            }
                        }
                        elseif($type ==4){
                            if($route !='all'){
                            $data = TransportInvoiceList::where('customer','=',$customer)->where('route_id','=',$route)->get();
                            }else{
                                 $data = TransportInvoiceList::where('customer','=',$customer)->get();
                            }
                        }
                        else{
                            $data = TransportInvoiceList::all();
                        }
                        
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();     
                                $route=  TransportRoute::find($value->route_id);
                                $customer=  TransportCustomer::find($value->customer);
                                $total=$value->total_amount-$value->total_discount;
                                
                                $nettotal=$total + $value->vat_amount;
				array_push($rowData,$i);
				array_push($rowData,$value->invoice_list_number);
				array_push($rowData,$value->invoice_date);
                                array_push($rowData,$customer['customer_name']);
                                array_push($rowData,number_format($total,2,'.',','));
                                array_push($rowData,number_format($value->vat_amount,2,'.',','));
                                array_push($rowData,number_format($nettotal,2,'.',','));
//                                array_push($rowData,$driver['full_name']);
//                                array_push($rowData,$helper['full_name']);
				$permissions = Permission::whereIn('name', ['transportRequest.print', 'admin'])->where('status', '=',1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportManagement/printpdfList/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Print Invoice"><i class="fa fa-print"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Print Disabled"><i class="fa fa-print"></i></a>');
				}

				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}
}
