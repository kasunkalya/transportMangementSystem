<?php
namespace Sammy\TransportDocument\Http\Controllers;

use Sammy\Permissions\Models\Permission;

use App\Http\Controllers\Controller;
use Sammy\Permissions\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Response;
use App\Models\forecast;
use App\Models\quotation;
use Sammy\TransportDocument\Http\Requests\TransportDocumentRequest;
use Sammy\TransportDocument\Models\TransportDocument;
use Sentinel;
use Illuminate\Support\Facades\DB;
use PDF;

class TransportDocumentController extends Controller {

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
		$entekDocument= DB::table('muthumala_document_type')->lists('document_type_name' , 'document_type_id' );  	 
   		$tagList= DB::table('muthumala_tag_list')->get();  		
		return view( 'transportDocument::add' )->with(['entekDocument' => $entekDocument,'tagList'=>$tagList]);

		
	}

	/**
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function add(TransportDocumentRequest $request)
	{
                $user = Sentinel::getUser();					
							
                    $entekCustomer= TransportDocument::create([
                            'document_layout'=>$request->editor1,
                            'document_type_id'=>$request->documentType,    
							'document_name'=>$request->document_name,    
                            'created_by'=>$user->id                    
                    ])->id;
                    
					
						

               return redirect( 'transportDocument/add' )->with([ 'success' => true,
                            'success.message' => 'Document added successfully!',
                            'success.title'   => 'Well Done!' ]);
                
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function listView()
	{
		return view( 'transportDocument::list' );
	}

	/**
	 * Show the menu add screen to the user.
	 *
	 * @return Response
	 */
	public function jsonList(Request $request)
	{
			$data = TransportDocument::all();
			$jsonList = array();
			$i=1;
			foreach ($data as $value) {
				$rowData= array();
				array_push($rowData,$i);
				array_push($rowData,$value->document_name);		
				
				$permissions = Permission::whereIn('name', ['document.edit', 'admin'])->where('status', '=', 1)->lists('name');

				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="blue" onclick="window.location.href=\'' . url('transportDocument/edit/' . $value->document_layout_id) . '\'" data-toggle="tooltip" data-placement="top" title="Edit document"><i class="fa fa-pencil"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Edit Disabled"><i class="fa fa-pencil"></i></a>');
				}            
				$permissions = Permission::whereIn('name', ['document.delete', 'admin'])->where('status', '=', 1)->lists('name');
				if (Sentinel::hasAnyAccess($permissions)) {
					array_push($rowData, '<a href="#" class="red type-delete" data-id="' . $value->document_layout_id . '" data-toggle="tooltip" data-placement="top" title="Delete document"><i class="fa fa-trash-o"></i></a>');
				} else {
					array_push($rowData, '<a href="#" class="disabled" data-toggle="tooltip" data-placement="top" title="Delete Disabled"><i class="fa fa-trash-o"></i></a>');
				}

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
	public function delete(Request $request)
	{
		if($request->ajax()){
			$id = $request->input('id');
			$Customer = DB::table('muthumala_document_layout')->where('document_layout_id','=',$id)->delete();

                            return response()->json(['status' => 'success']);
			//}else{
                        //    return response()->json(['status' => 'invalid_id']);
			//}
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
		
	
			
		$layout = TransportDocument::where('document_layout_id','=',$id)->get();	
		$muthumalaDocument= DB::table('muthumala_document_type')->lists('document_type_name' , 'document_type_id' );  	
   		$tagList= DB::table('muthumala_tag_list')->get();  	
		return view( 'transportDocument::edit' )->with(['layout'=>$layout,'muthumalaDocument' => $muthumalaDocument,'tagList'=>$tagList]);
		
		
	}

	/** 
	 * Add new menu data to database
	 *
	 * @return Redirect to menu add
	 */
	public function edit(TransportDocumentRequest $request, $id)
	{
				$user = Sentinel::getUser(); 
						
				DB::table('muthumala_document_layout')
              ->where('document_layout_id', $id)
              ->update(['document_layout' => $request->editor1,'document_type_id'=>$request->documentType,'document_name'=>$request->document_name,'updated_by'=>$user->id]);
          
		return redirect('transportDocument/list')->with([ 'success' => true,
			'success.message'=> 'Layout Update successfully!',
			'success.title' => 'Well Done!']);
	}
        
        /**
	 * Show the menu view screen to the user.
	 *
	 * @return Response
	 */
	public function viewView($id)
	{	
			$entekProduct= DB::table('entek_product_list')
            ->join('entek_product_type', 'entek_product_list.product_type', '=', 'entek_product_type.type_id')
			->orderBy('entek_product_list.product_type')
            ->get();
			
			
		$entekService= DB::table('entek_services')
            ->join('entek_services_type', 'entek_services.service_type', '=', 'entek_services_type.service_type_id')
			->orderBy('entek_services.service_type')
            ->get();	
			
		$entekServiceType= DB::table('entek_services_type')->get();		
			
		$customer = EntekCustomer::where('clientId','=',$id)->get();
		$forecastlist = forecast::where('client_id','=',$id)->get();
		$quotationItemList = quotation::where('client_id','=',$id)->where('type','=',1)->get();
		$quotationServiseList = quotation::where('client_id','=',$id)->where('type','=',2)->get();
		
		return view( 'entekCustomer::view' )->with(['entekProduct' => $entekProduct,'entekService'=>$entekService,'entekServiceType'=>$entekServiceType,'customer'=>$customer,'forecast'=>$forecastlist,'quotationItemList'=>$quotationItemList,'quotationServiseList'=>$quotationServiseList]);
		
		
	}
	
	
	public function createPDF() {
        $data = ['title' => 'Laravel 7 Generate PDF From View Example Tutorial'];
        $pdf = PDF::loadView('entekCustomer::pdf', $data); 
        return $pdf->download('Nicesnippets.pdf');

    }
	
	
	
}
