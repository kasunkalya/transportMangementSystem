<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sammy\TransportDocument\Models\TransportDocument;
//use Sammy\EntekDocument\Models\EntekDocument;
//use Sammy\EntekCustomer\Models\EntekCustomer;
//use Sammy\EntekProduct\Models\EntekProduct;
use App\Models\forecast;
use App\Models\quotation;
use App\Models\companyContact;
use PDF;
use Illuminate\Support\Facades\DB;
use Sammy\TransportChargin\Models\TransportChargin;
use Sammy\TransportLorryChargers\Models\TransportLorryChargers;
use Sammy\TransportLorry\Models\TransportLorry;
use Sammy\TransportRoute\Models\TransportRoute;
use Sammy\TransportEmployee\Models\TransportEmployee;
use Sammy\TransportManagement\Models\TransportManagement;
use Sammy\TransportManagement\Models\TransportInvoice;
use Sammy\TransportCompany\Models\TransportCompany;
use Sammy\TransportCustomer\Models\TransportCustomer;
use Sammy\TransportManagement\Models\TransportLogsheet;
use Sammy\TransportManagement\Models\TransportInvoiceList;


class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id,$layout)
    {
        //

				$layout = TransportDocument::where('document_layout_id','=',$layout)->get();	
				$invoice = TransportInvoice::find($id);      
                $company= TransportCustomer::find($invoice['customer']);
                $contactPerson= companyContact::find($invoice['contact_person']);
                $muthuCompany=TransportCompany::find($invoice['company']);
                $route=  TransportRoute::find($invoice['route_id']); 
					
					$trips= DB::table('muthumala_lorries')
					->join('muthumala_transport_trips', 'muthumala_lorries.id', '=', 'muthumala_transport_trips.lorry_id')
					->where('muthumala_transport_trips.invoice_id','=',$invoice['id'])
					->get();
				
				$tags= DB::table('muthumala_tag_list')->get();
		
		
		$data= ['layout' =>$layout,'contactPerson' => $contactPerson,'company' => $company,'invoice'=>$invoice,'routes'=>$route,'trips'=>$trips,'tagList'=>$tags,'muthucompany' => $muthuCompany];
		
		$pdf = PDF::loadView('pdf',$data); 
        return $pdf->download($invoice['invoice_number'].'.pdf');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
