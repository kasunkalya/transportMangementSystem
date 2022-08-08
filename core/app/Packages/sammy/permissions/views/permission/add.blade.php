@extends('layouts.sammy_new.master') @section('title','Add Permission')
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
    	<a href="{{{url('permission/list')}}}">Permission Management</a>
  	</li>
  	<li class="active">Add Permission</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Permission</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}
          		<div class="form-group">
	            		<label class="col-sm-2 control-label required">Permission</label>
	            		<div class="col-sm-10">
	            			<input type="text" class="form-control @if($errors->has('permission')) error @endif" name="permission" placeholder="Permission" required value="{{Input::old('permission')}}">
	            			@if($errors->has('permission'))
	            				<label id="label-error" class="error" for="permission">{{$errors->first('permission')}}</label>
	            			@endif
	            		</div>
	                </div>
		          	<div class="form-group">
	            		<label class="col-sm-2 control-label required">Description</label>
	            		<div class="col-sm-10">
                                    <textarea class="form-control @if($errors->has('description')) error @endif" name="description" placeholder="Description" required>{{Input::old('description')}}</textarea>
	            			@if($errors->has('description'))
	            				<label id="label-error" class="error" for="label">{{$errors->first('description')}}</label>
	            			@endif
	            		</div>
	                </div>
          			
		          
	                <div class="pull-right">
	                	<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                                <a href="{{{url('permission/list')}}}"><button type="button"  class="btn btn-primary"><i class="fa fa-angle-left"></i> Go Back</button></a>
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
	$(document).ready(function(){
		$('.form-validation').validate();
		$('#permissions').multiSelect();
	});
</script>
@stop
