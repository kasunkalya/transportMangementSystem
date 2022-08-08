@extends('layouts.sammy_new.master') @section('title','Add Log Sheet')
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
    	<a href="{{{url('transportLogSheet/list')}}}">Log Sheet List </a>
  	</li>
  	<li class="active">Add Log Sheet</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Log Sheet</strong>
      		</div>
                 
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
                                    <div class="form-group" hidden>
                                        <label class="col-sm-2 control-label">Log Sheet Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @if($errors->has('sheetNumber')) error @endif" name="sheetNumber" id="sheetNumber" placeholder="Log Sheet Number" value="{{Input::old('sheetNumber')}}">
                                                    @if($errors->has('sheetNumber'))
                                                        <label id="label-error" class="error" for="sheetNumber">{{$errors->first('sheetNumber')}}</label>
                                                    @endif                           
                                            </div>
                                    </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label required">Date</label>
                                            <div class="col-sm-10">                                                												
                                                    <input type="text" class="form-control @if($errors->has('date')) error @endif" name="date" id="date" placeholder="Date" value="" >
                                                        @if($errors->has('date'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('date')}}</label>
                                                        @endif														

                                            </div>
                                        </div>          
					<div class="form-group">
						<label class="col-sm-2 control-label required">Lorry</label>
						<div class="col-sm-10">
							@if($errors->has('lorry'))
								{!! Form::select('lorry', $lorry, Input::old('lorry'),['placeholder' => 'Select Lorry','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry']) !!}
								<label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
							@else
								{!! Form::select('lorry', $lorry, Input::old('lorry'),['placeholder' => 'Select Lorry','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry']) !!}
							@endif

						</div>
					</div>
                    
                   <div class="form-group">
			<label class="col-sm-2 control-label required">Driver</label>
                            <div class="col-sm-10">
							@if($errors->has('driver'))
								{!! Form::select('driver', $driver, Input::old('driver'),['placeholder' => 'Select driver','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'driver']) !!}
								<label id="supervisor-error" class="error" for="driver">{{$errors->first('driver')}}</label>
							@else
								{!! Form::select('driver', $driver, Input::old('driver'),['placeholder' => 'Select driver','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'driver']) !!}
							@endif

                            </div>
                    </div>    
                        
                    <div class="form-group">
			<label class="col-sm-2 control-label required">Helper</label>
                            <div class="col-sm-10">
							@if($errors->has('helper'))
								{!! Form::select('helper', $driver, Input::old('helper'),['placeholder' => 'Select helper','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'helper']) !!}
								<label id="supervisor-error" class="error" for="helper">{{$errors->first('helper')}}</label>
							@else
								{!! Form::select('helper', $driver, Input::old('helper'),['placeholder' => 'Select helper','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'helper']) !!}
							@endif

                            </div>
                    </div>   
                    <div class="form-group">
                    <label class="col-sm-2 control-label">Invoice Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @if($errors->has('invoice')) error @endif" name="invoice" id="invoice" placeholder="Invoice Number" value="{{Input::old('invoice')}}">
                                @if($errors->has('invoice'))
                                    <label id="label-error" class="error" for="invoice">{{$errors->first('invoice')}}</label>
                                @endif                           
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Start Time</label>
                            <div class="col-sm-10">
                                 <input type="text" id="startTime" class="form-control @if($errors->has('startTime')) error @endif" name="startTime" placeholder="Start Time" value="{{Input::old('startTime')}}">
                                       @if($errors->has('startTime'))
                                            <label id="label-error" class="error" for="startTime">{{$errors->first('startTime')}}</label>
                                        @endif      
                            </div>
                     </div>
                        
                    <div class="form-group">
                        <label class="col-sm-2 control-label">End Time</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @if($errors->has('endDate')) error @endif" name="endDate" id="endDate" placeholder="End Date" value="{{Input::old('endDate')}}">
                                    @if($errors->has('endDate'))
                                        <label id="label-error" class="error" for="endDate">{{$errors->first('endDate')}}</label>
                                    @endif      
                        </div>
                    </div>    
                    <div class="form-group">
                    <label class="col-sm-2 control-label">Start Vehicle Meter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @if($errors->has('startVehicleMeter')) error @endif" name="startVehicleMeter" id="startVehicleMeter" placeholder="Start Vehicle Meter" value="{{Input::old('startVehicleMeter')}}">
                                @if($errors->has('startVehicleMeter'))
                                    <label id="label-error" class="error" for="startVehicleMeter">{{$errors->first('startVehicleMeter')}}</label>
                                @endif
                            <label id="label-error" class="error" for="">In kilometer (km).</label>
                        </div>
                    </div>
                        
                     <div class="form-group">
                    <label class="col-sm-2 control-label">End Vehicle Meter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @if($errors->has('endVehicleMeter')) error @endif" name="endVehicleMeter" id="endVehicleMeter" placeholder="End Vehicle Meter" value="{{Input::old('endVehicleMeter')}}">
                                @if($errors->has('endVehicleMeter'))
                                    <label id="label-error" class="error" for="endVehicleMeter">{{$errors->first('endVehicleMeter')}}</label>
                                @endif
                            <label id="label-error" class="error" for="">In kilometer (km).</label>
                        </div>
                    </div>    
                        
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Trip Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @if($errors->has('tripdescription')) error @endif" name="tripdescription" placeholder="Trip Description">{{Input::old('tripdescription')}}</textarea>
                                                        @if($errors->has('tripdescription'))
                                    <label id="label-error" class="error" for="label">{{$errors->first('tripdescription')}}</label>
                                                        @endif    
                                                        
                        </div>
                    </div>
                        
                     <div class="form-group">
                        <label class="col-sm-2 control-label">Other Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control @if($errors->has('otherdescription')) error @endif" name="otherdescription" placeholder="Other Description">{{Input::old('otherdescription')}}</textarea>
                                                        @if($errors->has('otherdescription'))
                                    <label id="label-error" class="error" for="label">{{$errors->first('otherdescription')}}</label>
                                                        @endif    
                                                        
                        </div>
                    </div>    
                        
                    <div class="form-group">
	            		<label class="col-sm-2 control-label">Route</label>
	            		
	            		<div class="col-sm-10">
	            			@if($errors->has('route[]'))
	            				{!! Form::select('route[]',$route, null,['class'=>'error', 'multiple','id'=>'route','style'=>'width:100%;height: 200px;','required']) !!}
	            				<label id="label-error" class="error" for="label">{{$errors->first('route[]')}}</label>
	            			@else
	            				{!! Form::select('route[]',$route, Input::old('route[]'),['multiple','id'=>'route','style'=>'width:100%;height: 200px;','required']) !!}
	            			@endif
	            		</div>
	            </div>   
                        
                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Cost Description</label>
                                                <div class="col-sm-10">
                                                     <textarea class="form-control @if($errors->has('costdescription')) error @endif" name="costdescription" placeholder="Cost Description">{{Input::old('costdescription')}}</textarea>
                                                        @if($errors->has('costdescription'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('costdescription')}}</label>
                                                        @endif    
                                                        
                                                </div>
                       </div>
                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Total Cost</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('chargers')) error @endif" name="chargers" id="chargers" placeholder="Total Cost" value="{{Input::old('chargers')}}">
                                                    @if($errors->has('chargers'))
                                                        <label id="label-error" class="error" for="chargers">{{$errors->first('chargers')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In Rupee (Rs).</label>
                                        </div>
                    </div>
			
                  <div class="form-group">
						<label class="col-sm-2 control-label required">Payment Type</label>
						<div class="col-sm-10">
							@if($errors->has('payable'))
								{!! Form::select('payable', array(null=>'Select Value','1' => 'Payable', '0' => 'None payable'), Input::old('payable'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'payable']) !!}
								<label id="supervisor-error" class="error" for="ownerSection">{{$errors->first('ownerSection')}}</label>
							@else
								{!! Form::select('payable', array(null=>'Select Value','1' => 'Payable', '0' => 'None payable'), Input::old('payable'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'payable']) !!}
							@endif

						</div>
		</div>
                       
	                <div class="pull-right">
                            <button type="submit" class="btn btn-primary" id="add"><i class="fa fa-floppy-o"></i> Save</button>
	                </div>
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
            var y = document.getElementById("lorry");		
            var y = document.getElementById("lorry");
            var re = y.options[y.selectedIndex].value;
            
//            var sheetNumber =document.getElementById("sheetNumber").value; 	
//            if(sheetNumber ==''){
//                sweetAlert(' Error','Please enter log sheet number.',3);
//                return false;
//            }  
	
        
            var date =document.getElementById("date").value; 	
            if(date ==''){
                sweetAlert(' Error','Please enter log sheet date.',3);
                return false;
            } 
        
        
            if(re ==0){
                sweetAlert(' Error','Please select lorry.',3);
                return false;
            }   
            
             
            var d = document.getElementById("driver");
            var dre = d.options[d.selectedIndex].value;
	
            if(dre ==0){
                sweetAlert(' Error','Please select driver.',3);
                return false;
            }   
            
            var h = document.getElementById("helper");
            var hre = h.options[h.selectedIndex].value;
	
            if(dre ==0){
                sweetAlert(' Error','Please select helper.',3);
                return false;
            }   
            
            
            //var invoice =document.getElementById("invoice").value; 	
            //if(invoice ==''){
               // sweetAlert(' Error','Please enter invoice number.',3);
               // return false;
            //}  
            
            
           
            
            
//            var startVehicleMeter =document.getElementById("startVehicleMeter").value; 	
//            if(startVehicleMeter ==''){
//                sweetAlert(' Error','Please enter start vehicle meter.',3);
//                return false;
//            } 
//           
//            var endVehicleMeter =document.getElementById("endVehicleMeter").value; 	
//            if(endVehicleMeter ==''){
//                sweetAlert(' Error','Please enter end vehicle meter.',3);
//                return false;
//            }   
            
            var route = document.getElementById("route").value;    
            if(route ==''){
                sweetAlert(' Error','Please select route.',3);
                return false;
            } 
            
            
            var t = document.getElementById("payable");
            var tre = t.options[t.selectedIndex].value;
	
            if(tre ==''){
                sweetAlert(' Error','Please select payment type.',3);
                return false;
            }   
            
            
        });
</script>
<script type="text/javascript">
	$(document).ready(function(){
                $("#companydiv").hide();
                $("#ownerdiv").hide();
                $("#companyLorryDiv").hide();
                
		$('.form-validation').validate();
		$('#permissions').multiSelect();
                $( "#nextServicedate" ).datepicker({
                  format: "yyyy-mm-dd", 
                });              
                $( "#date" ).datepicker({
                  format: "yyyy-mm-dd",  
                });
	});
        
</script>



@stop
