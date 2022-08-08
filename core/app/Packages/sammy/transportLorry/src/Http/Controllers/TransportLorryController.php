<?php
namespace Sammy\TransportLorry\Http\Controllers;

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
use Sammy\TransportLorry\Models\TransportLorryMilage;
use Sammy\TransportChargin\Models\TransportChargin;
use Sammy\TransportLorryChargers\Models\TransportLorryChargers;
use Sentinel;
use Response;
use Hash;
use Activation;
use GuzzleHttp;
use DB;

class TransportLorryController extends Controller {

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
                $maker = Maker::all()->lists('maker_name' , 'id' );
                $insuranceCompanies = InsuranceCompanies::all()->lists('insurance_company_name' , 'id' );
		$emissionCompanies= EmissionCompanies::all()->lists('emission_company_name' , 'id' );
                $leasingCompanies= LeasingCompanies::all()->lists('leasing_company_name' , 'id' );
                $licenseprovince= \App\Models\Province::all()->lists('province' , 'id' );
                return view( 'transportLorry::add' )->with([
                    'company' => $company,
                    'maker'=>$maker,
                    'licenseprovince'=>$licenseprovince,
                    'insuranceCompanies'=>$insuranceCompanies,
                    'emissionCompanies'=>$emissionCompanies,
                    'leasingCompanies'=>$leasingCompanies
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
                
                $attachmentFile=$request->file('vehicleBook');
                $attachment='';
                            if($attachmentFile !=""){
                                    $destinationPath = 'lorryAttachments/'.$request->licensePlate;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_atachmnet_'.$request->licensePlate.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            } 
                            
                            
                $valuationFile=$request->file('valuation');
                $valuation='';
                            if($valuationFile !=""){
                                    $destinationPath = 'lorryValuation/'.$request->licensePlate;
                                    $attachmentFilename = $valuationFile->getClientOriginalName();
                                    $extension = $valuationFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_valuation_'.$request->licensePlate.'.'.$extension;
                                    $upload_success = $valuationFile->move($destinationPath,$attachmentFilename);
                                    $valuation=$attachmentFilename;
                            }             
                            
                
                if($request->ownerSection ==1){
                    $transportaRoute= TransportLorry::create([
                            'owner_section'=>$request->ownerSection,
                            'owner_id'=>$request->company,
                            'owner_name'=>'',
                            'licence_plate'=>$request->licensePlate,
                            'maker_id'=>$request->maker,
                            'model_id'=>$request->model,
                            'height'=>$request->height,
                            'width'=>$request->Width,
                            'length'=>$request->length,
                            'max_pay_load'=>$request->maxload,
                            'ton_amount'=>$request->ton,
                            'cbm_amount'=>$request->cbm,
                            'insurance_company_id'=>$request->insuranceCompanies,
                            'licenseProvince'=>$request->licenseprovince,
                            'licenseRenewDate'=>$request->licensedate,
                            'licensePaymentAmount'=>$request->licenseAmount,
                            'insurance_renew_date'=>$request->insurancedate,
                            'insurance_policy_number'=>$request->insurancePolicy,
                            'noclambonus'=>$request->noclambonus,
                            'emission_company_id'=>$request->emissionCompanies,
                            'emission_renew_date'=>$request->Emissiondate,
                            'leasing_company_id'=>$request->leasingCompanies,
                            'leasing_amount'=>$request->leasingAmount,
                            'book'=>$attachment,
                            'valuation'=>$valuation,
                            'created_by'=>$user->id		

                    ]);
                }else{
                       $transportaRoute= TransportLorry::create([
                            'owner_section'=>$request->ownerSection,  
                            'owner_id'=>0,
                            'owner_name'=>$request->owner,
                            'ownerAddress'=>$request->ownerAddress,
                            'licence_plate'=>$request->licensePlate,
                            'maker_id'=>$request->maker,
                            'model_id'=>$request->model,
                            'height'=>$request->height,
                            'width'=>$request->Width,
                            'length'=>$request->length,
                            'max_pay_load'=>$request->maxload,
                            'ton_amount'=>$request->ton,
                            'cbm_amount'=>$request->cbm,
                            'insurance_company_id'=>$request->insuranceCompanies,
                            'insurance_renew_date'=>$request->insurancedate,
                            'insurance_policy_number'=>$request->insurancePolicy,
                            'emission_company_id'=>$request->emissionCompanies,
                            'emission_renew_date'=>$request->Emissiondate,
                            'leasing_company_id'=>$request->leasingCompanies,
                            'leasing_amount'=>$request->leasingAmount,
                            'ownerBank'=>$request->ownerBank,
                            'ownerBankAccount'=>$request->ownerBankAccount,
                            'ownerBankBranch'=>$request->branch,
                            'book'=>$attachment,
                            'valuation'=>$valuation,
                            'created_by'=>$user->id	
                        ]);
                }

		return redirect( 'transportLorry/add' )->with([ 'success' => true,
			'success.message' => 'Lorry added successfully!',
			'success.title'   => 'Well Done!' ]);
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportLorry::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLorry::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
                                
                                $owner= TransportCompany::where('id',$value->owner_id)->first(); 
                                $ownerName=$owner['company_name'];
				array_push($rowData,$i);
                                if($value->owner_id !=0){
                                    array_push($rowData,$ownerName);
                                }
                                else{
                                    array_push($rowData,$value->owner_name);
                                }
				array_push($rowData,$value->licence_plate);

				$permissions = Permission::whereIn('name', ['lorry.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorry/edit/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Lorry"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
                                $permissions = Permission::whereIn('name', ['lorry.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorry/view/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="View Lorry"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>');
				}
                                
                                
                                $permissions = Permission::whereIn('name', ['lorry.payment','lorry.viewpayment', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorry/pay/' . $value->id) . '\'" data-toggle="tooltip" data-placement="top" title="Charging Rules"><i class="fa fa-dollar"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Disabled Charging Rules"><i class="fa fa-dollar"></i></a>');
				}
                                
				$permissions = Permission::whereIn('name', ['lorry.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->id . '" data-toggle="tooltip" data-placement="top" title="Delete Lorry"><i class="fa fa-trash-o"></i></a>');
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

			$lorry = TransportLorry::find($id);
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
		$lorry= TransportLorry::where('id','=',$id)->get();
                $company = TransportCompany::all()->lists('company_name' , 'id' );
                $maker = Maker::all()->lists('maker_name' , 'id' );
                $insuranceCompanies = InsuranceCompanies::all()->lists('insurance_company_name' , 'id' );
		$emissionCompanies= EmissionCompanies::all()->lists('emission_company_name' , 'id' );
                $leasingCompanies= LeasingCompanies::all()->lists('leasing_company_name' , 'id' );
                $licenseprovince= \App\Models\Province::all()->lists('province' , 'id' );
		if($lorry){
                            return view( 'transportLorry::edit' )->with([
                                'company' => $company,
                                'maker'=>$maker,
                                'insuranceCompanies'=>$insuranceCompanies,
                                'licenseprovince'=>$licenseprovince,
                                'emissionCompanies'=>$emissionCompanies,
                                'leasingCompanies'=>$leasingCompanies,
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
		$Lorry = TransportLorry::find($id);                
                $attachmentFile=$request->file('vehicleBook');
                $attachment=$Lorry->book;
                            if($attachmentFile !=""){
                                    $destinationPath = 'lorryAttachments/'.$request->licensePlate;
                                    $attachmentFilename = $attachmentFile->getClientOriginalName();
                                    $extension = $attachmentFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_atachmnet_'.$request->licensePlate.'.'.$extension;
                                    $upload_success = $attachmentFile->move($destinationPath,$attachmentFilename);
                                    $attachment=$attachmentFilename;
                            }   
                $valuationFile=$request->file('valuation');
                $valuation=$Lorry->valuation;
                            if($valuationFile !=""){
                                    $destinationPath = 'lorryValuation/'.$request->licensePlate;
                                    $attachmentFilename = $valuationFile->getClientOriginalName();
                                    $extension = $valuationFile->getClientOriginalExtension();
                                    $attachmentFilename='lorry_valuation_'.$request->licensePlate.'.'.$extension;
                                    $upload_success = $valuationFile->move($destinationPath,$attachmentFilename);
                                    $valuation=$attachmentFilename;
                            }      
                            
                            
                            
                if($request->ownerSection ==1){                   
                            $Lorry->owner_section= $request->ownerSection;
                            $Lorry->owner_id=$request->company;
                            $Lorry->owner_name='';
                            $Lorry->licence_plate=$request->licensePlate;
                            $Lorry->maker_id=$request->maker;
                            $Lorry->model_id=$request->model;
                            $Lorry->height=$request->height;
                            $Lorry->width=$request->Width;
                            $Lorry->length=$request->length;
                            $Lorry->max_pay_load=$request->maxload;
                            $Lorry->ton_amount=$request->ton;
                            $Lorry->cbm_amount=$request->cbm;
                            $Lorry->insurance_company_id=$request->insuranceCompanies;
                            $Lorry->licenseProvince=$request->licenseprovince;
                            $Lorry->licenseRenewDate=$request->licensedate;
                            $Lorry->licensePaymentAmount=$request->licenseAmount;
                            $Lorry->insurance_renew_date=$request->insurancedate;
                            $Lorry->insurance_policy_number=$request->insurancePolicy;
                            $Lorry->emission_company_id=$request->emissionCompanies;
                            $Lorry->emission_renew_date=$request->Emissiondate;
                            $Lorry->leasing_company_id=$request->leasingCompanies;
                            $Lorry->leasing_amount=$request->leasingAmount;
                            $Lorry->book=$attachment;
                            $Lorry->valuation=$valuation;
                            $Lorry->created_by=$user->id;		

               
                }else{             
                            $Lorry->owner_section= $request->ownerSection;
                            $Lorry->owner_id=0;
                            $Lorry->owner_name=$request->owner;
                            $Lorry->ownerAddress=$request->ownerAddress;
                            $Lorry->licence_plate=$request->licensePlate;
                            $Lorry->maker_id=$request->maker;
                            $Lorry->model_id=$request->model;
                            $Lorry->height=$request->height;
                            $Lorry->width=$request->Width;
                            $Lorry->length=$request->length;
                            $Lorry->max_pay_load=$request->maxload;
                            $Lorry->ton_amount=$request->ton;
                            $Lorry->cbm_amount=$request->cbm;
                            $Lorry->insurance_company_id=$request->insuranceCompanies;
                            $Lorry->insurance_renew_date=$request->insurancedate;
                            $Lorry->insurance_policy_number=$request->insurancePolicy;
                            $Lorry->emission_company_id=$request->emissionCompanies;
                            $Lorry->emission_renew_date=$request->Emissiondate;
                            $Lorry->leasing_company_id=$request->leasingCompanies;
                            $Lorry->leasing_amount=$request->leasingAmount;
                            $Lorry->ownerBank=$request->ownerBank;
                            $Lorry->ownerBankAccount=$request->ownerBankAccount;
                            $Lorry->ownerBankBranch=$request->branch;
                            $Lorry->book=$attachment;
                            $Lorry->valuation=$valuation;
                            $Lorry->created_by=$user->id;
                }           
		$Lorry->save();    
		return redirect('transportLorry/list')->with([ 'success' => true,
			'success.message'=> 'Lorry Update successfully!',
			'success.title' => 'Well Done!']);
	}
        
        /** 
	 * get model data to database
	 *
	 * @return 
	 */
        public function getModel($id){     
   
               $model = LorryModel::where("maker_id","=",$id)->lists("id","model_name");             
                return json_encode($model);
        }
        
        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
		$lorry= TransportLorry::where('id','=',$id)->get();
                $company = TransportCompany::all()->lists('company_name' , 'id' );
                $licenseprovince= \App\Models\Province::all()->lists('province' , 'id' );
                $maker = Maker::all()->lists('maker_name' , 'id' );
                $insuranceCompanies = InsuranceCompanies::all()->lists('insurance_company_name' , 'id' );
		$emissionCompanies= EmissionCompanies::all()->lists('emission_company_name' , 'id' );
                $leasingCompanies= LeasingCompanies::all()->lists('leasing_company_name' , 'id' );
              
		if($lorry){
                            return view( 'transportLorry::view' )->with([
                                'company' => $company,
                                'maker'=>$maker,
                                'insuranceCompanies'=>$insuranceCompanies,
                                'licenseprovince'=>$licenseprovince,
                                'emissionCompanies'=>$emissionCompanies,
                                'leasingCompanies'=>$leasingCompanies,
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
	public function jsonLorryexpireList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLorry::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();    
                           
                                
                                $insurance=$value->insurance_renew_date;
                                $emission=$value->emission_renew_date;
                                
                               
                                    $nextinsurance =date('Y-m-d', strtotime($insurance. ' + 365 days'));
                                    $nextemission =date('Y-m-d', strtotime($emission. ' + 365 days'));
                                    
                                    $earlier = new \DateTime($nextinsurance);
                                    $later = new \DateTime(date('Y-m-d'));
                                    $diff = $later->diff($earlier)->format("%a");
                                    
                                    $earlieremission = new \DateTime($nextemission);
                                    $lateremission = new \DateTime(date('Y-m-d'));
                                    $diffemission = $lateremission->diff($earlieremission)->format("%a");
                                    
                                    if($insurance !='0000-00-00'){
                                        if($diff >=0){
                                            array_push($rowData,$value->licence_plate);
                                            array_push($rowData,$nextinsurance);
                                            array_push($rowData,$diff); 
                                            array_push($rowData,'I'); 

                                        }
                                    }
                                    if($emission !='0000-00-00'){
                                        if($diffemission >=0){
                                            array_push($rowData,$value->licence_plate);
                                            array_push($rowData,$nextemission);
                                            array_push($rowData,$diffemission); 
                                            array_push($rowData,'E'); 
                                            //array_push($jsonList, $rowData);
                                        }
                                    }
				 array_push($jsonList, $rowData);
				$i++;

			}
                     
			return Response::json($jsonList);

		//}else{
			//return Response::json(array('data'=>[]));
		//}
	}
        
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function milageAddView()
	{
                $lorry= TransportLorry::all();
                return view( 'transportLorry::addMilage' )->with([
                    'lorry' => $lorry
		]);
	
	}
        
         /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function milageAdd(TransportLorryRequest $request)
	{
            
                      $user = Sentinel::getUser();  
                      $count=sizeof($request->lorry)-1;                    
                      for ($x = 0; $x <= $count; $x++) {  
                        $lorryId=$request->lorry[$x];
                        $milage=$request->milage[$x];                          
                        $list = TransportLorryMilage::where('lorry_id','=',$lorryId)->where('date',$request->date)->get();
                        $listCount = $list->count(); 
                        if($listCount !=0){
                            
                            DB::table('muthumala_lorry_milage')
                            ->where('lorry_id','=',$lorryId)
                            ->where('date',$request->date)        
                            ->update(['date' => $request->date],['milage' => $milage],['lorry_id' =>$lorryId],['updated_by' =>$user->id]);                            
                            
                        }else{
                            $companyContact= TransportLorryMilage::create([			
                                          'date'=>$request->date,
                                          'milage'=>$milage,                       
                                          'lorry_id'=>$lorryId, 				
                                          'created_by'=>$user->id
                            ]);
                        }
                        
                      }
                      
                      return redirect( 'transportLorry/addMilage' )->with([ 'success' => true,
			'success.message' => 'Milage added successfully!',
			'success.title'   => 'Well Done!' ]);
            
	}
        
        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function milagelistView()
	{
		return view( 'transportLorry::milagelist' );
	}

        /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonmilageList(Request $request)
	{
		//if($request->ajax()){
			$data = TransportLorryMilage::all()->unique('date');
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();                           
				array_push($rowData,$i);                              
				array_push($rowData,$value->date);

				$permissions = Permission::whereIn('name', ['lorryMilage.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorry/milageedit/' . $value->date) . '\'" data-toggle="tooltip" data-placement="top" title="Edit Milage"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}
                                
                                $permissions = Permission::whereIn('name', ['lorryMilage.view', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportLorry/milageview/' . $value->date) . '\'" data-toggle="tooltip" data-placement="top" title="View Milage"><i class="fa fa-eye"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="View Disabled"><i class="fa fa-eye"></i></a>');
				}
                                
                                
                                

				$permissions = Permission::whereIn('name', ['lorryMilage.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->date . '" data-toggle="tooltip" data-placement="top" title="Delete Milage"><i class="fa fa-trash-o"></i></a>');
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
        
        public function milageeditView($id)
	{	
                            return view( 'transportLorry::editMilage' )->with([
                                'date' => $id
                            ]);

	}
        
          /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonmilageeditList($id)
	{
     
		//if($request->ajax()){
			$data = TransportLorryMilage::all()->where('date',$id);
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
                                $lorry= TransportLorry::find($value->lorry_id);
				$rowData= array(); 
                                array_push($rowData, $lorry['licence_plate'].'<input type="hidden" class="form-control" name="lorry[]" value="'.$value->lorry_id.'">');
                                array_push($rowData, '<input type="text" class="form-control" name="milage[]"  value="'.$value->milage.'">');
                                array_push($jsonList, $rowData);
				$i++;
			}
			return Response::json(array('data' => $jsonList));

		//}else{
			//return Response::json(array('data'=>[]));
		//}
	}
        
         /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function milageEdit(TransportLorryRequest $request, $id)
	{
            
                      $user = Sentinel::getUser();  
                      $count=sizeof($request->lorry)-1;                    
                      for ($x = 0; $x <= $count; $x++) {  
                        $lorryId=$request->lorry[$x];
                        $milage=$request->milage[$x];   
                            DB::table('muthumala_lorry_milage')
                            ->where('lorry_id','=',$lorryId)
                            ->where('date',$id)        
                            ->update(['milage' => $milage],['lorry_id' =>$lorryId],['updated_by' =>$user->id]);                          
                      }
                      
                      return redirect( 'transportLorry/milageedit/'.$id )->with([ 'success' => true,
			'success.message' => 'Milage updated successfully!',
			'success.title'   => 'Well Done!' ]);
            
	}
        
         
        public function milageviewView($id)
	{	
                            return view( 'transportLorry::viewMilage' )->with([
                                'date' => $id
                            ]);
	}
        
          /**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonmilageviewList($id)
	{     
			$data = TransportLorryMilage::all()->where('date',$id);
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
                                $lorry= TransportLorry::find($value->lorry_id);
				$rowData= array(); 
                                array_push($rowData, $lorry['licence_plate'].'<input type="hidden" readonly class="form-control" name="lorry[]" value="'.$value->lorry_id.'">');
                                array_push($rowData, '<input type="text" readonly class="form-control" name="milage[]"  value="'.$value->milage.'">');
                                array_push($jsonList, $rowData);
				$i++;
			}
			return Response::json(array('data' => $jsonList));

	}
        
        /**
	 * Delete a Menu
	 * @param  Request $request menu id
	 * @return Json           	json object with status of success or failure
	 */
	public function deletemilage(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');

			$contacts = TransportLorryMilage::where('date',$id);
                        if($contacts){
				$contacts->delete();
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
	public function summaryView()
	{	
		$lorry= TransportLorry::all()->lists('licence_plate' , 'id' );
                $company = TransportCompany::all()->lists('company_name' , 'id' );
                $maker = Maker::all()->lists('maker_name' , 'id' );
                $insuranceCompanies = InsuranceCompanies::all()->lists('insurance_company_name' , 'id' );
		$emissionCompanies= EmissionCompanies::all()->lists('emission_company_name' , 'id' );
                $leasingCompanies= LeasingCompanies::all()->lists('leasing_company_name' , 'id' );
              
		if($lorry){
                            return view( 'transportLorry::summary' )->with([
                                'company' => $company,
                                'maker'=>$maker,
                                'insuranceCompanies'=>$insuranceCompanies,
                                'emissionCompanies'=>$emissionCompanies,
                                'leasingCompanies'=>$leasingCompanies,
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
	public function jsonsummaySearchList($fromDate,$toDate)
	{
        
                        $data = TransportLorry::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();   
                               
                                $tripKilomiters = DB::table('muthumala_transport_trips')
                                        ->join('muthumala_transport_routes', 'muthumala_transport_trips.route_id', '=', 'muthumala_transport_routes.id')
                                        ->where('muthumala_transport_trips.lorry_id','=',$value->id)                                       
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_routes.minDistance')
                                        ;
                                
                                $miterKilomiters = DB::table('muthumala_lorry_milage')
                                        ->where('muthumala_lorry_milage.lorry_id','=',$value->id)                                       
                                        ->whereBetween('muthumala_lorry_milage.date', [$fromDate, $toDate])
                                        ->get()
                                        ;
                                $lastrow=sizeof($miterKilomiters)-1;
                                
                                if($lastrow >= 0){
                                    $arr = [];
                                    foreach($miterKilomiters as $row)
                                    {
                                        $arr[] = (array) $row;
                                    }
                                    $lastMilage=$arr[$lastrow]['milage'];
                                    $firstMilage=$arr[0]['milage'];
                                    $milageForReading=$lastMilage-$firstMilage;
                                }else{
                                    $milageForReading=0;
                                }
                                
                                $tripChargers = DB::table('muthumala_transport_trips')
                                        ->where('muthumala_transport_trips.lorry_id','=',$value->id)                                       
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_trips.paymentAmount')
                                        ;
                                 
                                $tripDiscount = DB::table('muthumala_transport_trips')
                                        ->where('muthumala_transport_trips.lorry_id','=',$value->id)                                       
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_trips.paymentDiscount')
                                        ; 
                                
                                $tripChargers=$tripChargers - $tripDiscount;
                                
                                $driverCharge = DB::table('muthumala_transport_trips')
                                        ->where('muthumala_transport_trips.lorry_id','=',$value->id)                                       
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_trips.driver_rate')
                                        ; 
                                $helperCharge = DB::table('muthumala_transport_trips')
                                        ->where('muthumala_transport_trips.lorry_id','=',$value->id)                                       
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_trips.helper_rate')
                                        ; 
                                
                                 $fuleCharge = DB::table('muthumala_fule')
                                        ->where('muthumala_fule.lorry','=',$value->id)                                       
                                        ->whereBetween('muthumala_fule.fuleDate', [$fromDate, $toDate])
                                        ->sum('muthumala_fule.amount')
                                        ; 
                                 
                                 $repairCharge = DB::table('muthumala_lorry_repair')
                                        ->where('muthumala_lorry_repair.lorry','=',$value->id)                                       
                                        ->whereBetween('muthumala_lorry_repair.repairDate', [$fromDate, $toDate])
                                        ->sum('muthumala_lorry_repair.repairCharge')
                                        ;  
                                 
                                 $servicesCharge = DB::table('muthumala_lorry_services')
                                        ->where('muthumala_lorry_services.lorry','=',$value->id)                                       
                                        ->whereBetween('muthumala_lorry_services.servicesDate', [$fromDate, $toDate])
                                        ->sum('muthumala_lorry_services.serviceCharge')
                                        ;  
                                 
                                $income=$tripChargers -($fuleCharge + $repairCharge + $servicesCharge + $driverCharge + $helperCharge );
                                //$income=$tripChargers;

//                                $route=  TransportRoute::find($value->route_id);
//                                $customer=  TransportCustomer::find($value->customer);
//                                $total=$value->total_amount-$value->total_discount;
//                                $vat=($total * $value->vat_amount )/100;
//                                $nettotal=$total + $vat;
                                 if($tripKilomiters ==0){
                                     $tripKilomitersD=1;
                                 }
                                 else{
                                     $tripKilomitersD=$tripKilomiters;
                                 }
                                 if($milageForReading ==0){
                                     $milageForReadingD=1;
                                 }
                                 else{
                                     $milageForReadingD=$milageForReading;
                                 }
                                 
                                 if($tripKilomiters==''){$tripKilomiters=0;}else{$tripKilomiters=$tripKilomiters;}
                                 if($milageForReading==''){$milageForReading=0;}else{$milageForReading=$milageForReading;}
                                 if($fuleCharge==''){$fuleCharge=0;}else{$fuleCharge=$fuleCharge;}
                                 if($repairCharge==''){$repairCharge=0;}else{$repairCharge=$repairCharge;}
                                 if($servicesCharge==''){$servicesCharge=0;}else{$servicesCharge=$servicesCharge;}
                                 if($driverCharge==''){$driverCharge=0;}else{$driverCharge=$driverCharge;}
                                 if($helperCharge==''){$helperCharge=0;}else{$helperCharge=$helperCharge;}                                 
                                 if($tripChargers==''){$tripChargers=0;}else{$tripChargers=$tripChargers;}  
                                 
                                 
				array_push($rowData,$i);
				array_push($rowData,$value->licence_plate);
				array_push($rowData,$tripKilomiters);	
                                array_push($rowData,$milageForReading);
                                array_push($rowData,$fuleCharge);
                                array_push($rowData,$repairCharge);
                                array_push($rowData,$servicesCharge);                                
                                array_push($rowData,$driverCharge);
                                array_push($rowData,$helperCharge);
                                array_push($rowData,$tripChargers);
                                array_push($rowData,$income/$tripKilomitersD);
                                array_push($rowData,$income/$milageForReadingD);
				array_push($jsonList, $rowData);
				$i++;

			}
			return Response::json(array('data' => $jsonList));

	}
        
         /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function summaryDraftView()
	{	
		$lorry= TransportLorry::all()->lists('licence_plate' , 'id' );
                $company = TransportCompany::all()->lists('company_name' , 'id' );
                $maker = Maker::all()->lists('maker_name' , 'id' );
                $insuranceCompanies = InsuranceCompanies::all()->lists('insurance_company_name' , 'id' );
		$emissionCompanies= EmissionCompanies::all()->lists('emission_company_name' , 'id' );
                $leasingCompanies= LeasingCompanies::all()->lists('leasing_company_name' , 'id' );
              
		if($lorry){
                            return view( 'transportLorry::summaryDraft' )->with([
                                'company' => $company,
                                'maker'=>$maker,
                                'insuranceCompanies'=>$insuranceCompanies,
                                'emissionCompanies'=>$emissionCompanies,
                                'leasingCompanies'=>$leasingCompanies,
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
	public function jsonsummayDate($fromDate,$toDate)
	{
        
                    
				$rowData= array();   
                               
                                $tripKilomiters = DB::table('muthumala_transport_trips')
                                        ->join('muthumala_transport_routes', 'muthumala_transport_trips.route_id', '=', 'muthumala_transport_routes.id')
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_routes.minDistance')
                                        ;
                                
                                $miterKilomiters = DB::table('muthumala_lorry_milage')                                  
                                        ->whereBetween('muthumala_lorry_milage.date', [$fromDate, $toDate])
                                        ->get()
                                        ;
                                $lastrow=sizeof($miterKilomiters)-1;
                                
                                if($lastrow >= 0){
                                    $arr = [];
                                    foreach($miterKilomiters as $row)
                                    {
                                        $arr[] = (array) $row;
                                    }
                                    $lastMilage=$arr[$lastrow]['milage'];
                                    $firstMilage=$arr[0]['milage'];
                                    $milageForReading=$lastMilage-$firstMilage;
                                }else{
                                    $milageForReading=0;
                                }
                                
                                $tripChargers = DB::table('muthumala_transport_trips')                                    
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_trips.paymentAmount')
                                        ;
                                 
                                $tripDiscount = DB::table('muthumala_transport_trips')                                       
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_trips.paymentDiscount')
                                        ; 
                                
                                $tripChargers=$tripChargers - $tripDiscount;
                                
                                $driverCharge = DB::table('muthumala_transport_trips')                                      
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_trips.driver_rate')
                                        ; 
                                $helperCharge = DB::table('muthumala_transport_trips')                                     
                                        ->whereBetween('muthumala_transport_trips.invoice_date', [$fromDate, $toDate])
                                        ->sum('muthumala_transport_trips.helper_rate')
                                        ; 
                                
                                 $fuleCharge = DB::table('muthumala_fule')                                    
                                        ->whereBetween('muthumala_fule.fuleDate', [$fromDate, $toDate])
                                        ->sum('muthumala_fule.amount')
                                        ; 
                                 
                                 $repairCharge = DB::table('muthumala_lorry_repair')                                      
                                        ->whereBetween('muthumala_lorry_repair.repairDate', [$fromDate, $toDate])
                                        ->sum('muthumala_lorry_repair.repairCharge')
                                        ;  
                                 
                                 $servicesCharge = DB::table('muthumala_lorry_services')                                     
                                        ->whereBetween('muthumala_lorry_services.servicesDate', [$fromDate, $toDate])
                                        ->sum('muthumala_lorry_services.serviceCharge')
                                        ;  
                                 
                                $income=$tripChargers -($fuleCharge + $repairCharge + $servicesCharge + $driverCharge + $helperCharge );

                                 if($tripKilomiters ==0){
                                     $tripKilomitersD=1;
                                 }
                                 else{
                                     $tripKilomitersD=$tripKilomiters;
                                 }
                                 if($milageForReading ==0){
                                     $milageForReadingD=1;
                                 }
                                 else{
                                     $milageForReadingD=$milageForReading;
                                 }
                                 
                                 if($tripKilomiters==''){$tripKilomiters=0;}else{$tripKilomiters=$tripKilomiters;}
                                 if($milageForReading==''){$milageForReading=0;}else{$milageForReading=$milageForReading;}
                                 if($fuleCharge==''){$fuleCharge=0;}else{$fuleCharge=$fuleCharge;}
                                 if($repairCharge==''){$repairCharge=0;}else{$repairCharge=$repairCharge;}
                                 if($servicesCharge==''){$servicesCharge=0;}else{$servicesCharge=$servicesCharge;}
                                 if($driverCharge==''){$driverCharge=0;}else{$driverCharge=$driverCharge;}
                                 if($helperCharge==''){$helperCharge=0;}else{$helperCharge=$helperCharge;}                                 
                                 if($tripChargers==''){$tripChargers=0;}else{$tripChargers=$tripChargers;}  
                                 
				
				array_push($rowData,$tripKilomiters);	
                                array_push($rowData,$milageForReading);
                                array_push($rowData,$fuleCharge);
                                array_push($rowData,$repairCharge);
                                array_push($rowData,$servicesCharge);                                
                                array_push($rowData,$driverCharge);
                                array_push($rowData,$helperCharge);
                                array_push($rowData,$tripChargers);
                                array_push($rowData,$income/$tripKilomitersD);
                                array_push($rowData,$income/$milageForReadingD);			
                                return Response::json($rowData);

	}
        
        /**
	 * Show the menu edit screen to the user.
	 *
	 * @return Response
	 */
	public function paymentView($id)
	{	
            
                $permissions = Permission::whereIn('name', ['lorry.payment','admin'])->where('status', '=', 1)->lists('name');
                if (Sentinel::hasAnyAccess($permissions)) {
                    $paymentView=1;
                } else {
                     $paymentView=0;
                }
            
		$lorry= TransportLorry::where('id','=',$id)->get();
                $company = TransportChargin::all();         
                $transportChargin= TransportChargin::all();
                $route = TransportRoute::all();
		if($lorry){
                            return view( 'transportLorry::addPayment' )->with([
                                'route'=>$route,                                
                                'company'=>$company,
                                'transportCharginList'=>$transportChargin,
                                'paymentView'=>$paymentView,
                                'lorry'=>$lorry
                            ]);
		}else{
			return view( 'errors.404' )->with(['lorry' => $lorry ]);
		}
	}
      
         /** 
	 * get model data to database
	 *
	 * @return 
	 */
        public function getRulelist($id){     
   
               $model = TransportLorryChargers::where("lorry_id","=",$id)->get();             
                return json_encode($model);
        }
        
         /** 
	 * get model data to database
	 *
	 * @return 
	 */
        public function pay(TransportLorryRequest $request, $id){   
                $user = Sentinel::getUser();  
                $count=sizeof($request->value)-1;        
                
              
                
                for ($x = 0; $x <= $count; $x++) {  
                    $value=$request->value[$x];    
                     
                    if($value !=''){    
                        $list = TransportLorryChargers::where('charging_type_id','=',$request->charging[$x])->where('route_id','=',$request->route[$x])->where('lorry_id','=',$id)->get();
                        $listCount = $list->count();                          
                        if($listCount !=0){
                                      $list = TransportLorryChargers::find($list[0]->id);      
                                      $list->lorry_id=$id;
                                      $list->charging_type_id=$request->charging[$x]; 
                                      $list->route_id=$request->route[$x]; 
                                      $list->charges=$value;
                                      $list->updated_by=$user->id;  
                                      $list->save();    
                            
                        }else{
                            $transportaRoute= TransportLorryChargers::create([
                                    'lorry_id'=>$id,
                                    'charging_type_id'=>$request->charging[$x],
                                    'route_id'=>$request->route[$x],
                                    'charges'=>$value,                            
                                    'created_by'=>$user->id		
                            ]);                            
                        }        
                        
                    }
                    
                }
                return redirect( 'transportLorry/pay/'.$id )->with([ 'success' => true,
			'success.message' => 'Charging rule added successfully!',
			'success.title'   => 'Well Done!' ]);
            
        }
        
}
