@extends('layouts.sammy_new.master') @section('title','Transport Edit Driver')
@section('css')
<style type="text/css">
	.switch.switch-sm{
		width: 30px;
    	height: 16px;
	}

	.switch.switch-sm span i::before{
		width: 16px;
    	height: 16px;
	}

.btn-success:hover, .btn-success:focus, .btn-success.focus, .btn-success:active, .btn-success.active, .open > .dropdown-toggle.btn-success {
    color: white;
    background-color: #D96557;
    border-color: #D96557;
}
.btn-success {
    color: white;
    background-color: #D96456;
    border-color: #D96456;
}


.btn-success::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    z-index: -1;
    width: 100%;
    height: 100%;
    background-color: #BB493C;
    -moz-opacity: 0;
    -khtml-opacity: 0;
    -webkit-opacity: 0;
    opacity: 0;
    -ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0 * 100);
    filter: alpha(opacity=0 * 100);
    -webkit-transform: scale3d(0.7, 1, 1);
    -moz-transform: scale3d(0.7, 1, 1);
    -o-transform: scale3d(0.7, 1, 1);
    -ms-transform: scale3d(0.7, 1, 1);
    transform: scale3d(0.7, 1, 1);
    -webkit-transition: transform 0.4s, opacity 0.4s;
    -moz-transition: transform 0.4s, opacity 0.4s;
    -o-transition: transform 0.4s, opacity 0.4s;
    transition: transform 0.4s, opacity 0.4s;
    -webkit-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
    -moz-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
    -o-animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
    animation-timing-function: cubic-bezier(0.2, 1, 0.3, 1);
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
}


.switch :checked + span {
    border-color: #398C2F;
    -webkit-box-shadow: #398C2F 0px 0px 0px 21px inset;
    -moz-box-shadow: #2ecc71 0px 0px 0px 21px inset;
    box-shadow: #398C2F 0px 0px 0px 21px inset;
    -webkit-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
    -moz-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
    -o-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
    transition: border 300ms, box-shadow 300ms, background-color 1.2s;
    background-color: #398C2F;
}

.datatable a.blue {
    color: #1975D1;
}

.datatable a.blue:hover {
    color: #003366;
}

</style>
@stop
@section('content')
<ol class="breadcrumb">
	<li>
    	<a href="{{{url('/')}}}"><i class="fa fa-home mr5"></i>Home</a>
  	</li>
  	<li class="active">
		<a href="{{{url('transportManagement/addDriver')}}}">Edit Drivers / Helpers</a>
  	</li>

</ol>
<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-bordered">
				<div class="panel-heading border">
					<div class="row">
						<div class="col-xs-6"><strong>Edit Drivers / Helpers</strong></div>
