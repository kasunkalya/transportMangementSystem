@extends('layouts.sammy_new.master') @section('title','Add Maintain Record')
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
    	<a href="{{{url('transportLorryMaintain/list')}}}">Lorries Maintain</a>
  	</li>
  	<li class="active">Add Lorry Maintain Record</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Lorry Maintain Record</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
					<div class="form-group">
						<label class="col-sm-2 control-label required">Lorry</label>
						<div class="col-sm-10">
							@if($errors->has('lorry'))
								{!! Form::select('lorry', $lorry, Input::old('lorry'),['placeholder' => 'Select lorry','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry']) !!}
								<label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
							@else
								{!! Form::select('lorry', $lorry, Input::old('lorry'),['placeholder' => 'Select lorry','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry']) !!}
							@endif

						</div>
					</div>
					<div class="form-group">
                                            <label class="col-sm-2 control-label required">Service Date</label>
                                            <div class="col-sm-10">                                                												
                                                    <input type="text" class="form-control @if($errors->has('servicedate')) error @endif" name="servicedate" id="servicedate" placeholder="Service Date" value="" >
                                                        @if($errors->has('servicedate'))
                                                            <label id="label-error" class="error" for="label">{{$errors->first('servicedate')}}</label>
                                                        @endif														

                                            </div>
                                        </div>
					<div class="form-group">
						<label class="col-sm-2 control-label required">Service Station</label>
						<div class="col-sm-10">
                                                    
                                                    
                            @if($errors->has('serviceStation'))
								{!! Form::select('serviceStation', $service, Input::old('serviceStation'),['placeholder' => 'Select service station','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'serviceStation']) !!}
								<label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
							@else
								{!! Form::select('serviceStation', $service, Input::old('serviceStation'),['placeholder' => 'Select service station','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'serviceStation']) !!}
							@endif
                      
						</div>
					</div>
					
					<div class="form-group">
                                        <label class="col-sm-2 control-label required">Vehicle Meter</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('vehicleMeter')) error @endif" name="vehicleMeter" id="vehicleMeter" placeholder="Vehicle Meter" required value="{{Input::old('vehicleMeter')}}">
                                                    @if($errors->has('vehicleMeter'))
                                                        <label id="label-error" class="error" for="vehicleMeter">{{$errors->first('vehicleMeter')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In kilometer (km).</label>
                                        </div>
                    </div>
					<div class="form-group">
                                        <label class="col-sm-2 control-label required">Service Chargers</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('serviceChargers')) error @endif" name="serviceChargers" id="serviceChargers" placeholder="Service Chargers" required value="{{Input::old('serviceChargers')}}">
                                                    @if($errors->has('serviceChargers'))
                                                        <label id="label-error" class="error" for="serviceChargers">{{$errors->first('serviceChargers')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In Rupee (Rs).</label>
                                        </div>
                    </div>
					<div class="form-group">
                                        <label class="col-sm-2 control-label required">Service Discription</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control @if($errors->has('discription')) error @endif" name="discription" id="discription" required >{{Input::old('serviceChargers')}}</textarea>
                                                    @if($errors->has('discription'))
                                                        <label id="label-error" class="error" for="discription">{{$errors->first('discription')}}</label>
                                                    @endif
                                                    
                                        </div>
                    </div>
					
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Service Document</label>
                        <div class="col-sm-10">                                                												
                            <input type="file" class="form-control @if($errors->has('document')) error @endif" name="document" placeholder="Document" >
							@if($errors->has('document'))
                                <label id="label-error" class="error" for="label">{{$errors->first(document)}}</label>
							@endif														
							<label id="label-error" class="error" for="label">Upload scanned document. Allowed image formats (.jpg, .jpeg, .png., .gif)</label>
                        </div>
                    </div>
                        
                    <div class="form-group">
                            <label class="col-sm-2 control-label required">Next Service milage</label>
                            <div class="col-sm-10">                                                												
                                <input type="text" readonly class="form-control @if($errors->has('nextServiceMilage')) error @endif" name="nextServiceMilage" id="nextServiceMilage" placeholder="Next Service Milage" value="" >
                                        @if($errors->has('nextServiceMilage'))
                                            <label id="label-error" class="error" for="label">{{$errors->first('nextServiceMilage')}}</label>
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
	
            if(re ==0){
                sweetAlert(' Error','Please select lorry.',3);
                return false;
            }   
            
           
            var servicedate =document.getElementById("servicedate").value; 	
            if(servicedate ==''){
                sweetAlert(' Error','Please enter service date.',3);
                return false;
            }  
            
            var s = document.getElementById("serviceStation");
            var se = s.options[s.selectedIndex].value;
	
            if(se ==0){
                sweetAlert(' Error','Please select service station.',3);
                return false;
            }       
                
            var vehicleMeter =document.getElementById("vehicleMeter").value;                            
            if(vehicleMeter ==''){
                sweetAlert(' Error','Please enter vehicle meter value.',3);
                return false;
            } 
          
            var serviceChargers =document.getElementById("serviceChargers").value;                            
            if(serviceChargers ==''){
                sweetAlert(' Error','Please enter service chargers.',3);
                return false;
            } 
		  
            var discription =document.getElementById("discription").value;                            
            if(discription ==''){
                sweetAlert(' Error','Please enter service discription.',3);
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
                $( "#servicedate" ).datepicker({
                  format: "yyyy-mm-dd",  
                });
	});
        
</script>
<script type="text/javascript">
	$('#vehicleMeter').change(function(e){      
            var vehicleMeter =document.getElementById("vehicleMeter").value;
            var extra= 5000;
            var mySum = parseInt(vehicleMeter) + extra;
            document.getElementById("nextServiceMilage").value=mySum;
            
         }); 
</script>


@stop
