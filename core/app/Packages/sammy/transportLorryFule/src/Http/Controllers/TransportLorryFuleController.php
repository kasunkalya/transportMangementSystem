<?php
namespace Sammy\TransportLorryFule\Http\Controllers;

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
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;
use Dompdf\Dompdf;
class TransportLorryFuleController extends Controller {

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
        $service = TransportSupplier::where('type',1)->lists('suppliers_name' , 'id' );
        $driver= TransportEmployee::all()->lists('full_name' , 'id' );
            return view( 'transportLorryFule::add' )->with([
                    'lorry' => $lorry,
                    'driver'=>$driver,
                    'service' => $service   
		]);
	
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportLorryFuleRequest $request)
	{
                $user = Sentinel::getUser();
                
                $attachmentFile=$request->file('document');
                $attachment='';
                            if($attachmentFile !=""){
                                    $destinationPath = 'lorryFuleRecords/'.$request->lorry;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_Fule_'.date('Y_m_d').$request->lorry.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            }                   
               
                    $transportaRoute= TransportLorryFule::create([
                            'lorry'=>$request->lorry,
                            'fuleDate'=>$request->fuledate,  
                            'location'=>$request->location,
                            'invoice_number'=>$request->invoice,
                            'driver'=>$request->driver,
                            'amount'=>$request->chargers,
                            'sealtag'=>$request->seal,
                            'fuelType'=>$request->type,
                            'vehicleMeter'=>$request->vehicleMeter,
                            'bill'=>$attachment,
                            'created_by'=>$user->id		
                    ])->id;

		return redirect( 'transportLorryFule/add' )->with([ 'success' => true,
			'success.message' => 'Fuel record added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportLorryFule::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLorryFule::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                    $lorry= TransportLorry::where('id',$value->lorry)->first(); 
                    $licence_plate=$lorry['licence_plate'];
                    $supplier= TransportSupplier::where('id',$value->location)->first(); 
				array_push($rowData,$i);                               
                                array_push($rowData,$licence_plate);                
				array_push($rowData,$value->fuleDate);
				array_push($rowData,$supplier['suppliers_name']);
				array_push($rowData,$value->amount);			
                                array_push($rowData,$value->vehicleMeter);
				$permissions = Permission::whereIn('name', ['lorryFule.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryFule/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Fule Record"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}

                                
                                $permissions = Permission::whereIn('name', ['lorryFule.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryFule/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Fule Record"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
				$permissions = Permission::whereIn('name', ['lorryFule.delete', 'admin'])->where('status', '=', 1)->lists('name');
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

			$lorry = TransportLorryFule::find($id);
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
            $maintain= TransportLorryFule::find($id);
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $service = TransportSupplier::where('type',1)->lists('suppliers_name' , 'id' );
            $driver= TransportEmployee::all()->lists('full_name' , 'id' );
            $spairpart = TransportPartRepair::where('repair_id','=',$id)->get();
            if($maintain){
                    return view( 'transportLorryFule::edit' )->with([
                        'maintain'=>$maintain,
                        'spairpart'=>$spairpart,
                        'service'=>$service,
                        'driver'=>$driver,
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
	public function edit(TransportLorryFuleRequest $request, $id)
	{
            
                $user = Sentinel::getUser(); 
                
		$LorryMaintain = TransportLorryFule::find($id);  
                $attachmentFile=$request->file('document');
                $attachment=$LorryMaintain->bill;
                            if($attachmentFile !=""){
                                    $destinationPath = 'lorryFuleRecords/'.$request->lorry;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_Fule_'.date('Y_m_d').$request->lorry.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            }   
                       
                            $LorryMaintain->lorry=$request->lorry;
                            $LorryMaintain->fuleDate=$request->fuledate;
                            $LorryMaintain->location=$request->location;							
                            $LorryMaintain->amount=$request->chargers;
                            $LorryMaintain->invoice_number=$request->invoice;
                            $LorryMaintain->driver=$request->driver;
                            $LorryMaintain->vehicleMeter=$request->vehicleMeter;
                            $LorryMaintain->bill=$attachment;                     
                            $LorryMaintain->sealtag=$request->seal;
                            $LorryMaintain->fuelType=$request->type;
                            $LorryMaintain->updated_by=$user->id;	
                            $LorryMaintain->save();                              
                                                       
                            
		return redirect('transportLorryFule/list')->with([ 'success' => true,
			'success.message'=> 'Fuel Record Update successfully!',
			'success.title' => 'Well Done!']);
	}

        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
            $maintain= TransportLorryFule::find($id);
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id' );
            $service = TransportSupplier::where('type',1)->lists('suppliers_name' , 'id' );
            $spairpart = TransportPartRepair::where('repair_id','=',$id)->get();
            $driver= TransportEmployee::all()->lists('full_name' , 'id' );
            if($maintain){
                return view( 'transportLorryFule::view' )->with([
                    'maintain'=>$maintain,
                    'spairpart'=>$spairpart,
                    'service'=>$service,
                    'driver'=>$driver,
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
	public function addInvoiceView()
	{
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id');
            $transportChargin= TransportChargin::all()->lists('type_name' , 'id');           
            $company = TransportCompany::all()->lists('company_name' , 'id');
            $customer =TransportCustomer::all()->lists('customer_name' , 'id');
            $lorry = TransportLorry::all()->lists('licence_plate' , 'id');
            $route =TransportRoute::all()->lists('route_name' , 'id');
            $employee=TransportEmployee::all()->lists('full_name' , 'id');
            $service = TransportSupplier::where('type',1)->lists('suppliers_name' , 'id' );
           
            return view( 'transportLorryFule::addInvoice' )->with([
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'service'=>$service,
                        'transportChargin'=>$transportChargin
                    ]);
	}

        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonfulesearchlist($type,$fromDate,$toDate,$lorry,$customer)
	{
            
		//if($request->ajax()){
                        if($type ==1){
                            $data = TransportLorryFule::whereBetween('fuleDate', [$fromDate, $toDate])->where('location','=',$customer)->where('status',NULL)->get();
                        }
                        elseif($type ==2){
                            $data = TransportLorryFule::where('lorry','=',$lorry)->where('location','=',$customer)->where('status',NULL)->get();
                        }else{
                            $data = TransportLorryFule::where('status',NULL)->get();
                        }
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $lorry= TransportLorry::where('id',$value->lorry)->first(); 
                                $licence_plate=$lorry['licence_plate'];
                                $supplier= TransportSupplier::where('id',$value->location)->first(); 
				array_push($rowData,$i);                               
                                array_push($rowData,$licence_plate);                
				array_push($rowData,$value->fuleDate);
				array_push($rowData,$supplier['suppliers_name']);
				array_push($rowData,$value->amount);			
                                array_push($rowData,$value->vehicleMeter);
				array_push($rowData, '<input type="checkbox" class="messageCheckbox" name="trip[]" value="' . $value->id . '">');
                                array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

		//}else{
			//return Response::json(array('data'=>[]));
		//}
	}
        
        /** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function createInvoice($id,$customer)
	{
           
            $user = Sentinel::getUser();            
            $record = explode(",",$id);
            $sum = 0;
            $discount = 0;
            foreach($record as $key=>$value)
            {
               $value=TransportLorryFule::find($value);
               $sum += $value['amount'] ;
            }
            
                     
            $invoicelist = TransportLorryFuleInvoice::withTrashed()->get();
            $invoicelistCount = $invoicelist->count();  
            $value=$invoicelistCount+1;            
            $newInvoiceNo='FUEL-'.sprintf('%04d', $value);            

            $transportInvoice= TransportLorryFuleInvoice::create([
                    'invoice_number'=>$newInvoiceNo,
                    'invoice_date'=>date('Y-m-d'),
                    'supplier'=>$customer,
                    'filling_ids'=>$id, 
                    'total_amount'=>$sum,                 
                    'created_by'=>$user->id,
		])->id;
            
            
            foreach($record as $key=>$value)
            {
               $Transport=TransportLorryFule::find($value);
               $Transport->invoice_id=$transportInvoice;
               $Transport->status=1;
               $Transport->save();  
            }
            return Response::json($transportInvoice);
	}
        
        
        public function printPDF($id)
        {
                
           
                $invoice = TransportLorryFuleInvoice::find($id);
                 $customer = TransportSupplier::find($invoice['supplier']);
                $trips=  TransportLorryFule::where('invoice_id','=',$invoice['id'])->get();
                $tripList='';
                $sum=0;
                $total=0;
                $discount=0;
                $totalVat=0;
                $amountTotal=0;
                foreach($trips as $t){
                    
                   $lorry=  TransportLorry::where('id',$t['lorry'])->first();                    
                    $amountTotal +=  $t['amount'];
                   $tripList .= "<tr>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['fuleDate']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$lorry['licence_plate']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['invoice_number']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['vehicleMeter']."</td>
				<td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$t['amount']."</td>  
				</tr>"  ;
                } 
             
                $text="<p class=MsoNormal align=center style='text-align:center'><span
                        style='font-size:22.0pt;line-height:107%;font-family:'Arial'>MUTHUMALA
                        TRANSPORT (PVT) LTD<br>
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
				<h2 style='margin-top:100px'>".$customer['supplier_name']."</h2>
					<table style='border-collapse: collapse;' width='1000px'>
						<thead>
							<tr>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Date</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Vehicle No</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Invoice No</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Meter</th>
								<th style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>Amount</th>
							</tr>							
						</thead>
								
						<tbody>".$tripList." 
                                                <tr>
                                                    <td colspan='4' style='border: 1px solid black;' class='text-center' style='font-weight:normal;'><center><b>Total</b></center></td>
                                                    <td style='border: 1px solid black;' class='text-center' style='font-weight:normal;'>".$amountTotal."</td>
                                                </tr>
                                               
						</tbody>
					</table>
                                        <center>
                                            <table width='1000px' style='margin-top:50px'>

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
                $dompdf->setPaper('A4', 'landscape');
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
            $route =TransportRoute::all()->lists('route_name' , 'id' );
            $employee=TransportEmployee::all()->lists('full_name' , 'id' );
            $service = TransportSupplier::where('type',1)->lists('suppliers_name' , 'id' );
           
            return view( 'transportLorryFule::viewInvoice' )->with([
                        'company' => $company,
                        'lorry'=>$lorry,
                        'route'=>$route,
                        'employee'=>$employee,
                        'customer'=>$customer,
                        'service'=>$service,
                        'transportChargin'=>$transportChargin
                    ]);
	}
        
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonfuleInvoiceSearchlist($fromDate,$toDate,$customer)
	{
            
		//if($request->ajax()){
                  
                        $data = DB::table('muthumala_fuel_invoice')->whereBetween('invoice_date', [$fromDate, $toDate])->where('supplier','=',$customer)->get();
                        
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                $supplier= TransportSupplier::where('id',$value->supplier)->first(); 
				array_push($rowData,$i);      
                                array_push($rowData,$value->invoice_number);
				array_push($rowData,$value->invoice_date);
				array_push($rowData,$supplier['suppliers_name']);
				array_push($rowData,$value->total_amount);
                                
                                $permissions = Permission::whereIn('name', ['lorryFule.print', 'admin'])->where('status', '=',1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorryFule/printpdf/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Print Invoice"><i class="fa fa-print"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
				array_push($rowData, '<input type="checkbox" class="messageCheckbox" name="trip[]" value="' . $value->id . '">');
                                array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

		//}else{
			//return Response::json(array('data'=>[]));
		//}
	}
        
        
        
}
