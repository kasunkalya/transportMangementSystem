@extends('layouts.sammy_new.master') @section('title','View Transport Supplier')
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
    	<a href="{{{url('transportSupplier/list')}}}">Supplier</a>
  	</li>
  	<li class="active">View Supplier</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
                        <div style="padding-bottom: 6px;padding-top: 6px; display: inline-block;">
                            <strong>View Supplier</strong>
                        </div>
                        <a class="pull-right btn btn-danger" href="{{{url('transportSupplier/list')}}}"><i class="fa fa-arrow-left"></i> Back</a>
      		</div>
                    
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}      
		         <div class="form-group">
	            		<label class="col-sm-2 control-label required">Code</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('code')) error @endif" name="code" id="code"  placeholder="code" required value="{{$customer->supplier_code}}">
							@if($errors->has('code'))
								<label id="label-error" class="error" for="code">{{$errors->first('code')}}</label>
							@endif							
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('name')) error @endif" name="name" id="name"  placeholder="Name" required value="{{$customer->suppliers_name}}">
							@if($errors->has('name'))
								<label id="label-error" class="error" for="name">{{$errors->first('name')}}</label>
							@endif							
	            		</div>
	                </div>
          			
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Type</label>
	            		<div class="col-sm-10">
                                    @if($errors->has('type'))
					{!! Form::select('type', array(null=>'Select Type','1' => 'Petrol Shed', '2' => 'Garage', '3' => 'Service Center', '4' => 'Other'), $customer->type,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'type','disabled' => true]) !!}
					<label id="supervisor-error" class="error" for="ownerSection">{{$errors->first('ownerSection')}}</label>
                                    @else
					{!! Form::select('type', array(null=>'Select Type','1' => 'Petrol Shed', '2' => 'Garage', '3' => 'Service Center', '4' => 'Other'),$customer->type,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'type','disabled' => true]) !!}
                                    @endif						
	            		</div>
	                </div>  
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Address</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('address')) error @endif" name="address" id="address" placeholder="Address"  value="{{$customer->address}}">
							@if($errors->has('address'))
								<label id="label-error" class="error" for="address">{{$errors->first('address')}}</label>
							@endif					
	            		</div>
	                </div>
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Telephone Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('telephone')) error @endif" name="telephone" id="telephone" placeholder="Telephone Number"  value="{{$customer->telephone_number}}">
							@if($errors->has('telephone'))
								<label id="label-error" class="error" for="telephone">{{$errors->first('telephone')}}</label>
							@endif					
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Fax Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('fax')) error @endif" name="fax" id="fax" placeholder="Fax Number"  value="{{$customer->fax_number}}">
							@if($errors->has('fax'))
								<label id="label-error" class="error" for="fax">{{$errors->first('fax')}}</label>
							@endif					
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Email</label>
	            		<div class="col-sm-10">
                                    <input type="email" readonly class="form-control @if($errors->has('email')) error @endif" name="email" id="email" placeholder="Email"  value="{{$customer->email}}">
							@if($errors->has('email'))
								<label id="label-error" class="error" for="email">{{$errors->first('email')}}</label>
							@endif					
	            		</div>
	                </div>   
                        
                              <hr>
                            <div class="form-group">
	            		<label class="col-sm-2 control-label">Vat Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('vat')) error @endif" name="vat" id="vat" placeholder="Vat Number"  value="{{$customer->vatNumber}}">
							@if($errors->has('vat'))
								<label id="label-error" class="error" for="vat">{{$errors->first('vat')}}</label>
							@endif					
	            		</div>
                            </div>
                            <div class="form-group">
	            		<label class="col-sm-2 control-label">Bank Account Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('bankAccount')) error @endif" name="bankAccount" id="bankAccount" placeholder="Bank Account Number"  value="{{$customer->bankAccount}}">
							@if($errors->has('bankAccount'))
								<label id="label-error" class="error" for="bankAccount">{{$errors->first('bankAccount')}}</label>
							@endif					
	            		</div>
                            </div>
                        
                            <div class="form-group">
	            		<label class="col-sm-2 control-label">Branch</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('branch')) error @endif" name="branch" id="branch" placeholder="Branch"  value="{{$customer->branch}}">
							@if($errors->has('branch'))
								<label id="label-error" class="error" for="branch">{{$errors->first('branch')}}</label>
							@endif					
	            		</div>
                            </div>
                            <div class="form-group">
	            		<label class="col-sm-2 control-label">Credit Limit</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('credit')) error @endif" name="credit" id="credit" placeholder="credit"  value="{{$customer->creditLimit}}">
							@if($errors->has('credit'))
								<label id="label-error" class="error" for="credit">{{$errors->first('credit')}}</label>
							@endif					
	            		</div>
                            </div>
                        <hr>
                        
                        
                        
                <div class="panel-heading border">
                    <strong>Details of Contact person</strong>                 
		</div>    

		<div class="panel-body">               
                    @foreach ($companyContact as $contact)
                       
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control" name="c_name[]" placeholder="Contact Name" value="{{$contact->name}}">
				</div>
	                </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Department</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control" name="c_department[]" placeholder="Contact Department" value="{{$contact->department}}">
		          	</div>
	                </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Telephone Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control" name="c_number[]" placeholder="Contact Number" value="{{$contact->contactNo}}">
			        </div>
	                </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Email</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control" name="c_email[]" placeholder="Contact Email" value="{{$contact->email}}">
				</div>
	                </div>	
                        
                    <hr>
                    @endforeach                        
            	</form>
          	</div>
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
            
            var contact_person =document.getElementById("contact_person").value;                            
            if(contact_person ==''){
                sweetAlert(' Error','Please enter contact person.',3);
                return false;
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
