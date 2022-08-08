@extends('layouts.sammy_new.master') @section('title','View Company')
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
    	<a href="{{{url('transportCompany/list')}}}">Company</a>
  	</li>
  	<li class="active">View Company</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>View Company</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
          		<div class="form-group">
	            		<label class="col-sm-2 control-label required">Code</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('code')) error @endif" name="code" placeholder="Code" required value="{{$transportCompany->company_code}}">
	            			@if($errors->has('code'))
	            				<label id="label-error" class="error" for="code">{{$errors->first('code')}}</label>
	            			@endif
	            		</div>
	                </div>
		        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('name')) error @endif" name="name" id="name" placeholder="Name" required value="{{$transportCompany->company_name}}">
							@if($errors->has('name'))
								<label id="label-error" class="error" for="name">{{$errors->first('name')}}</label>
							@endif
	            		</div>
	                </div>
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Address</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('address')) error @endif" name="address" id="address" placeholder="Address" required value="{{$transportCompany->company_address}}">
							@if($errors->has('address'))
								<label id="label-error" class="error" for="address">{{$errors->first('address')}}</label>
							@endif
	            		</div>
	                </div>
          			
                         <div class="form-group">
	            		<label class="col-sm-2 control-label required">Register Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('register_number')) error @endif" name="register_number" id="register_number" placeholder="Register Number" required value="{{$transportCompany->register_number}}">
							@if($errors->has('register_number'))
								<label id="label-error" class="error" for="register_number">{{$errors->first('register_number')}}</label>
							@endif
	            		</div>
	                </div>
                        
                         <div class="form-group">
	            		<label class="col-sm-2 control-label required">Vat Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('vat_number')) error @endif" name="vat_number" id="vat_number" placeholder="Vat Number" required value="{{$transportCompany->vat_number}}">
							@if($errors->has('vat_number'))
								<label id="label-error" class="error" for="vat_number">{{$errors->first('vat_number')}}</label>
							@endif
	            		</div>
	                </div>
                        
						
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">ETF Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('etf_number')) error @endif" name="etf_number" id="etf_number" placeholder="ETF Number" required value="{{$transportCompany->etf_number}}">
							@if($errors->has('etf_number'))
								<label id="label-error" class="error" for="etf_number">{{$errors->first('etf_number')}}</label>
							@endif
	            		</div>
	                </div>
			<div class="form-group">
	            		<label class="col-sm-2 control-label required">EPF Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('epf_number')) error @endif" name="epf_number" id="epf_number" placeholder="EPF Number" required value="{{$transportCompany->epf_number}}">
							@if($errors->has('epf_number'))
								<label id="label-error" class="error" for="epf_number">{{$errors->first(epf_number)}}</label>
							@endif
	            		</div>
	                </div>	
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">BR Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('br_number')) error @endif" name="br_number" id="br_number" placeholder="BR Number" required value="{{$transportCompany->br_number}}">
							@if($errors->has('br_number'))
								<label id="label-error" class="error" for="br_number">{{$errors->first(br_number)}}</label>
							@endif
	            		</div>
	                </div>
                        
                         <div class="form-group">
	            		<label class="col-sm-2 control-label required">Short Code</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('short_code')) error @endif" name="short_code" id="short_code" placeholder="Short Code" required value="{{$transportCompany->short_code}}">
							@if($errors->has('short_code'))
								<label id="label-error" class="error" for="short_code">{{$errors->first('short_code')}}</label>
							@endif
	            		</div>
	                </div>
                        
                         <div class="form-group">
	            		<label class="col-sm-2 control-label required">Start Date</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('start_date')) error @endif" id="start_date" id="start_date" name="start_date" placeholder="Start Date" required value="{{$transportCompany->start_date}}">
							@if($errors->has('start_date'))
								<label id="label-error" class="error" for="start_date">{{$errors->first('start_date')}}</label>
							@endif
	            		</div>
	                </div>
		          
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Telephone Numbers</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('telephone_numbers')) error @endif" name="telephone_numbers" id="telephone_numbers" placeholder="Telephone Numbers" required value="{{$transportCompany->telephone_numbers}}">
							@if($errors->has('telephone_numbers'))
								<label id="label-error" class="error" for="telephone_numbers">{{$errors->first('telephone_numbers')}}</label>
							@endif
	            		</div>
	                </div>
                        
                         <div class="form-group">
	            		<label class="col-sm-2 control-label required">Fax Numbers</label>
	            		<div class="col-sm-10">
                                    <input type="text" readonly class="form-control @if($errors->has('fax_numbers')) error @endif" name="fax_numbers" id="fax_numbers" placeholder="Fax Numbers" required value="{{$transportCompany->fax_numbers}}">
							@if($errors->has('fax_numbers'))
								<label id="label-error" class="error" for="fax_numbers">{{$errors->first('fax_numbers')}}</label>
							@endif
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Email</label>
	            		<div class="col-sm-10">
                                    <input type="email" readonly class="form-control @if($errors->has('email')) error @endif" name="email" placeholder="Email" id="Email" required value="{{$transportCompany->email}}">
							@if($errors->has('email'))
								<label id="label-error" class="error" for="email">{{$errors->first('email')}}</label>
							@endif
	            		</div>
	                </div>
                        
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">web sites</label>
	            		<div class="col-sm-10">
						<input type="text" readonly class="form-control @if($errors->has('websites')) error @endif" name="websites" placeholder="Web Sites" required value="{{$transportCompany->websites}}">
							@if($errors->has('websites'))
								<label id="label-error" class="error" for="websites">{{$errors->first('websites')}}</label>
							@endif
	            		</div>
	                </div>
                        @if($transportCompany->brcopy !='')   
                            <div class="form-group">      
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">      
                                        <a class="" href="../../companyAttachments/{{$transportCompany->company_code }}/{{$transportCompany->brcopy }}"><i class="fa fa-download"></i> BR Copy Download</a>	
                                    </div>
                            </div> 
                        @endif                        
                        
                       
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
            var name =document.getElementById("name").value;                            
            if(name ==''){
                sweetAlert(' Error','Please enter name.',3);
                return false;
            } 
            var address =document.getElementById("address").value;                            
            if(address ==''){
                sweetAlert(' Error','Please enter address.',3);
                return false;
            } 
            var register_number =document.getElementById("register_number").value;                            
            if(register_number ==''){
                sweetAlert(' Error','Please enter register number.',3);
                return false;
            } 
            var vat_number =document.getElementById("vat_number").value;                            
            if(vat_number ==''){
                sweetAlert(' Error','Please enter vat number.',3);
                return false;
            } 
			
			
			var etf_number =document.getElementById("etf_number").value;                            
            if(etf_number ==''){
                sweetAlert(' Error','Please enter etf number.',3);
                return false;
            } 
			
            var epf_number =document.getElementById("epf_number").value;                            
            if(epf_number ==''){
                sweetAlert(' Error','Please enter epf number.',3);
                return false;
            } 
            
            var br_number =document.getElementById("br_number").value;                            
            if(br_number ==''){
                sweetAlert(' Error','Please enter BR number.',3);
                return false;
            } 
			
            var short_code =document.getElementById("short_code").value;                            
            if(short_code ==''){
                sweetAlert(' Error','Please enter short code.',3);
                return false;
            } 
            var start_date =document.getElementById("start_date").value;                            
            if(start_date ==''){
                sweetAlert(' Error','Please enter start date.',3);
                return false;
            } 
            var telephone_numbers =document.getElementById("telephone_numbers").value;                            
            if(telephone_numbers ==''){
                sweetAlert(' Error','Please enter telephone numbers',3);
                return false;
            } 
            else{                    
                if(!(telephone_numbers.length == 10)){   
                    sweetAlert(' Error','Please enter valid telephone numbers',3);
                    return false;                   
                }
            }
            var fax_numbers =document.getElementById("fax_numbers").value;                            
            if(fax_numbers ==''){
                sweetAlert(' Error','Please enter fax numbers',3);
                return false;
            }   
            else{
                if(!(fax_numbers.length == 10)){   
                    sweetAlert(' Error','Please enter valid fax numbers',3);
                    return false;                   
                }
            }
            var email =document.getElementById("email").value;                            
            if(email ==''){
                sweetAlert(' Error','Please enter email',3);
                return false;
            } 
            else{                
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test(email) == false) 
                {                    
                    sweetAlert(' Error','Please enter valid email.',3);
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

