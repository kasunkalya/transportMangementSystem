@extends('layouts.sammy_new.master') @section('title','Edit Charging Rules')
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
    	<a href="{{{url('transportLorryChargers/list')}}}">Charging Rules</a>
  	</li>
  	<li class="active">Edit Charging Rules</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit Charging Rules</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
					<div class="form-group">
						<label class="col-sm-2 control-label required">Lorry</label>
						<div class="col-sm-10">
							@if($errors->has('lorry'))
								{!! Form::select('lorry', $lorry, $chargers->lorry_id,['placeholder' => 'Select Lorry','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry']) !!}
								<label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
							@else
								{!! Form::select('lorry', $lorry, $chargers->lorry_id,['placeholder' => 'Select Lorry','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry']) !!}
							@endif

						</div>
					</div>
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Route</label>
						<div class="col-sm-10">
							@if($errors->has('route'))
								{!! Form::select('route', $route, $chargers->route_id,['placeholder' => 'Select Route','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'route']) !!}
								<label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
							@else
								{!! Form::select('route', $route, $chargers->route_id,['placeholder' => 'Select Route','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'route']) !!}
							@endif

						</div>
					</div>
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Charging Type</label>
						<div class="col-sm-10">
							@if($errors->has('chargingType'))
								{!! Form::select('chargingType', $chargesTypes, $chargers->charging_type_id,['placeholder' => 'Select Chargin Type','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'chargingType']) !!}
								<label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
							@else
								{!! Form::select('chargingType', $chargesTypes, $chargers->charging_type_id,['placeholder' => 'Select Chargin Type','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'chargingType']) !!}
							@endif

						</div>
					</div>
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label">Sub category</label>
						<div class="col-sm-10">						
                                                    <select class="form-control" name="category" id="category" >
                                                        <option value="0">Select sub category</option>
                                                    </select>                                                   
						</div>
                                              
					</div>
                                                        
                                        <div class="form-group">
                                                <label class="col-sm-2 control-label ">Chargers</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control @if($errors->has('chargers')) error @endif" id="chargers" name="chargers" placeholder="Chargers" value="{{$chargers->charges}}">
                                                    @if($errors->has('chargers'))
                                                        <label id="label-error" class="error" for="chargers">{{$errors->first('chargers')}}</label>
                                                    @endif

                                                </div>
                                        </div>
                                       
				
                   
	                <div class="pull-right">
                            <button type="submit" class="btn btn-primary" id="add"><i class="fa fa-floppy-o"></i> Update</button>
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
            var re = y.options[y.selectedIndex].value;
	
            if(re ==0){
                sweetAlert(' Error','Please select lorry.',3);
                return false;
            }   
          	
            var r = document.getElementById("route");
            var route = r.options[r.selectedIndex].value;	
            if(route ==0){
                sweetAlert(' Error','Please select route.',3);
                return false;
            }   
            
            var c = document.getElementById("chargingType");
            var chargingType = c.options[c.selectedIndex].value;	
            if(chargingType ==0){
                sweetAlert(' Error','Please select charging type.',3);
                return false;
            }   
            
            var chargers =document.getElementById("chargers").value;                            
            if(chargers ==''){
                sweetAlert(' Error','Please enter chargers.',3);
                return false;
            }     
            
            
            if(re !=0 && route !=0 && chargingType !=0 && chargers !=''){                
                $.ajax({
                    /* the route pointing to the post function */
                    url: '../isadd/'+re+'/'+route+'/'+chargingType+'/'+chargers,
                    type: 'get',                                  
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {                  
                        if(data !=0){
                            sweetAlert(' Error','Charging rule alredy added.',3);
                            return false;
                        }
                    }
                }); 
            }    
        });
  
        
</script>
<script type="text/javascript">
    jQuery(document).ready(function ()
    {
            jQuery('select[name="chargingType"]').on('change',function(){
               var makerID = jQuery(this).val();
    
               if(makerID)
               {
                  jQuery.ajax({
                     url : '../json/categorylist/' +makerID,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {
                            $('#category').empty();
                            $("#category").append('<option value="0">Select sub category</option>');
                            if(res)
                            {
                                $.each(res,function(key,value){
                                    
                                    
                                    
                                    $('#category').append($("<option/>", {
                                       value: value,
                                       text: key
                                    }));
                                });
                            }
                        
                     }
                  });
               }
               else
               {
                 $('#category').empty();
               }
            });
            
            
            
            
            
                var makerID = jQuery('select[name="chargingType"]').val();  
            
                  jQuery.ajax({
                     url : '../json/categorylist/' +makerID,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {
                            $('#category').empty();
                            $("#category").append('<option value="0">Select sub category</option>');
                            if(res)
                            {
                                $.each(res,function(key,value){
                                  
                                     if(value == '<?php echo $chargers->charging_sub_type?>'){
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
    
    });
    </script>


@stop
