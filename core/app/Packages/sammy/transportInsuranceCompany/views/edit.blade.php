@extends('layouts.sammy_new.master') @section('title','Edit Insurance Companies')
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
    	<a href="{{{url('transportInsuranceCompany/list')}}}">Insurance Company</a>
  	</li>
  	<li class="active">Edit Insurance Company</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Edit Insurance Company</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}          		
		        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('name')) error @endif" name="name" id="name" placeholder="Name" required value="{{$transportCompany->insurance_company_name}}">
							@if($errors->has('name'))
								<label id="label-error" class="error" for="name">{{$errors->first('name')}}</label>
							@endif
	            		</div>
	                </div>
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Address</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('address')) error @endif" name="address" id="address" placeholder="Address" required value="{{$transportCompany->address}}">
							@if($errors->has('address'))
								<label id="label-error" class="error" for="address">{{$errors->first('address')}}</label>
							@endif
	            		</div>
	                </div>          			
                        
		          
                        <div class="form-group">
	            		<label class="col-sm-2 control-label required">Telephone Numbers</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('telephone_numbers')) error @endif" name="telephone_numbers" id="telephone_numbers" placeholder="Telephone Numbers" required value="{{$transportCompany->contact_details}}">
							@if($errors->has('telephone_numbers'))
								<label id="label-error" class="error" for="telephone_numbers">{{$errors->first('telephone_numbers')}}</label>
							@endif
	            		</div>
	                </div> 
					
							<div class="panel-heading border">
						<strong>Details of Contact person</strong>
					</div>    

		<div class="panel-body">               
                    @foreach ($companyContact as $contact)
                       
                        <div class="form-group">
	            		<label class="col-sm-2 control-label">Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_name[]" placeholder="Contact Name" value="{{$contact->name}}">
				</div>
	                </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Department</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_department[]" placeholder="Contact Department" value="{{$contact->department}}">
		          	</div>
	                </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Telephone Number</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_number[]" placeholder="Contact Number" value="{{$contact->contactNo}}">
			        </div>
	                </div>
					
			<div class="form-group">
	            		<label class="col-sm-2 control-label">Email</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control" name="c_email[]" placeholder="Contact Email" value="{{$contact->email}}">
				</div>
	                </div>	
                        
                    <hr>
                    @endforeach
                    
                 
                    
                    <span id="responce"></span>		
                        <div class="pull-left">
                                <button type="button" onclick="addInput()" class="btn btn-primary"><i class="fa fa-arrow-circle-down"></i> Add new contact</button>
                        </div>
                        
	                <div class="pull-right">
                            <button type="submit" id="add" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Update</button>
	                </div>
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
            var address =document.getElementById("address").value;                            
            if(address ==''){
                sweetAlert(' Error','Please enter address.',3);
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
            
            var telephone_numbers_c =document.getElementById("c_number").value;                            
            if(telephone_numbers_c ==''){
                sweetAlert(' Error','Please enter contact telephone numbers',3);
                return false;
            } 
            else{                    
                if(!(telephone_numbers_c.length == 10)){   
                    sweetAlert(' Error','Please enter valid contact telephone numbers',3);
                    return false;                   
                }
            }

            var c_email =document.getElementById("c_email").value;                            
            if(c_email ==''){
                sweetAlert(' Error','Please enter contact email',3);
                return false;
            } 
            else{                
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test(c_email) == false) 
                {                    
                    sweetAlert(' Error','Please enter valid contact email.',3);
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

