@extends('layouts.sammy_new.master') @section('title','Add Transport Customer')
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
    	<a href="{{{url('transportCustomer/list')}}}">Customers</a>
  	</li>
  	<li class="active">Add Customer</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Customer</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}      
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Invoice Code</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('invoice_code')) error @endif" name="invoice_code" id="invoice_code"  placeholder="Invoice Code" required value="{{Input::old('invoice_code')}}">
							@if($errors->has('invoice_code'))
								<label id="label-error" class="error" for="invoice_code">{{$errors->first('invoice_code')}}</label>
							@endif							
	            		</div>
	                </div>
		        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('name')) error @endif" name="name" id="name"  placeholder="Name" required value="{{Input::old('name')}}">
							@if($errors->has('name'))
								<label id="label-error" class="error" for="name">{{$errors->first('name')}}</label>
							@endif							
	            		</div>
	                </div>
          			
                       <div class="form-group">
	            		<label class="col-sm-2 control-label">Other Names</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('othername')) error @endif" name="othername" id="othername" placeholder="Other Name"  value="{{Input::old('othername')}}">
							@if($errors->has('othername'))
								<label id="label-error" class="error" for="othername">{{$errors->first('othername')}}</label>
							@endif					
	            		</div>
	                </div>
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Address</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('address')) error @endif" name="address" id="address" placeholder="Address"  value="{{Input::old('address')}}">
							@if($errors->has('address'))
								<label id="label-error" class="error" for="address">{{$errors->first('address')}}</label>
							@endif					
	            		</div>
	                </div>
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Telephone Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('telephone')) error @endif" name="telephone" id="telephone" placeholder="Telephone Number"  value="{{Input::old('telephone')}}">
							@if($errors->has('telephone'))
								<label id="label-error" class="error" for="telephone">{{$errors->first('telephone')}}</label>
							@endif					
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Fax Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('fax')) error @endif" name="fax" id="fax" placeholder="Fax Number"  value="{{Input::old('fax')}}">
							@if($errors->has('fax'))
								<label id="label-error" class="error" for="fax">{{$errors->first('fax')}}</label>
							@endif					
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Email</label>
	            		<div class="col-sm-10">
                                    <input type="email" class="form-control @if($errors->has('email')) error @endif" name="email" id="email" placeholder="Email"  value="{{Input::old('email')}}">
							@if($errors->has('email'))
								<label id="label-error" class="error" for="email">{{$errors->first('email')}}</label>
							@endif					
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Website</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('website')) error @endif" name="website" id="website" placeholder="Website"  value="{{Input::old('website')}}">
							@if($errors->has('website'))
								<label id="label-error" class="error" for="website">{{$errors->first('website')}}</label>
							@endif					
	            		</div>
	                </div>
                    <div class="form-group">
	            		<label class="col-sm-2 control-label required">Customer Since</label>
	            		<div class="col-sm-10">
                                    <input type="text" id="start_date" class="form-control @if($errors->has('start_date')) error @endif" name="start_date" id="start_date" placeholder="Start Date" required value="{{Input::old('start_date')}}">
							@if($errors->has('start_date'))
								<label id="label-error" class="error" for="start_date">{{$errors->first('start_date')}}</label>
							@endif
	            		</div>
	                </div>
					
					
                        <div class="form-group">
                               <label class="col-sm-2 control-label">Customer Contract Document</label>
                               <div class="col-sm-10">                                                												
                                    <input type="file" class="form-control @if($errors->has('customer_contract_document')) error @endif" name="customer_contract_document" placeholder="Customer Contract Document" >
					@if($errors->has('customer_contract_document'))
                                            <label id="label-error" class="error" for="label">{{$errors->first('customer_contract_document')}}</label>
					@endif														
                                    <label id="label-error" class="error" for="label">Upload scanned customer contract document. Allowed image formats (.jpg, .jpeg, .png., .gif)</label>
                                </div>
                        </div>
                        
                    <div class="form-group">
	            		<label class="col-sm-2 control-label required">Customer Vat Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" id="vatNumber" class="form-control @if($errors->has('vatNumber')) error @endif" name="vatNumber" id="vatNumber" placeholder="Customer Vat Number"  value="{{Input::old('vatNumber')}}">
							@if($errors->has('vatNumber'))
								<label id="label-error" class="error" for="vatNumber">{{$errors->first('vatNumber')}}</label>
							@endif
	            		</div>
	                </div>
					
					
					
					<div class="form-group">
						<label class="col-sm-2 control-label required">Invoice Layout</label>
						<div class="col-sm-10">
							@if($errors->has('invoice'))
								{!! Form::select('invoice', $muthumalaInvoice, Input::old('invoice'),['placeholder' => 'Select Invoice Layout','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'invoice']) !!}
								<label id="supervisor-error" class="error" for="invoice">{{$errors->first('invoice')}}</label>
							@else
								{!! Form::select('invoice', $muthumalaInvoice, Input::old('invoice'),['placeholder' => 'Select Invoice Layout','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'invoice']) !!}
							@endif

						</div>
					</div>
					
					
					<div class="form-group">
						<label class="col-sm-2 control-label required">Invoice Summary Layout</label>
						<div class="col-sm-10">
							@if($errors->has('invoiceSummary'))
								{!! Form::select('invoiceSummary', $muthumalaInvoiceSummary, Input::old('invoiceSummary'),['placeholder' => 'Select Invoice Summary Layout','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'invoiceSummary']) !!}
								<label id="supervisor-error" class="error" for="invoice">{{$errors->first('invoice')}}</label>
							@else
								{!! Form::select('invoiceSummary', $muthumalaInvoiceSummary, Input::old('invoiceSummary'),['placeholder' => 'Select Invoice Summary Layout','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'invoiceSummary']) !!}
							@endif

						</div>
					</div>
					
					
					
                        
                <div class="panel-heading border">
                    <strong>Details of Contact person</strong>
		</div>    
		<div class="form-group">
	            		<label class="col-sm-2 control-label">Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_name[]" placeholder="Contact Name" value="{{Input::old('c_name[]')}}">
				</div>
	        </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Department</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_department[]" placeholder="Contact Department" value="{{Input::old('c_department[]')}}">
		          	</div>
	                </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Telephone Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_number[]" placeholder="Contact Number" value="{{Input::old('c_number[]')}}">
			        </div>
	                </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Email</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_email[]" placeholder="Contact Email" value="{{Input::old('c_email[]')}}">
				</div>
	                </div>	
                        
                    <hr>
                        
                        <span id="responce"></span>		
                        <div class="pull-left">
                                <button type="button" onclick="addInput()" class="btn btn-primary"><i class="fa fa-arrow-circle-down"></i> Add new contact</button>
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
<script>
        var countBox =1;
        var boxName = 0;
        function addInput()
            {
                var boxName="textBox"+countBox; 
                document.getElementById('responce').innerHTML+='<div class="form-group"><label class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" class="form-control" name="c_name[]" placeholder="Contact Person" id="c_name"></div></div>'+
                                                               '<div class="form-group"><label class="col-sm-2 control-label">Department</label><div class="col-sm-10"><input type="text" class="form-control" name="c_department[]" placeholder="Contact Department" id="c_department"></div></div>'+
                                                               '<div class="form-group"><label class="col-sm-2 control-label">Telephone Number</label><div class="col-sm-10"><input type="text" class="form-control" name="c_number[]" placeholder="Contact Name" id="c_number"></div></div>'+
                                                               '<div class="form-group"><label class="col-sm-2 control-label">Email</label><div class="col-sm-10"><input type="text" class="form-control" name="c_email[]" placeholder="Contact Email" id="c_email"></div></div> <hr>';
                countBox += 1;
           }
    </script>
<script type="text/javascript">
        $('#add').click(function(e){          
            
            var invoice_code =document.getElementById("invoice_code").value;                            
            if(invoice_code ==''){
                sweetAlert(' Error','Please invoice code.',3);
                return false;
            } 
            var name =document.getElementById("name").value;                            
            if(name ==''){
                sweetAlert(' Error','Please enter name.',3);
                return false;
            } 
            
            var telephone_numbers =document.getElementById("telephone").value;                            
            if(telephone_numbers !=''){                           
                if(!(telephone_numbers.length == 10)){   
                    sweetAlert(' Error','Please enter valid telephone numbers',3);
                    return false;                   
                }
            }
            var fax_numbers =document.getElementById("fax").value;                            
            if(fax_numbers !=''){           
                if(!(fax_numbers.length == 10)){   
                    sweetAlert(' Error','Please enter valid fax numbers',3);
                    return false;                   
                }
            }
            var email =document.getElementById("email").value;                            
            if(email !=''){                      
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test(email) == false) 
                {                    
                    sweetAlert(' Error','Please enter valid email.',3);
                    return false;
                }  
            }     
            var start_date =document.getElementById("start_date").value;                            
            if(start_date ==''){
                sweetAlert(' Error','Please enter customer since.',3);
                return false;
            } 
            
            
            
        });
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.form-validation').validate();
		$('#permissions').multiSelect();
                $( "#start_date" ).datepicker({
                  format: "yyyy-mm-dd", 
                }); 
	});
</script>
@stop
