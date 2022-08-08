@extends('layouts.sammy_new.master') @section('title','Charging Rules')
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
    	<a href="{{{url('transportLorry/list')}}}">Lorries</a>
  	</li>
  	<li class="active"> @if ($paymentView === 1)
                            Add
                            @else
                            View
                            @endif
                            Charging Rules</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>
                            @if ($paymentView === 1)
                            Add
                            @else
                            View
                            @endif
                            Charging Rules</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}	
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label required">License Plate No</label>
                                            <div class="col-sm-10">
                                                <input type="text" readonly="" class="form-control @if($errors->has('licensePlate')) error @endif" id="licensePlate" name="licensePlate" placeholder="License Plate" required value="{{$lorry[0]->licence_plate}}">
                                                    @if($errors->has('licensePlate'))
                                                            <label id="label-error" class="error" for="code">{{$errors->first('licensePlate')}}</label>
                                                    @endif
                                            </div>
                                        </div>
                        
                        <div class="panel-body">
                            <table class="table table-bordered bordered table-striped table-condensed datatable">
                                <thead>
                                        <tr>                                                                                       
                                                <th class="text-center" style="font-weight:normal;">Route</th>
                                                @foreach ($transportCharginList as $transportChargin)
                                                <th class="text-center" width="1%" style="font-weight:normal;">{{$transportChargin->type_name}}</th>
                                                @endforeach 			
                                        </tr>		                
                                </thead>
                                <tbody>
                                    @foreach ($route as $routeDetail)                                    
                                        <tr>
                                            <td class="text-center" style="font-weight:normal;">{{$routeDetail->route_name}}</td>
                                            @foreach ($transportCharginList as $transportChargin)   
                                            <td><input type="text" name="value[]" id="{{$routeDetail->id}}_{{$transportChargin->id}}"></td>
                                                <input type="hidden" name="route[]" value="{{$routeDetail->id}}">
                                                <input type="hidden" name="charging[]" value="{{$transportChargin->id}}">
                                            @endforeach 
                                        </tr>
                                    
                                    @endforeach          
                                    
                                </tbody>
                            </table>
                        </div>                   
	                <div class="pull-right">                           
                            @if ($paymentView === 1)
                                <button type="submit" id="update" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                            @endif
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
                
                
               var lorryId = <?php echo $lorry[0]->id ?>;   
                  jQuery.ajax({
                     url : '../json/paymentRulelist/' +lorryId,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {                            
                            if(res)
                            {
                                $.each(res,function(key,value){      
                                    document.getElementById(value['route_id']+'_'+value['charging_type_id']).value = value['charges'];
                                });
                            }                        
                     }
                  });
              
                
	});
        
</script>



@stop
