@extends('layouts.sammy_new.master') @section('title','Add Repair Record')
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
    	<a href="{{{url('transportLorryRepair/list')}}}">Lorries Repair</a>
  	</li>
  	<li class="active">Add Repair Record</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Repair Record</strong>
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
                        <label class="col-sm-2 control-label required">Repair Date</label>
                        <div class="col-sm-10">                                                												
                                <input type="text" class="form-control @if($errors->has('repairdate')) error @endif" name="repairdate" id="repairdate" placeholder="Repair Date" value="" >
                                    @if($errors->has('repairdate'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('repairdate')}}</label>
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
			<label class="col-sm-2 control-label required">Garage</label>
			<div class="col-sm-10">     
                                                        @if($errors->has('garage'))
								{!! Form::select('garage', $service, Input::old('garage'),['placeholder' => 'Select garage','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'garage']) !!}
								<label id="supervisor-error" class="error" for="location">{{$errors->first('location')}}</label>
							@else
								{!! Form::select('garage', $service, Input::old('garage'),['placeholder' => 'Select garage','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'garage']) !!}
							@endif
                      
			</div>
                    </div>        
                        
                        
                    <div class="form-group">
                                        <label class="col-sm-2 control-label required">Repair Chargers</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('serviceChargers')) error @endif" name="serviceChargers" id="serviceChargers" placeholder="Service Chargers" required value="{{Input::old('serviceChargers')}}">
                                                    @if($errors->has('serviceChargers'))
                                                        <label id="label-error" class="error" for="serviceChargers">{{$errors->first('serviceChargers')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In Rupee (Rs).</label>
                                        </div>
                    </div>
					<div class="form-group">
                                        <label class="col-sm-2 control-label required">Repair Discription</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control @if($errors->has('discription')) error @endif" name="discription" id="discription" required >{{Input::old('serviceChargers')}}</textarea>
                                                    @if($errors->has('discription'))
                                                        <label id="label-error" class="error" for="discription">{{$errors->first('discription')}}</label>
                                                    @endif
                                                    
                                        </div>
                    </div>
                        
                    <div class="panel-heading border">
                                    <strong>Added new spare parts</strong>
					</div>    
					<br>
					<div class="form-group">
	            		<label class="col-sm-2 control-label">Spare Part Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="part_name[]" id="part_name" placeholder="Spare Part Name" value="{{Input::old('part_name[]')}}">
						</div>
					</div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label">Serial Number</label>
	            		<div class="col-sm-10">
                            <input type="text" class="form-control" name="serial_number[]" id="serial_number" placeholder="Serial Number" value="{{Input::old('serial_number[]')}}">
						</div>
	                </div>
                    <hr>
                    <span id="responce"></span>	
					<div class="form-group">
						<div class="pull-right">
							<button type="button" onclick="addInput()" class="btn btn-primary"><i class="fa fa-arrow-circle-down"></i> Add new spare part</button>
						</div>
					</div>	
                  
					
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Repair Document</label>
                        <div class="col-sm-10">                                                												
                            <input type="file" class="form-control @if($errors->has('document')) error @endif" name="document" placeholder="Document" >
							@if($errors->has('document'))
                                <label id="label-error" class="error" for="label">{{$errors->first(document)}}</label>
							@endif														
							<label id="label-error" class="error" for="label">Upload scanned document. Allowed image formats (.jpg, .jpeg, .png., .gif)</label>
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
<script>
        var countBox =1;
        var boxName = 0;
        function addInput()
            {
                var boxName="textBox"+countBox; 
                document.getElementById('responce').innerHTML+='<div class="form-group"><label class="col-sm-2 control-label">Spare Part Name</label><div class="col-sm-10"><input type="text" class="form-control" name="part_name[]" placeholder="Spare Part Name" id="part_name"></div></div>'+
                                                               '<div class="form-group"><label class="col-sm-2 control-label">Serial Number</label><div class="col-sm-10"><input type="text" class="form-control" name="serial_number[]" placeholder="Serial Number" id="serial_number"></div></div><hr>';
                countBox += 1;
           }
</script>

<script type="text/javascript">
        $('#add').click(function(e){
			var y = document.getElementById("lorry");		
            var y = document.getElementById("lorry");
            var re = y.options[y.selectedIndex].value;
	
            if(re ==0){
                sweetAlert(' Error','Please select lorry.',3);
                return false;
            }   
            
           
            var repairdate =document.getElementById("repairdate").value; 	
            if(repairdate ==''){
                sweetAlert(' Error','Please enter repair date.',3);
                return false;
            }  
		
            var vehicleMeter =document.getElementById("vehicleMeter").value; 	
            if(vehicleMeter ==''){
                sweetAlert(' Error','Please enter vehicle meter.',3);
                return false;
            }      
           
            var sh = document.getElementById("garage");
            var shv = sh.options[sh.selectedIndex].value;
	
            if(shv ==0){
                sweetAlert(' Error','Please select garage.',3);
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
                $( "#repairdate" ).datepicker({
                  format: "yyyy-mm-dd",  
                });
	});
        
</script>



@stop
