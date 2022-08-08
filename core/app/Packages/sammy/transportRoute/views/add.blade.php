@extends('layouts.sammy_new.master') @section('title','Add Route')
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
    	<a href="{{{url('transportRoute/list')}}}">Transport Routes</a>
  	</li>
  	<li class="active">Add Transport Route</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Transport Route</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}
		        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Name</label>
	            		<div class="col-sm-10">
						<input type="text" class="form-control @if($errors->has('name')) error @endif" name="name" id="name" placeholder="Name" required value="{{Input::old('name')}}">
							@if($errors->has('name'))
								<label id="label-error" class="error" for="name">{{$errors->first('name')}}</label>
							@endif
	            		</div>
	                </div>
          		<div class="form-group">
	            		<label class="col-sm-2 control-label required">Minimum Distance</label>
	            		<div class="col-sm-10">
                                    <input type="number" class="form-control @if($errors->has('minDistance')) error @endif" name="minDistance" id="minDistance" placeholder="Minimum Distance" required value="{{Input::old('minDistance')}}">
	            			@if($errors->has('minDistance'))
	            				<label id="label-error" class="error" for="minDistance">{{$errors->first('minDistance')}}</label>
	            			@endif
                                        <label id="label-error" class="error" for="">In kilometers (km).</label>
	            		</div>
	                </div>	
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Driver Rate</label>
	            		<div class="col-sm-10">
                                    <input type="number" class="form-control @if($errors->has('driver_rate')) error @endif" name="driver_rate" id="driver_rate" placeholder="Driver Rate" required value="{{Input::old('driver_rate')}}">
	            			@if($errors->has('driver_rate'))
	            				<label id="label-error" class="error" for="driver_rate">{{$errors->first('driver_rate')}}</label>
	            			@endif
                                </div>
	                </div>	
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Helper Rate</label>
	            		<div class="col-sm-10">
                                    <input type="number" class="form-control @if($errors->has('helper_rate')) error @endif" name="helper_rate" id="helper_rate" placeholder="Helper Rate" required value="{{Input::old('helper_rate')}}">
	            			@if($errors->has('helper_rate'))
	            				<label id="label-error" class="error" for="helper_rate">{{$errors->first('helper_rate')}}</label>
	            			@endif
                                </div>
	                </div>	
		          
	                <div class="pull-right">
                            <button type="submit" id="add" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
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
         
//            var code =document.getElementById("code").value;                            
//            if(code ==''){
//                sweetAlert(' Error','Please enter code.',3);
//                return false;
//            } 
            var name =document.getElementById("name").value;                            
            if(name ==''){
                sweetAlert(' Error','Please enter name.',3);
                return false;
            } 
            var minDistance =document.getElementById("minDistance").value;                            
            if(minDistance ==''){
                sweetAlert(' Error','Please enter minimum distance.',3);
                return false;
            } 
            
            var driver_rate =document.getElementById("driver_rate").value;                            
            if(driver_rate ==''){
                sweetAlert(' Error','Please enter driver rate.',3);
                return false;
            } 
            
            var helper_rate =document.getElementById("helper_rate").value;                            
            if(helper_rate ==''){
                sweetAlert(' Error','Please enter helper rate.',3);
                return false;
            } 
            
            
            
        });
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();
		$('#permissions').multiSelect();
	});
</script>
@stop
