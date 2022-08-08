@extends('layouts.sammy_new.master') @section('title','Add Transport Customer')
@section('css')
<style type="text/css">
	.panel.panel-bordered {
	    border: 1px solid #ccc;
	}

	.btn-primary {
	    color: white;
	    background-color: #005C99;
	    border-color: #005C99;
	}

	.chosen-container{
		font-family: 'FontAwesome', 'Open Sans',sans-serif;
	}
</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li>
    	<a href="{{{url('entekCustomer/list')}}}">Customers</a>
  	</li>
  	<li class="active">View Customer</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>View Customer</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}      
			
                    <div class="form-group">
	            		<label class="col-sm-2 control-label required">Client Name</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('client_name')) error @endif" name="client_name" id="client_name"  placeholder="Client Name" required value="{{$customer[0]->clientName}}">
							@if($errors->has('client_name'))
								<label id="label-error" class="error" for="client_name">{{$errors->first('client_name')}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Electricity bill  address</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('bill_address')) error @endif" name="bill_address" id="bill_address"  placeholder="Electricity bill  address" required value="{{$customer[0]->ebillAddress}}">
							@if($errors->has('bill_address'))
								<label id="label-error" class="error" for="bill_address">{{$errors->first(bill_address)}}</label>
							@endif							
	            		</div>
	                </div>		   
		   
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Electricity connection</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('electricity_connection')) error @endif" name="electricity_connection" id="electricity_connection"  placeholder="Electricity connection" required value="{{$customer[0]->econnection}}">
							@if($errors->has('electricity_connection'))
								<label id="label-error" class="error" for="electricity_connection">{{$errors->first(electricity_connection)}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">LECO / CEB Account Number</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('account_number')) error @endif" name="account_number" id="account_number"  placeholder="LECO / CEB Account Number" required value="{{$customer[0]->accountNumber}}">
							@if($errors->has('account_number'))
								<label id="label-error" class="error" for="account_number">{{$errors->first(account_number)}}</label>
							@endif							
	            		</div>
	                </div>
		   
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Reference Number</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('reference_number')) error @endif" name="reference_number" id="reference_number"  placeholder="Reference Number" required value="{{$customer[0]->referenceNumber}}">
							@if($errors->has('reference_number'))
								<label id="label-error" class="error" for="reference_number">{{$errors->first(reference_number)}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Client Email</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('email')) error @endif" name="email" id="email"  placeholder="Client Email" required value="{{$customer[0]->email}}">
							@if($errors->has('email'))
								<label id="label-error" class="error" for="email">{{$errors->first(email)}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Client Mobile</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('mobile')) error @endif" name="mobile" id="mobile"  placeholder="Client Mobile" required value="{{$customer[0]->mobile}}">
							@if($errors->has('mobile'))
								<label id="label-error" class="error" for="mobile">{{$errors->first(mobile)}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Proposed Scheme</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('proposed_scheme')) error @endif" name="proposed_scheme" id="proposed_scheme"  placeholder="Proposed Scheme" required value="{{$customer[0]->proposedScheme}}">
							@if($errors->has('proposed_scheme'))
								<label id="label-error" class="error" for="proposed_scheme">{{$errors->first(proposed_scheme)}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">System Panel Capacity</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('system_panel_capacity')) error @endif" name="system_panel_capacity" id="system_panel_capacity"  placeholder="System Panel Capacity" required value="{{$customer[0]->capacity}}">
							@if($errors->has('system_panel_capacity'))
								<label id="label-error" class="error" for="system_panel_capacity">{{$errors->first(system_panel_capacity)}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Panels laid on roof</label>
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('panels_laid_on_roof')) error @endif" name="panels_laid_on_roof" id="panels_laid_on_roof"  placeholder="Panels laid on roof" required value="{{$customer[0]->roof}}">
							@if($errors->has('panels_laid_on_roof'))
								<label id="label-error" class="error" for="panels_laid_on_roof">{{$errors->first(panels_laid_on_roof)}}</label>
							@endif							
	            		</div>
	                </div>					
		   
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Required Roof Area</label> 
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('required_roof_area')) error @endif" name="required_roof_area" id="required_roof_area"  placeholder="Required Roof Area" required value="{{$customer[0]->area}}">
							@if($errors->has('required_roof_area'))
								<label id="label-error" class="error" for="required_roof_area">{{$errors->first(required_roof_area)}}</label>
							@endif							
	            		</div>
	                </div>					
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Single Phase / Three Phase</label> 
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('phase')) error @endif" name="phase" id="phase"  placeholder="Single Phase / Three Phase" required value="{{$customer[0]->phase}}">
							@if($errors->has('phase'))
								<label id="label-error" class="error" for="phase">{{$errors->first(phase)}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">System Price</label> 
	            		<div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('system_price')) error @endif" name="system_price" id="system_price"  placeholder="System Price" required value="{{$customer[0]->Price}}">
							@if($errors->has('system_price'))
								<label id="label-error" class="error" for="system_price">{{$errors->first(system_price)}}</label>
							@endif							
	            		</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Meter shifting required</label> 
	            		<div class="col-sm-10">			
						@if($customer[0]->meterShifting ==1)         
							<input type="radio" id="yes" name="meter_shifting" value="1" checked >&#160;<label for="yes">Yes</label>&#160;&#160;
							<input type="radio" id="no" name="meter_shifting" value="0"  >&#160;<label for="no">No</label>  
						@else
								<input type="radio" id="yes" name="meter_shifting" value="1" >&#160;<label for="yes">Yes</label>&#160;&#160;
							  <input type="radio" id="no" name="meter_shifting" value="0" checked >&#160;<label for="no">No</label>       
						@endif
													
													
	            		</div>
	                </div>
					<hr>
				
					<div class="panel-heading">Energy Forecast</div>
						<div class="panel-body">
							<table class="table table-bordered bordered table-striped table-condensed datatable">
								<thead>
									<tr> 
										<th class="text-center" style="font-weight:normal;">Month</th>
										<th class="text-center" style="font-weight:normal;">Energy Consumption (kWh)</th>
									</tr>				
								</thead>
								
									@foreach($forecast as $forecastrecord)	
										<tr>                                   
											<th class="text-left" style="font-weight:normal;">{{$forecastrecord->month}}</th>
												<input type="hidden" class="form-control @if($errors->has('energy_consumption_date')) error @endif" name="energy_consumption_date[]" id="energy_consumption_date"  value="{{$forecastrecord->forecast_id}}">
											
											<th class="text-left" width="10%" style="font-weight:normal;">
												<input type="text" class="form-control @if($errors->has('energy_consumption')) error @endif" name="energy_consumption[]" id="energy_consumption"  placeholder="Energy Consumption " value="{{$forecastrecord->forecast}}">
											</th>
										</tr>	
									@endforeach
									<tr>                                   
											<th class="text-left" style="font-weight:normal;">Forecast Energy Production Per Month</th>
											<th class="text-left" width="10%" style="font-weight:normal;">
												<input type="text" class="form-control @if($errors->has('forecast_energy_consumption')) error @endif" name="forecast_energy_consumption" id="forecast_energy_consumption"  placeholder="Forecast Energy Production Per Month" value="{{Input::old('forecast_energy_consumption')}}">
											</th>
									</tr>
								
								
							</table>
						</div>
					
					<hr>
					<?php
					$check = array(); 					
						foreach($quotationItemList as $itemselected){	
							$check[$itemselected->item_or_service_id] = $itemselected->quantity;
						}
					?>
					<div class="panel-heading">Product</div>
						<div class="panel-body">
							<table class="table table-bordered bordered table-striped table-condensed datatable">
								<thead>
									<tr>         
										<th class="text-center" style="font-weight:normal;" hidden></th>
										<th class="text-center" style="font-weight:normal;">Type</th>
										<th class="text-center" style="font-weight:normal;">Brand</th>   
										<th class="text-center" style="font-weight:normal;">Brand Logo</th>   
										<th class="text-center" width="10%" style="font-weight:normal;">Quantity/ Component </th>
									</tr>				
								</thead>
									
									@foreach($entekProduct as $item)	
										<tr> 
 						
											<th class="text-center" style="font-weight:normal;" hidden><input type="checkbox" id="product" name="product[]" value="{{ $item->product_list_id }}" <?php if (isset($check[$item->product_list_id ])) { echo 'checked';}?>	></th>
											<th class="text-left" style="font-weight:normal;">{{ $item->type_name }}</th>
											<th class="text-left" style="font-weight:normal;">{{ $item->product_name }}</th>   
											<th class="text-center" style="font-weight:normal;"><img src="../../products/{{ $item->product_image }}" height="20"></th>   
											<th class="text-left" width="10%" style="font-weight:normal;"><input type="text" class="form-control @if($errors->has('Quantity')) error @endif" name="Quantity[]" id="Quantity"  placeholder="Quantity" value="{{$check[$item->product_list_id ]}}">
										</th>
										</tr>	
									@endforeach
								
								
							</table>
						</div>
					<hr>
					
					<?php
						$checkServise = array(); 					
						foreach($quotationServiseList as $ServiseSelected){	
							if($ServiseSelected->included_excluded ==1){
								$checkServise[$ServiseSelected->item_or_service_id] = $ServiseSelected->cost;
							}
						}
					?>
					
					@foreach($entekServiceType as $servicetype)	
					<div class="panel-heading">{{ $servicetype->service_type_name }}</div>
					<div class="panel-body">
							<table class="table table-bordered bordered table-striped table-condensed datatable">
								<thead>
									<tr>         
										<th class="text-center" style="font-weight:normal;"></th>
										<th class="text-center" style="font-weight:normal;"></th>
										<th class="text-center" style="font-weight:normal;"></th>
										<th class="text-center" width="10%" style="font-weight:normal;">Cost</th>
									</tr>				
								</thead>
									@foreach($entekService as $service)	
										@if($service->service_type_id == $servicetype->service_type_id)     
											<tr>
										
												<th class="text-left" style="font-weight:normal;">{{ $service->service }}</th>
												<th class="text-left" style="font-weight:normal;">		
													<input type="hidden" class="form-control @if($errors->has('service_id')) error @endif" name="service_id[]" id="service_id"  value="{{ $service->service_id }}">
											
													<input type="radio" id="yes{{ $service->service_id }}" name="{{ $service->service_id }}" value="1" <?php if (isset($checkServise[$service->service_id ])) { echo 'checked';}?>>&#160;<label for="yes{{ $service->service_id }}">Included</label>
												</th>
												<th class="text-left" style="font-weight:normal;">
													<input type="radio" id="no{{ $service->service_id }}" name="{{ $service->service_id }}" value="0" <?php if (!isset($checkServise[$service->service_id ])) { echo 'checked';}?>>&#160;<label for="no{{ $service->service_id }}">Excluded</label>		
												</th>
												<th class="text-left" width="10%" style="font-weight:normal;"><input type="text" class="form-control @if($errors->has('cost')) error @endif" name="cost[]" id="cost"  placeholder="Cost" value="<?php if (isset($checkServise[$service->service_id ])) { echo $checkServise[$service->service_id ];}?>">
												</th>
											</tr>
										@endif	
									@endforeach
								
								
							</table>
						</div>
						<hr>
					@endforeach	
            	</form>
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>

