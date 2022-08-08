@extends('layouts.sammy_new.master') @section('title','View Fuel Record')
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
    	<a href="{{{url('transportLorryFule/list')}}}">Fuel List </a>
  	</li>
  	<li class="active">View Fuel Record</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>View Fuel Record</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
					<div class="form-group">
						<label class="col-sm-2 control-label required">Lorry</label>
						<div class="col-sm-10">
							@if($errors->has('lorry'))
								{!! Form::select('lorry', $lorry, $maintain->lorry,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
							@else
								{!! Form::select('lorry', $lorry, $maintain->lorry,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry','disabled' => true]) !!}
							@endif

						</div>
					</div>
                       <div class="form-group">
	            		<label class="col-sm-2 control-label required">Fuel Type</label>
	            		<div class="col-sm-10">
                                    @if($errors->has('type'))
					{!! Form::select('type', array(null=>'Select Fuel Type','1' => 'Petrol', '2' => 'Diesel', '3' => 'Oil', '4' => 'Other'), $maintain->fuelType,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'type']) !!}
					<label id="supervisor-error" class="error" for="ownerSection">{{$errors->first('ownerSection')}}</label>
                                    @else
					{!! Form::select('type', array(null=>'Select Type','1' => 'Petrol', '2' => 'Diesel', '3' => 'Oil', '4' => 'Other'),  $maintain->fuelType,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'type']) !!}
                                    @endif						
	            		</div>
	                </div>    
                    <div class="form-group">
                        <label class="col-sm-2 control-label required">Fuel Date</label>
                        <div class="col-sm-10">                                                												
                                <input type="text" class="form-control @if($errors->has('fuledate')) error @endif" name="fuledate" id="fuledate" placeholder="Fule Date" value="{{$maintain->fuleDate}}" >
                                    @if($errors->has('fuledate'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('fuledate')}}</label>
                                    @endif														

                        </div>
                    </div>
                        
                    <div class="form-group">
                    <label class="col-sm-2 control-label required">Invoice Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @if($errors->has('invoice')) error @endif" name="invoice" id="invoice" placeholder="Invoice Number" required value="{{$maintain->invoice_number}}">
                                @if($errors->has('invoice'))
                                    <label id="label-error" class="error" for="invoice">{{$errors->first('invoice')}}</label>
                                @endif                           
                        </div>
                    </div>
                        
                    <div class="form-group">
			<label class="col-sm-2 control-label required">Driver</label>
                            <div class="col-sm-10">
							@if($errors->has('driver'))
								{!! Form::select('driver', $driver,$maintain->driver,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'driver','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="driver">{{$errors->first('driver')}}</label>
							@else
								{!! Form::select('driver', $driver,$maintain->driver,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'driver','disabled' => true]) !!}
							@endif

                            </div>
                    </div>    
                        
                    <div class="form-group">
                    <label class="col-sm-2 control-label required">Vehicle Meter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @if($errors->has('vehicleMeter')) error @endif" name="vehicleMeter" id="vehicleMeter" placeholder="Vehicle Meter" required value="{{$maintain->vehicleMeter}}">
                                @if($errors->has('vehicleMeter'))
                                    <label id="label-error" class="error" for="vehicleMeter">{{$errors->first('vehicleMeter')}}</label>
                                @endif
                            <label id="label-error" class="error" for="">In kilometer (km).</label>
                        </div>
                    </div>
                        
                     <div class="form-group">
			<label class="col-sm-2 control-label required">Shed</label>
			<div class="col-sm-10">     
                                                        @if($errors->has('location'))
								{!! Form::select('locations', $service, $maintain->location,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'location','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="location">{{$errors->first('location')}}</label>
							@else
								{!! Form::select('location', $service, $maintain->location,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'location','disabled' => true]) !!}
							@endif
                      
			</div>
                    </div>  
                    <div class="form-group">
                                        <label class="col-sm-2 control-label required">Chargers</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('chargers')) error @endif" name="chargers" id="chargers" placeholder="Chargers" required value="{{$maintain->amount}}">
                                                    @if($errors->has('chargers'))
                                                        <label id="label-error" class="error" for="chargers">{{$errors->first('chargers')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In Rupee (Rs).</label>
                                        </div>
                    </div>
                        <div class="form-group">
                    <label class="col-sm-2 control-label required">Seal Tag Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @if($errors->has('seal')) error @endif" name="seal" id="seal" placeholder="Seal Tag Number" required value="{{$maintain->sealtag}}">
                                @if($errors->has('seal'))
                                    <label id="label-error" class="error" for="seal">{{$errors->first('seal')}}</label>
                                @endif                           
                        </div>
                    </div>  
                    @if($maintain->bill !='')   
                                            <div class="form-group">      
                                                    <label class="col-sm-2 control-label"></label>
                                                    <div class="col-sm-10">      
                                                        <a class="" href="../../lorryFuleRecords\{{$maintain->lorry }}\{{$maintain->bill }}">
                                                            <img src="../../lorryFuleRecords\{{$maintain->lorry }}\{{$maintain->bill}}" height="400">
                                                        </a>	
                                                    </div>
                                            </div> 
                   @endif			
                    
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
	
            if(re ==0){
                sweetAlert(' Error','Please select lorry.',3);
                return false;
            }   
            
           
            var repairdate =document.getElementById("fuledate").value; 	
            if(repairdate ==''){
                sweetAlert(' Error','Please enter fuel date.',3);
                return false;
            }  
		
            var vehicleMeter =document.getElementById("vehicleMeter").value; 	
            if(vehicleMeter ==''){
                sweetAlert(' Error','Please enter vehicle meter.',3);
                return false;
            }      
            var garage =document.getElementById("location").value;                            
            if(garage ==''){
                sweetAlert(' Error','Please enter location.',3);
                return false;
            }  			
			
            var serviceChargers =document.getElementById("chargers").value;                            
            if(serviceChargers ==''){
                sweetAlert(' Error','Please enter chargers.',3);
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
                $( "#fuledate" ).datepicker({
                  format: "yyyy-mm-dd",  
                });
	});
        
</script>



@stop
