@extends('layouts.sammy_new.master') @section('title','Edit Milage Record')
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
    	<a href="{{{url('transportLorry/milagelist')}}}">Milage</a>
  	</li>
  	<li class="active">Edit Milage Record</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit Milage Record</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}

                    <div class="form-group">
                        <label class="col-sm-2 control-label required">Date</label>
                        <div class="col-sm-10">                                                												
                            <input type="text" class="form-control @if($errors->has('date')) error @endif" name="date" readonly placeholder="Date" value="{{date('Y-m-d')}}" >
                                    @if($errors->has('date'))
                                        <label id="label-error" class="error" for="label">{{$errors->first('repairdate')}}</label>
                                    @endif														

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>   
                        <div class="col-sm-10">
                                <table class="table table-bordered bordered table-striped table-condensed datatable">
                                  <thead>
                                      <tr>
                                          <th rowspan="2" class="text-center" style="font-weight:normal;">Lorry</th>
                                          <th colspan="1" class="text-center" style="font-weight:normal;">Milage</th>
                                      </tr>
                                      <tr style="display: none;">
		                	<th style="display: none;" width="2%"></th>
		                	
                                     </tr>
                                  </thead>

    
                          </table>  
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
	var id = 0;
	var table = '';
	$(document).ready(function(){
            var date={{$date}};
		table = generateTable('.datatable', '{{url('transportLorry/json/milageeditlist')}}/<?php echo $date ?>');

	});
 </script>    
@stop