<script type="text/javascript">
        $('#add').click(function(e){          
            
            var invoice_code =document.getElementById("invoice_code").value;                            
            if(invoice_code ==''){
                sweetAlert(' Error','Please invoice code.',3);
                return false;
            } 
            var name =document.getElementById("name").value;                            
            if(name ==''){
                sweetAlert(' Error','Please enter name.',3);
                return false;
            } 
            
            var telephone_numbers =document.getElementById("telephone").value;                            
            if(telephone_numbers !=''){                           
                if(!(telephone_numbers.length == 10)){   
                    sweetAlert(' Error','Please enter valid telephone numbers',3);
                    return false;                   
                }
            }
            var fax_numbers =document.getElementById("fax").value;                            
            if(fax_numbers !=''){           
                if(!(fax_numbers.length == 10)){   
                    sweetAlert(' Error','Please enter valid fax numbers',3);
                    return false;                   
                }
            }
            var email =document.getElementById("email").value;                            
            if(email !=''){                      
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test(email) == false) 
                {                    
                    sweetAlert(' Error','Please enter valid email.',3);
                    return false;
                }  
            }     
            var start_date =document.getElementById("start_date").value;                            
            if(start_date ==''){
                sweetAlert(' Error','Please enter customer since.',3);
                return false;
            } 
            
            
            
        });
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();
		$('#permissions').multiSelect();
                $( "#start_date" ).datepicker({
                  format: "yyyy-mm-dd", 
                }); 
	});
</script>
@stop