<!--						<div class="col-xs-6 text-right"><a href="{{{url('transportManagement/add')}}}"><button class="btn btn-success"><i class="fa fa-plus" style="width: 28px;"></i>Transport Request Add</button></a></div>-->
					</div>
				</div>
                                <div class="panel panel-bordered panel-primary" style="margin:5px;">
                                        <div class="panel-heading">Search By</div>
                                        <div class="panel-body" id="myRadioGroup">
                                              <label class="radio-inline">
                                                  <input type="radio" name="optradio" id="optradio" value="1" checked>Trip Date
                                              </label>
                                              <label class="radio-inline">
                                                <input type="radio" name="optradio" id="optradio" value="2">Lorry
                                              </label>
                                              <label class="radio-inline">
                                                <input type="radio" name="optradio" id="optradio" value="3">Trip Number
                                              </label>  
                                            
                                            <div id="optradio1" class="desc">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label required">Request From Date</label>
                                                    <div class="col-sm-4">
                                                        <input type="text"  id="invoicedatefrom" class="form-control @if($errors->has('invoicedatefrom')) error @endif" name="invoicedatefrom" placeholder="Invoice From Date" required value="{{date('Y-m-d')}}">
                                                            @if($errors->has('invoicedatefrom'))
                                                                    <label id="label-error" class="error" for="invoicedatefrom">{{$errors->first('invoicedatefrom')}}</label>
                                                            @endif      
                                                    </div>                                                
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label required">Request To Date</label>
                                                    <div class="col-sm-4">
                                                        <input type="text"  id="invoicedateto" class="form-control @if($errors->has('invoicedateto')) error @endif" name="invoicedateto" placeholder="Invoice To Date" required value="{{date('Y-m-d')}}">
                                                            @if($errors->has('invoicedateto'))
                                                                    <label id="label-error" class="error" for="invoicedateto">{{$errors->first('invoicedateto')}}</label>
                                                            @endif      
                                                    </div>                                                
                                                </div>
                                                
                                            </div>
                                            
                                            <div id="optradio2" class="desc">
                                                 <div class="form-group">
                                                    <label class="col-sm-2 control-label required">Lorry</label>
                                                    <div class="col-sm-10">
                                                                @if($errors->has('lorry'))
                                                                        {!! Form::select('lorry',$lorry, Input::old('lorry'),['placeholder' => 'Select lorry','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry']) !!}
                                                                        <label id="supervisor-error" class="error" for="lorry">{{$errors->first('lorry')}}</label>
                                                                @else
                                                                        {!! Form::select('lorry',$lorry, Input::old('lorry'),['placeholder' => 'Select lorry','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'lorry']) !!}
                                                                @endif

                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div id="optradio3" class="desc">
                                                
                                                 <div class="form-group">
                                                    <label class="col-sm-2 control-label required">Trip Number</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="invoiceNumber" class="form-control @if($errors->has('invoiceNumber')) error @endif" name="invoiceNumber" placeholder="Trip Number" required value="{{Input::old('invoiceNumber')}}">
                                                            @if($errors->has('invoiceNumber'))
                                                                <label id="label-error" class="error" for="invoiceNumber">{{$errors->first('invoiceNumber')}}</label>
                                                            @endif      
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="pull-right" style=" margin:10px;">
                                            <button id="search" type="button" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                            
                                        </div>
                                      
                                       
                                    
                                </div>
                       
                            

				<div class="panel-body">
                                    <form role="form" class="form-horizontal form-validation" method="post">
					<table class="table table-bordered bordered table-striped table-condensed datatable">
						<thead>
							<tr>
								<th rowspan="2" class="text-center" width="4%">#</th>
								<th rowspan="2" class="text-center" style="font-weight:normal;">Trip No</th>
								<th rowspan="2" class="text-center" style="font-weight:normal;">Trip Date</th>
								<th rowspan="2" class="text-center" style="font-weight:normal;">Lorry</th>
                                                                <th rowspan="2" class="text-center" style="font-weight:normal;">Driver</th>
                                                                <th rowspan="2" class="text-center" style="font-weight:normal;">Helper</th>
								<th colspan="1" class="text-center" width="4%" style="font-weight:normal;">Action</th>
							</tr>
							<tr style="display: none;">
								<th style="display: none;" width="2%"></th>								
							</tr>
						</thead>
					</table>
                                        <div class="panel-body">
                                            
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Driver</label>
						<div class="col-sm-10">
							@if($errors->has('driver'))
								{!! Form::select('driver',$employee, Input::old('driver'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'driver']) !!}
								<label id="supervisor-error" class="error" for="route">{{$errors->first('route')}}</label>
							@else
								{!! Form::select('driver',$employee, Input::old('driver'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'driver']) !!}
							@endif
							
						</div>
					</div>
                                            
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Helper</label>
						<div class="col-sm-10">
							@if($errors->has('helper'))
								{!! Form::select('helper',$employee, Input::old('helper'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'helper']) !!}
								<label id="supervisor-error" class="error" for="route">{{$errors->first('route')}}</label>
							@else
								{!! Form::select('helper',$employee, Input::old('helper'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'helper']) !!}
							@endif
							
						</div>
					</div>
                                        
                                            <div class="pull-right">
                                                <button id="adddriver" type="button" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Add Driver/ Helper</button>
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
<script type="text/javascript">
        $('#adddriver').click(function(e){  
            var inputElements='0';
            inputElements = $('.messageCheckbox:checked').val();      
            if (typeof inputElements == "undefined" || inputElements == null) {
                sweetAlert(' Error','Please select trip.',3);
                return false;
            }
            
           
            
            var y = document.getElementById("driver");
            var re = y.options[y.selectedIndex].value;
            if(re =='0'){
                sweetAlert(' Error','Please select driver.',3);
                return false;
            }  
            var yh = document.getElementById("helper");
            var reh = yh.options[yh.selectedIndex].value;
            if(reh =='0'){
                sweetAlert(' Error','Please select helper.',3);
                return false;
            }  
            
            var cboxes = document.getElementsByName('trip[]');
            var len = cboxes.length;
            for (var i=0; i<len; i++) {
               if(cboxes[i].checked){
                   
                    //alert(i +cboxes[i].value);
                    
                    $.ajax({
                        /* the route pointing to the post function */
                        url: 'addDriverHelper/'+cboxes[i].value+'/'+re+'/'+reh,
                        type: 'GET',                  
                        dataType: 'JSON',
                        /* remind that 'data' is the response of the AjaxController */
                        success: function (data) { 
    //                            $(".writeinfo").append(data.msg); 
                            }
                    }); 
                    
                    
                }
                
            }
            
            if(len == i){
                loadTable();
                sweetAlert('Driver & Helper added','Record Added Successfully!',0);
                
            }
          
            
        });
</script>

<script type="text/javascript">
	var id = 0;
	var table = '';
	$(document).ready(function(){
            $("#optradio2").hide();
            $("#optradio3").hide();
            
                var date = new Date();
                date.setDate(date.getDate());  
                
                $( "#invoicedatefrom" ).datepicker({
                    format: "yyyy-mm-dd", 
                    //startDate: date,
                }); 
                
                $( "#invoicedateto" ).datepicker({
                    format: "yyyy-mm-dd", 
                    //startDate: date,
                }); 

            
                $("input[name$='optradio']").click(function() {
                    var test = $(this).val();
                    $("div.desc").hide();
                    $("#optradio" + test).show();
                });
            
		table = generateTable('.datatable', '{{url('transportManagement/json/editsearchlist')}}/'+0+'/'+0+'/'+0+'/'+0+'/'+0,[],[]);

	});

	/**
	 * Delete the menu return function
	 * Return to this function after sending ajax request to the menu/delete
	 */
	function handleData(data){
		if(data.status=='success'){
			sweetAlert('Delete Success','Record Deleted Successfully!',0);
			table.ajax.reload();
		}else if(data.status=='invalid_id'){
			sweetAlert('Delete Error','Permission Id doesn\'t exists.',3);
		}else{
			sweetAlert('Error Occured','Please try again!',3);
		}
	}

	function successFunc(data){
		table.ajax.reload();
	}
  
</script>
<script type="text/javascript">
        $('#search').click(function(e){ loadTable()});
        
        function loadTable(){
                    var optradio =$("input[name='optradio']:checked").val();    
                    var invoicedatefrom =document.getElementById("invoicedatefrom").value;
                    var invoicedateto =document.getElementById("invoicedateto").value;
                    var y = document.getElementById("lorry");
                    var lorry = y.options[y.selectedIndex].value;            
                    var invoiceNumber =document.getElementById("invoiceNumber").value;
                    

                  if(optradio==1){
                    if(invoicedatefrom ==''){
                        sweetAlert(' Error','Please select request from date.',3);
                        return false;
                    } 
                    if(invoicedateto ==''){
                        sweetAlert(' Error','Please select request to date.',3);
                        return false;
                    } 
                  }
                  if(optradio==2){
                    if(lorry ==''){
                        sweetAlert(' Error','Please select lorry.',3);
                        return false;
                        
                    }           
                  }
                   if(optradio==3){
                    if(invoiceNumber ==''){
                        sweetAlert(' Error','Please enter invoice number.',3);
                        return false;
                    }           
                  }

                    if(invoiceNumber !=''){
                        var invoice=invoiceNumber;
                    }else{
                       var invoice=0;
                    }
                    
                     if(lorry !=''){
                        var lorry=lorry;
                    }else{
                       var lorry=0;
                    }

                        table.destroy();
                        table = generateTable('.datatable', '{{url('transportManagement/json/editsearchlist')}}/'+optradio+'/'+invoicedatefrom+'/'+invoicedateto+'/'+lorry+'/'+invoice,[],[]);


        }
</script>

@stop
