@extends('layouts.sammy_new.master') @section('title','View Employee')
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
    	<a href="{{{url('transportEmployee/list')}}}">Employee</a>
  	</li>
  	<li class="active">View Employee</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>View Employee</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post">
          		{!!Form::token()!!}
<!--				<div class="form-group">
	            		<label class="col-sm-2 control-label required">Employee Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('employee_number')) error @endif" name="employee_number" id="employee_number" placeholder="Employee Number" required value="{{$transportEmployee->employee_no}}">
							@if($errors->has('employee_number'))
								<label id="label-error" class="error" for="employee_number">{{$errors->first('employee_number')}}</label>
							@endif
	            		</div>
	                </div>-->
                        <div class="form-group">
	            		
	            		<div class="col-sm-10">
                                    <img src="../../employeee/{{$transportEmployee->nic}}/{{$transportEmployee->image}}" style=" margin-left: 90px;"  class="img-thumbnail" width="200">
	            		</div>
	                </div>
          		<div class="form-group">
	            		<label class="col-sm-2 control-label required">Employee Code</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('code')) error @endif" name="code" placeholder="Code" required value="{{$transportEmployee->employee_code}}">
	            			@if($errors->has('code'))
	            				<label id="label-error" class="error" for="code">{{$errors->first('code')}}</label>
	            			@endif
	            		</div>
	                </div>
		        <div class="form-group">
	            		<label class="col-sm-2 control-label required">First Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('first_name')) error @endif" name="first_name" id="first_name" placeholder="First Name" required value="{{$transportEmployee->first_name}}">
							@if($errors->has('first_name'))
								<label id="label-error" class="error" for="first_name">{{$errors->first('first_name')}}</label>
							@endif
	            		</div>
	                </div>
                        
                       <div class="form-group">
	            		<label class="col-sm-2 control-label required">Last Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('last_name')) error @endif" name="last_name" id="last_name" placeholder="Last Name" required value="{{$transportEmployee->last_name}}">
							@if($errors->has('last_name'))
								<label id="label-error" class="error" for="last_name">{{$errors->first('last_name')}}</label>
							@endif
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Full Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('full_name')) error @endif" name="full_name" id="full_name" placeholder="Full Name" required value="{{$transportEmployee->full_name}}">
							@if($errors->has('full_name'))
								<label id="label-error" class="error" for="full_name">{{$errors->first('full_name')}}</label>
							@endif
	            		</div>
	                </div>
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Nick Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('nickName')) error @endif" name="nickName" id="nickName" placeholder="Nick Name"  value="{{$transportEmployee->nickName}}">
							@if($errors->has('nickName'))
								<label id="label-error" class="error" for="nickName">{{$errors->first('nickName')}}</label>
							@endif
	            		</div>
	                </div>
                        <div class="form-group">
						<label class="col-sm-2 control-label required">Designation</label>
						<div class="col-sm-10">
							@if($errors->has('company'))
								{!! Form::select('designation',$designation, $transportEmployee->designation,['placeholder' => 'Select Designation','class'=>'chosen error','style'=>'width:100%;','disabled' => true,'data-placeholder'=>'Set After','id'=>'designation']) !!}
								<label id="supervisor-error" class="error" for="company">{{$errors->first('company')}}</label>
							@else
								{!! Form::select('designation',$designation, $transportEmployee->designation,['placeholder' => 'Select Designation','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'designation']) !!}
							@endif
							
						</div>
			</div>
                        <div class="form-group">
                                                <label class="col-sm-2 control-label">Start Date</label>
                                                <div class="col-sm-10">
                                                    <input type="text" readonly id="startDate" class="form-control @if($errors->has('startDate')) error @endif" name="startDate" placeholder="Start Date" value="{{date('Y-m-d')}}">
                                                        @if($errors->has('startDate'))
                                                                <label id="label-error" class="error" for="startDate">{{$errors->first('startDate')}}</label>
                                                        @endif      
                                                </div>
                        </div>
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">NIC</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('nic')) error @endif" name="nic" id="nic" placeholder="NIC" required value="{{$transportEmployee->nic}}">
							@if($errors->has('nic'))
								<label id="label-error" class="error" for="nic">{{$errors->first('nic')}}</label>
							@endif
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Passport</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('passport')) error @endif" name="passport" id="passport" placeholder="Passport" value="{{$transportEmployee->passport}}">
							@if($errors->has('passport'))
								<label id="label-error" class="error" for="passport">{{$errors->first('passport')}}</label>
							@endif
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">EPF Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('epf_number')) error @endif" name="epf_number" id="epf_number" placeholder="EPF Number" required value="{{$transportEmployee->epf_number}}">
							@if($errors->has('epf_number'))
								<label id="label-error" class="error" for="epf_number">{{$errors->first('epf_number')}}</label>
							@endif
	            		</div>
	                </div>
                        
                        
                        
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Address</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('address')) error @endif" name="address" id="address" placeholder="Address" required value="{{$transportEmployee->address}}">
							@if($errors->has('address'))
								<label id="label-error" class="error" for="address">{{$errors->first('address')}}</label>
							@endif
	            		</div>
	                </div>          			
                       
                        <div class="form-group">
	            		<label class="col-sm-2 control-label ">Street</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('street')) error @endif" name="street" id="street" placeholder="street" value="{{$transportEmployee->street}}">
							@if($errors->has('street'))
								<label id="label-error" class="error" for="street">{{$errors->first('street')}}</label>
							@endif
	            		</div>
	                </div> 
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label ">City</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('city')) error @endif" name="city" id="city" placeholder="City" value="{{$transportEmployee->city}}">
							@if($errors->has('city'))
								<label id="label-error" class="error" for="city">{{$errors->first('city')}}</label>
							@endif
	            		</div>
	                </div> 
		          
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Telephone Numbers</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('telephone_numbers')) error @endif" name="telephone_numbers" id="telephone_numbers" placeholder="Telephone Numbers" required value="{{$transportEmployee->contact_mobile}}">
							@if($errors->has('telephone_numbers'))
								<label id="label-error" class="error" for="telephone_numbers">{{$errors->first('telephone_numbers')}}</label>
							@endif
	            		</div>
	                </div>
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Tracking Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('t_telephone_numbers')) error @endif" name="t_telephone_numbers" id="t_telephone_numbers" placeholder="Tracking Number"  value="{{$transportEmployee->t_telephone_numbers}}">
							@if($errors->has('t_telephone_numbers'))
								<label id="label-error" class="error" for="t_telephone_numbers">{{$errors->first('t_telephone_numbers')}}</label>
							@endif
	            		</div>
	                </div>
                        
                         <div class="form-group">
	            		<label class="col-sm-2 control-label">Emergency Inform Numbers</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('emergency_numbers')) error @endif" name="emergency_numbers" id="emergency_numbers" placeholder="Emergency Inform Numbers"  value="{{$transportEmployee->emergency_contact}}">
							@if($errors->has('emergency_numbers'))
								<label id="label-error" class="error" for="emergency_numbers">{{$errors->first('emergency_numbers')}}</label>
							@endif
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label ">Emergency inform person</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('eip')) error @endif" name="eip" id="eip" placeholder="Emergency inform person" value="{{$transportEmployee->eip}}">
							@if($errors->has('eip'))
								<label id="label-error" class="error" for="city">{{$errors->first('eip')}}</label>
							@endif
	            		</div>
	                </div> 
                        
                        
                        <hr>
                        
                            <div class="form-group">
	            		<label class="col-sm-2 control-label">Bank Account Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('bankAccount')) error @endif" name="bankAccount" id="bankAccount" placeholder="Bank Account Number"  value="{{$transportEmployee->bankAccount}}">
							@if($errors->has('bankAccount'))
								<label id="label-error" class="error" for="bankAccount">{{$errors->first('bankAccount')}}</label>
							@endif					
	            		</div>
                            </div>
                        
                            <div class="form-group">
	            		<label class="col-sm-2 control-label">Bank Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('bankName')) error @endif" name="bankName" id="bankName" placeholder="Bank Name"  value="{{$transportEmployee->bankName}}">
							@if($errors->has('bankName'))
								<label id="label-error" class="error" for="bankName">{{$errors->first('bankName')}}</label>
							@endif					
	            		</div>
                            </div>
                        
                            <div class="form-group">
	            		<label class="col-sm-2 control-label">Branch</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('branch')) error @endif" name="branch" id="branch" placeholder="Branch"  value="{{$transportEmployee->branch}}">
							@if($errors->has('branch'))
								<label id="label-error" class="error" for="branch">{{$errors->first('branch')}}</label>
							@endif					
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
        $('#add').click(function(e){               
         
            var first_name =document.getElementById("first_name").value;                            
            if(first_name ==''){
                sweetAlert(' Error','Please enter first name.',3);
                return false;
            } 
            var last_name =document.getElementById("last_name").value;                            
            if(last_name ==''){
                sweetAlert(' Error','Please enter last name.',3);
                return false;
            } 
            var full_name =document.getElementById("full_name").value;                            
            if(full_name ==''){
                sweetAlert(' Error','Please enter full name.',3);
                return false;
            } 
            var nic =document.getElementById("nic").value;                            
            if(nic ==''){
                sweetAlert(' Error','Please enter NIC.',3);
                return false;
            }   
            else{
                  if (nic.length != 10 && nic.length != 12) {
                        sweetAlert(' Error','Please provide nic number 10 or 12 character format.',3);
                        return false;
                    } else if (nic.length == 10) {
                        var value = '';

                        if (nic.charAt(9) == 'V') {
                            value = nic.substring(0, 9);
                        } else if (nic.charAt(9) == 'X') {
                            value = nic.substring(0, 9);
                        } else {
                            sweetAlert(' Error','Please enter X or Y character end of the number.',3);
                            return false;
                        }

                        if (isNaN(value)) {
                            sweetAlert(' Error','First nine characters should be numbers.',3);
                            return false;
                        }

                        if (nic.charAt(9) != 'V' && nic.charAt(9) != 'X') {
                            sweetAlert(' Error','Please enter X or Y character end of the number.',3);
                            return false;
                        }
                    } else if (nic.length == 12) {
                        if (isNaN(nic)) {
                            sweetAlert(' Error','Please enter numbers for 12 digits NIC.',3);
                            return false;
                        }
                    }
            }
         
            var epf_number =document.getElementById("epf_number").value;                            
            if(epf_number ==''){
                sweetAlert(' Error','Please enter EPF number.',3);
                return false;
            }
            var address =document.getElementById("address").value;                            
            if(address ==''){
                sweetAlert(' Error','Please enter address.',3);
                return false;
            }
            var telephone_numbers =document.getElementById("telephone_numbers").value;                            
            if(telephone_numbers ==''){
                sweetAlert(' Error','Please enter telephone number.',3);
                return false;
            }
            else{                    
                if(!(telephone_numbers.length == 10)){   
                    sweetAlert(' Error','Please enter valid telephone numbers',3);
                    return false;                   
                }
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

