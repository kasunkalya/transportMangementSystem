@extends('layouts.sammy_new.master') @section('title','View Transport')
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
    	<a href="{{{url('transportManagement/list')}}}">Transport Request</a>
  	</li>
  	<li class="active">View Transport Request</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>View Transport Request</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}      
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Trip No</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control @if($errors->has('vat')) error @endif" readonly  value="{{$transportRequest->invoice_no}}">
                                                       
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label required">Request Date</label>
                                                <div class="col-sm-10">
                                                    <input type="text"  id="invoicedate" class="form-control @if($errors->has('invoicedate')) error @endif" name="invoicedate" placeholder="Invoice Date" required readonly value="{{$transportRequest->invoice_date}}">
                                                        @if($errors->has('invoicedate'))
                                                                <label id="label-error" class="error" for="invoicedate">{{$errors->first('invoicedate')}}</label>
                                                        @endif      
                                                </div>
                                        </div>
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Company</label>
						<div class="col-sm-10">
							@if($errors->has('company'))
								{!! Form::select('company',$company, $transportRequest->companyid,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'company','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="company">{{$errors->first('company')}}</label>
							@else
								{!! Form::select('company',$company,$transportRequest->companyid,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'company','disabled' => true]) !!}
							@endif
							
						</div>
					</div>
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Customer</label>
						<div class="col-sm-10">
							@if($errors->has('customer'))
								{!! Form::select('customer',$customer,$transportRequest->customer_id,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'customer','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="customer">{{$errors->first('customer')}}</label>
							@else
								{!! Form::select('customer',$customer,$transportRequest->customer_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'customer','disabled' => true]) !!}
							@endif
							
						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Contact Person</label>
						<div class="col-sm-10">						
                                                    <select disabled class="form-control" name="contactPerson" id="contactPerson" required>
                                                        <option>Select Contact Person</option>
                                                    </select>                                                   
						</div>
                                              
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Lorry</label>
						<div class="col-sm-10">
							@if($errors->has('lorry'))
								{!! Form::select('lorry',$lorry,$transportRequest->lorry_id,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
							@else
								{!! Form::select('lorry',$lorry,$transportRequest->lorry_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry','disabled' => true]) !!}
							@endif
							
						</div>
					</div>                        
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Route</label>
						<div class="col-sm-10">
							@if($errors->has('route'))
								{!! Form::select('route',$route,$transportRequest->route_id,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'route','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="route">{{$errors->first('route')}}</label>
							@else
								{!! Form::select('route',$route,$transportRequest->route_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'route','disabled' => true]) !!}
							@endif
							
						</div>
					</div>
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Charging Type</label>
						<div class="col-sm-10">
							@if($errors->has('chargingType'))
								{!! Form::select('chargingType',$transportChargin,$transportRequest->charging_type_id,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'chargingType','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="chargingType">{{$errors->first('chargingType')}}</label>
							@else
								{!! Form::select('chargingType',$transportChargin,$transportRequest->charging_type_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'chargingType','disabled' => true]) !!}
							@endif
							
						</div>
					</div>
                        
                        <span id="responce"></span>
                        
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label">Sub category</label>
						<div class="col-sm-10">						
                                                    <select class="form-control" name="category" id="category" disabled="">
                                                        <option value="0">Select sub category</option>
                                                    </select>                                                   
						</div>
                                              
					</div>
                        
                                        <div class="form-group">
                                                    <label class="col-sm-2 control-label required">Work Order Number </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly id="workNumber" class="form-control @if($errors->has('workNumber')) error @endif" name="workNumber" placeholder="Work Order Number" required value="{{$transportRequest->workOderNo}}">
                                                            @if($errors->has('workNumber'))
                                                                    <label id="label-error" class="error" for="workNumber">{{$errors->first('workNumber')}}</label>
                                                            @endif      
                                                    </div>
                                        </div>
                                                           
                        
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Reference Invoice Number(s)</label>
                                                <div class="col-sm-10">
                                                     <textarea readonly class="form-control @if($errors->has('refInvoiceNumber')) error @endif" name="refInvoiceNumber" placeholder="Reference Invoice Number(s)">{{$transportRequest->invoice_numbers}}</textarea>
                                                        @if($errors->has('refInvoiceNumber'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('refInvoiceNumber')}}</label>
                                                        @endif    
                                                        <label id="label-default" class="error" for="code">i.e - Customer invoice numbers (if any)</label>
                                                </div>
                                        </div>
                        
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label required">Gate Passes</label>
                                                <div class="col-sm-10">
                                                    <textarea readonly class="form-control @if($errors->has('gatePass')) error @endif" name="gatePass" id="gatePass" placeholder="Gate Passes">{{$transportRequest->gate_passes}}</textarea>
                                                        @if($errors->has('gatePass'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('gatePass')}}</label>
                                                        @endif    
                                                        
                                                </div>
                                        </div>
					
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label required">Start Date</label>
                                                <div class="col-sm-10">
                                                    <input readonly type="text" id="startDate" class="form-control @if($errors->has('startDate')) error @endif" name="startDate" placeholder="Start Date" required value="{{$transportRequest->start_date}}">
                                                        @if($errors->has('startDate'))
                                                                <label id="label-error" class="error" for="startDate">{{$errors->first('startDate')}}</label>
                                                        @endif      
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label required">Start Time</label>
                                                <div class="col-sm-10">
                                                    <input readonly type="text" id="startTime" class="form-control @if($errors->has('startTime')) error @endif" name="startTime" placeholder="Start Time" required value="{{$transportRequest->start_time}}">
                                                        @if($errors->has('startTime'))
                                                                <label id="label-error" class="error" for="startTime">{{$errors->first('startTime')}}</label>
                                                        @endif      
                                                </div>
                                        </div>      
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label required">End Date</label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control @if($errors->has('endDate')) error @endif" name="endDate" id="endDate" placeholder="End Date" required value="{{$transportRequest->end_date}}">
                                                        @if($errors->has('endDate'))
                                                                <label id="label-error" class="error" for="endDate">{{$errors->first('endDate')}}</label>
                                                        @endif      
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label required">End Time</label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control @if($errors->has('endTime')) error @endif" name="endTime" id="endTime" placeholder="End Time" required value="{{$transportRequest->end_time}}">
                                                        @if($errors->has('endTime'))
                                                                <label id="label-error" class="error" for="endTime">{{$errors->first('endTime')}}</label>
                                                        @endif      
                                                </div>
                                        </div>
                        
                        
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">VAT%</label>
                                                <div class="col-sm-10">
                                                        <input type="number" readonly class="form-control @if($errors->has('vat')) error @endif" name="vat" placeholder="vat %" value="{{$transportRequest->vat_percent}}">
                                                        @if($errors->has('vat'))
                                                                <label id="label-error" class="error" for="vat">{{$errors->first('vat')}}</label>
                                                        @endif      
                                                </div>
                                        </div>
                        
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Discount%</label>
                                                <div class="col-sm-10">
                                                    <input type="number" readonly class="form-control @if($errors->has('discount')) error @endif" name="discount" id="discount" placeholder="Discount" value="{{$transportRequest->dis_percent}}">
                                                        @if($errors->has('discount'))
                                                                <label id="label-error" class="error" for="discount">{{$errors->first('discount')}}</label>
                                                        @endif      
                                                </div>
                                        </div>
                        
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Qty</label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly class="form-control @if($errors->has('qty')) error @endif" name="qty" id="qty" placeholder="Qty" value="{{$transportRequest->qty}}">
                                                        @if($errors->has('qty'))
                                                                <label id="label-error" class="error" for="qty">{{$errors->first('qty')}}</label>
                                                        @endif    
                                                        <label id="label-error" class="error" >i.e - Total Km / Cubic Meters / Total Weight in Kg (1.54) / Enter 1 if you don't want to multiply by the above rate.</label>   
                                                </div>
                                        </div>
                        
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Chargers</label>
                                                <div class="col-sm-10">
                                                    <label class="control-label" id="chargersLable">{{$transportRequest->paymentAmount}}</label>
                                                    <input readonly type="hidden" class="form-control @if($errors->has('chargers')) error @endif" name="chargers" placeholder="Chargers" id="chargers" value="0">
                                                                        @if($errors->has('chargers'))
                                                                                <label id="label-error" class="error" for="chargers">{{$errors->first('chargers')}}</label>
                                                                        @endif
                                                </div>
                                        </div>

                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Discount Amount</label>
                                                <div class="col-sm-10"> 
                                                    <label class="control-label" id="discountAmountLable">{{$transportRequest->paymentDiscount}}</label>
                                                    <input type="hidden" class="form-control @if($errors->has('discountAmount')) error @endif" name="discountAmount" placeholder="Discount Amount" id="discountAmount" value="0">
                                                                        @if($errors->has('discountAmount'))
                                                                                <label id="label-error" class="error" for="c_name">{{$errors->first('discountAmount')}}</label>
                                                                        @endif
                                                </div>
                                        </div>
                        
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Driver Rate</label>
                                                <div class="col-sm-10">
                                                    <label class="control-label" id="driverRate">0</label>
                                                    <input type="hidden" class="form-control @if($errors->has('dRate')) error @endif" name="dRate" placeholder="dRate" id="dRate" value="0">
                                                                        @if($errors->has('dRate'))
                                                                                <label id="label-error" class="error" for="dRate">{{$errors->first('dRate')}}</label>
                                                                        @endif
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Helper Rate</label>
                                                <div class="col-sm-10">
                                                    <label class="control-label" id="helperRate">0</label>
                                                    <input type="hidden" class="form-control @if($errors->has('hRate')) error @endif" name="hRate" placeholder="hRate" id="hRate" value="0">
                                                                        @if($errors->has('hRate'))
                                                                                <label id="label-error" class="error" for="hRate">{{$errors->first('hRate')}}</label>
                                                                        @endif
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Remarks (On Loading)</label>
                                                <div class="col-sm-10">
                                                     <textarea class="form-control @if($errors->has('onLoading')) error @endif" name="onLoading" placeholder="Remarks (On Loading)">{{$transportRequest->load_remarks}}</textarea>
                                                        @if($errors->has('onLoading'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('onLoading')}}</label>
                                                        @endif    
                                                        
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Remarks (On Unloading)</label>
                                                <div class="col-sm-10">
                                                     <textarea readonly class="form-control @if($errors->has('onUnloading')) error @endif" name="onUnloading" placeholder="Remarks (On Unloading)">{{$transportRequest->unload_remarks}}</textarea>
                                                        @if($errors->has('onUnloading'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('onUnloading')}}</label>
                                                        @endif    
                                                        
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Special Notes</label>
                                                <div class="col-sm-10">
                                                     <textarea readonly class="form-control @if($errors->has('specialNotes')) error @endif" name="specialNotes" placeholder="Special Notes">{{$transportRequest->notes}}</textarea>
                                                        @if($errors->has('specialNotes'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('specialNotes')}}</label>
                                                        @endif    
                                                        
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Description</label>
                                                <div class="col-sm-10">
                                                     <textarea readonly class="form-control @if($errors->has('description')) error @endif" name="description" placeholder="Description">{{$transportRequest->description}}</textarea>
                                                        @if($errors->has('description'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('description')}}</label>
                                                        @endif    
                                                        
                                                </div>
                                        </div>
	               
            	</form>
          	</div>
        </div>
	</div>
</div>
@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script>
document.getElementById("qty").onchange = function() {getChargers()};
document.getElementById("discount").onchange = function() {getChargers()};
document.getElementById("lorry").onchange = function() {getChargers()};
document.getElementById("route").onchange = function() {getChargers();getRouting();};
document.getElementById("chargingType").onchange = function() {getChargers()};
document.getElementById("category").onchange = function() {getChargers()};

function getChargers() {  
        var qty =document.getElementById("qty").value; 
        var discount =document.getElementById("discount").value; 
        var lorry = document.getElementById("lorry");
        var lorryValue = lorry.options[lorry.selectedIndex].value;
        var route = document.getElementById("route");
        var routeValue = route.options[route.selectedIndex].value;
        var chargingType = document.getElementById("chargingType");
        var chargingTypeValue = chargingType.options[chargingType.selectedIndex].value;
        var subCategory = document.getElementById("category");
        var subCategoryValue = subCategory.options[subCategory.selectedIndex].value;
        
        document.getElementById("chargers").value =0;
        document.getElementById("discountAmount").value =0;
         jQuery.ajax({
                     url : '../json/getChargingRules/' +lorryValue+'/'+routeValue+'/'+chargingTypeValue+'/'+subCategoryValue,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {    
                        var chargers=res[0]['charges'] * qty;
                        if(discount !=0){
                            var discountAmount=(chargers * discount)/100;
                        }else{
                            var discountAmount=0;
                        }
                        
                        document.getElementById("chargers").value =chargers;
                        document.getElementById("chargersLable").innerHTML  =chargers;
                        document.getElementById("discountAmount").value =discountAmount;
                        document.getElementById("discountAmountLable").innerHTML  =discountAmount;                    
                     }
                  });
   
  
}


function getRouting() {  
       
        var route = document.getElementById("route");
        var routeValue = route.options[route.selectedIndex].value;
      
         jQuery.ajax({
                     url : '../json/getRutingRules/'+routeValue,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {  
                       
                        document.getElementById("dRate").value =res['driver_rate'];
                        document.getElementById("driverRate").innerHTML  =res['driver_rate'];
                        document.getElementById("hRate").value =res['helper_rate'];
                        document.getElementById("helperRate").innerHTML  =res['helper_rate'];
                        
                     }
                  });
   
  
}
</script>
<script type="text/javascript">
  document.getElementById("customer").onchange = function() {getContacts()};
  function getContacts() {
                var customer = document.getElementById("customer");
                var customer = customer.options[customer.selectedIndex].value;
               if(customer)
               {
                  jQuery.ajax({
                     url : '../json/customer/' +customer,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {
                        $('#contactPerson').empty();
                            $("#contactPerson").append('<option value="0">Select Contact Person</option>');
                            if(res)
                            {
                                $.each(res,function(key,value){   
                                    
                                     if(value == <?php echo $transportRequest->contactperson; ?>){
                                        $('#contactPerson').append($("<option/>", {
                                           value: value,
                                           text: key,
                                           selected:'true',
                                        }));
                                    }else{
                                        $('#contactPerson').append($("<option />", {
                                           value: value,
                                           text: key
                                        }));
                                    }
                                  
                                });
                            }   
                     }
                  });
               }
               else
               {
                 $('#contactPerson').empty();
               }
            };            
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();
		$('#permissions').multiSelect();
                getContacts();
                getChargers();
                getRouting();
                getSubCategory();
                
                var date = new Date();
                date.setDate(date.getDate());
                
                var invoicedate =document.getElementById("invoicedate").value;    
               
                
                $( "#startDate" ).datepicker({
                    format: "yyyy-mm-dd", 
                    startDate: date,
                }); 
                
                
                $('#startTime').timepicker({
                   template: false,
                    showInputs: false,
                    minuteStep: 5
                });
                
                  $( "#endDate" ).datepicker({
                    format: "yyyy-mm-dd", 
                    startDate: date,
                }); 
                
                
                $('#endTime').timepicker({
                   template: false,
                    showInputs: false,
                    minuteStep: 5
                });
                
                var lorry = document.getElementById("lorry");
                var lorryValue = lorry.options[lorry.selectedIndex].value;
                var route = document.getElementById("route");
                var routeValue = route.options[route.selectedIndex].value;
                $('#div1').empty();
               if(lorryValue !=0 && routeValue !=0)
               {
                  
                             
                  jQuery.ajax({
                     url : '../../transportLogSheet/json/logsheetlist/'+lorryValue+'/'+routeValue,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {
                            //$('#category').empty();
                            //$("#category").append('<option value="0">Select sub category</option>');
                          
                            document.getElementById('responce').innerHTML = ""; 
                            if(res)
                            {
                                var isAdded= 0;
                                document.getElementById('responce').innerHTML+='<div style="margin-left: 120px  !important;" class="form-group">Log Sheets</div>';
                                $.each(res,function(key,value){   
                                        var str = "'"+value+"'";
                                        var chars = str.split(',');                                                                  
                                         jQuery.ajax({
                                            url : '../json/logsheetyransportlist/'+chars[3]+'/'+<?php echo $transportRequest->id ?>,
                                            type : "GET",                                            
                                            success:function(rest)
                                            {
                                                var isAdded= rest; 
                                                  if(chars[3] >=0){
                                                    // var boxName="textBox"+countBox;     
                                                        if(isAdded !=0){                                                       
                                                            document.getElementById('responce').innerHTML+='<div style="margin-left: 120px  !important;" class="form-group"><div class="col-sm-2"><input  class="form-control" type="checkbox" id="logsheet" name="logsheet[]" value="'+chars[3]+'" checked readonly></div><label style="text-align: left !important" class="col-sm-6 control-label">'+chars[1]+'-'+chars[2]+'  ('+chars[4]+')</label></div>';
                                                        }    
                                                        countBox += 1;
                                                    }
                                                
                                            }
                                         });    
                                         
                                         
                                    
                                        
                                        
                                        
                                
                                });
                            }
                            
                           
                        
                     }
                  });
               }
               else
               {
                 $('#div1').empty();
               }
                
                
                
                
	});
</script>

<script type="text/javascript">
    document.getElementById("chargingType").onchange = function() {getSubCategory()};
     function getSubCategory() {
            var makerID = document.getElementById("chargingType");
            var makerID = makerID.options[makerID.selectedIndex].value;
    
               if(makerID)
               {
                  jQuery.ajax({
                     url : '../../transportLorryChargers/json/categorylist/' +makerID,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {
                            $('#category').empty();
                            $("#category").append('<option value="0">Select sub category</option>');
                            if(res)
                            {
                                $.each(res,function(key,value){                                    
                                    if(value == <?php echo $transportRequest->charging_sub_type_id; ?>){
                                        $('#category').append($("<option/>", {
                                           value: value,
                                           text: key,
                                           selected:'true',
                                        }));
                                    }else{
                                        $('#category').append($("<option />", {
                                           value: value,
                                           text: key
                                        }));
                                    }
                                });
                                
                               
                                
                                
                            }
                        
                     }
                  });
               }
               else
               {
                 $('#category').empty();
               }
     }
    
    
    </script>
@stop
