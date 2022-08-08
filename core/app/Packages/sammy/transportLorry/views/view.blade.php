@extends('layouts.sammy_new.master') @section('title','View Lorry')
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
  	<li class="active">View Lorry</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>View Lorry</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}
					<div class="form-group">
						<label class="col-sm-2 control-label required">Owner Section</label>
						<div class="col-sm-10">
							@if($errors->has('ownerSection'))
								{!! Form::select('ownerSection', array(null=>'Select Value','1' => 'Group Company', '0' => 'Suppliers'), Input::old('ownerSection'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'ownerSection','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="ownerSection">{{$errors->first('ownerSection')}}</label>
							@else
								{!! Form::select('ownerSection', array(null=>'Select Value','1' => 'Group Company', '0' => 'Suppliers'), $lorry[0]->owner_section,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'ownerSection','disabled' => true]) !!}
							@endif

						</div>
					</div>
                                        <div class="form-group"  id="companydiv">
						<label class="col-sm-2 control-label required">Company</label>
						<div class="col-sm-10">
							@if($errors->has('company'))
								{!! Form::select('company', $company, Input::old('company'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'company','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="company">{{$errors->first('company')}}</label>
							@else
								{!! Form::select('company', $company, $lorry[0]->owner_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'company','disabled' => true]) !!}
							@endif

						</div>
					</div>
                                    <div id="ownerdiv">
                                        <div class="form-group">
						<label class="col-sm-2 control-label">Owner</label>
						<div class="col-sm-10">
                                                    <input type="text" class="form-control @if($errors->has('owner')) error @endif" id="owner" name="owner" placeholder="Owner" value="{{ $lorry[0]->owner_name}}" readonly="">
                                                    @if($errors->has('owner'))
                                                            <label id="label-error" class="error" for="owner">{{$errors->first('owner')}}</label>
                                                    @endif

						</div>
					</div>
                        
                        
                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Owner Address</label>
						<div class="col-sm-10">
                                                    <input type="text" class="form-control @if($errors->has('ownerAddress')) error @endif" id="ownerAddress" name="ownerAddress" placeholder="Owner Address" value="{{$lorry[0]->ownerAddress}}">
                                                    @if($errors->has('ownerAddress'))
                                                            <label id="label-error" class="error" for="ownerAddress">{{$errors->first('ownerAddress')}}</label>
                                                    @endif

						</div>
                        
                                        </div>
                                     </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label required">Vehicle No</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @if($errors->has('licensePlate')) error @endif" id="licensePlate" name="licensePlate" placeholder="License Plate" required value="{{$lorry[0]->licence_plate}}" readonly="">
                                                    @if($errors->has('licensePlate'))
                                                            <label id="label-error" class="error" for="code">{{$errors->first('licensePlate')}}</label>
                                                    @endif
                                            </div>
                                        </div>
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Maker</label>
						<div class="col-sm-10">
							@if($errors->has('maker'))
								{!! Form::select('maker', $maker, Input::old('maker'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'maker','disabled' => true]) !!}
								<label id="supervisor-error" class="error" for="maker">{{$errors->first('maker')}}</label>
							@else
								{!! Form::select('maker', $maker, $lorry[0]->maker_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'maker','disabled' => true]) !!}
							@endif

						</div>
					</div>
                        
                                        <div class="form-group">
						<label class="col-sm-2 control-label required">Model</label>
						<div class="col-sm-10">						
                                                    <select class="form-control" name="model" id="model" required disabled>
                                                        <option>Select Model</option>
                                                    </select>                                                   
						</div>
                                              
					</div>
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label required">Carriage Height</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('height')) error @endif" id="height" name="height" placeholder="Carriage Height" required value="{{$lorry[0]->height}}" readonly="">
                                                    @if($errors->has('height'))
                                                        <label id="label-error" class="error" for="height">{{$errors->first('height')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In meters (m).</label>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label required">Carriage Width</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('Width')) error @endif"  id="Width" name="Width" placeholder="Carriage Width" required value="{{$lorry[0]->width}}" readonly="">
                                                    @if($errors->has('Width'))
                                                        <label id="label-error" class="error" for="Width">{{$errors->first('Width')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In meters (m).</label>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label required">Carriage Length</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('length')) error @endif"  id="length" name="length" placeholder="Carriage Length" required value="{{$lorry[0]->length}}" readonly="">
                                                    @if($errors->has('length'))
                                                        <label id="label-error" class="error" for="length">{{$errors->first('length')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In meters (m).</label>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label required">Max Pay Load</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('maxload')) error @endif"  id="maxload" name="maxload" placeholder="Max Pay Load" required value="{{$lorry[0]->max_pay_load}}" readonly="">
                                                    @if($errors->has('maxload'))
                                                        <label id="label-error" class="error" for="maxload">{{$errors->first('maxload')}}</label>
                                                    @endif
                                                    <label id="label-error" class="error" for="">In kilograms (kg).</label>
                                        </div>
                                        </div>
                        
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label required">Capacity (TON)</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('ton')) error @endif" name="ton" id="ton" placeholder="TON" required value="{{$lorry[0]->ton_amount}}">
                                                    @if($errors->has('ton'))
                                                        <label id="label-error" class="error" for="ton">{{$errors->first('ton')}}</label>
                                                    @endif
                                                  
                                        </div>
                                        </div>
                                        
                        
                                        <div class="form-group">
                                        <label class="col-sm-2 control-label required">Capacity (CBM)</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @if($errors->has('cbm')) error @endif" name="cbm" id="cbm" placeholder="CBM" required value="{{$lorry[0]->cbm_amount}}">
                                                    @if($errors->has('cbm'))
                                                        <label id="label-error" class="error" for="cbm">{{$errors->first('cbm')}}</label>
                                                    @endif
                                        </div>
                                        </div>
                        
                        
                                        <div id="companyLorryDiv">
                                             <hr>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">License Renew Date</label>
                                                            <div class="col-sm-10">                                                												
                                                                    <input type="text" class="form-control @if($errors->has('licensedate')) error @endif" name="licensedate" id="licensedate" placeholder="License Renew Date" value="{{$lorry[0]->licenseRenewDate}}" >
                                                                        @if($errors->has('licensedate'))
                                                                            <label id="label-error" class="error" for="label">{{$errors->first('licensedate')}}</label>
                                                                        @endif														

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <label class="col-sm-2 control-label">License Province</label>
                                                                <div class="col-sm-10">
                                                                        @if($errors->has('licenseprovince'))
                                                                                {!! Form::select('licenseprovince', $licenseprovince, $lorry[0]->licenseProvince,['placeholder' => 'Select license province','class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                                                                <label id="supervisor-error" class="error" for="licenseprovince">{{$errors->first('licenseprovince')}}</label>
                                                                        @else
                                                                                {!! Form::select('licenseprovince', $licenseprovince, $lorry[0]->licenseProvince,['placeholder' => 'Select license province','class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                                                        @endif

                                                                </div>
                                                        </div>
                                    
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">License Renew Amount</label>
                                                            <div class="col-sm-10">                                                												
                                                                    <input type="text" class="form-control @if($errors->has('licenseAmount')) error @endif" name="licenseAmount" id="licenseAmount" placeholder="License Payment Amount" value="{{$lorry[0]->licensePaymentAmount}}" >
                                                                        @if($errors->has('licenseAmount'))
                                                                            <label id="label-error" class="error" for="label">{{$errors->first('licenseAmount')}}</label>
                                                                        @endif														

                                                            </div>
                                                        </div>
                                            
                                            
                                            <hr>
                                                        <div class="form-group">
                                                                <label class="col-sm-2 control-label required">Insured Company</label>
                                                                <div class="col-sm-10">
                                                                        @if($errors->has('insuranceCompanies'))
                                                                                {!! Form::select('insuranceCompanies', $insuranceCompanies, Input::old('insuranceCompanies'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','disabled' => true]) !!}
                                                                                <label id="supervisor-error" class="error" for="maker">{{$errors->first('maker')}}</label>
                                                                        @else
                                                                                {!! Form::select('insuranceCompanies', $insuranceCompanies, $lorry[0]->insurance_company_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','disabled' => true]) !!}
                                                                        @endif

                                                                </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label required">Insurance Renew Date</label>
                                                            <div class="col-sm-10">                                                												
                                                                <input type="text" class="form-control @if($errors->has('insurancedate')) error @endif" name="insurancedate" id="insurancedate" placeholder="Insurance Renew Date" value="{{$lorry[0]->insurance_renew_date}}" readonly="" >
                                                                        @if($errors->has('insurancedate'))
                                                                            <label id="label-error" class="error" for="label">{{$errors->first('insurancedate')}}</label>
                                                                        @endif														

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label required">Insurance Policy No</label>
                                                            <div class="col-sm-10">                                                												
                                                                <input type="text" class="form-control @if($errors->has('insurancePolicy')) error @endif" name="insurancePolicy" placeholder="Insurance Policy No" value="{{$lorry[0]->insurance_policy_number}}" readonly="">
                                                                        @if($errors->has('insurancePolicy'))
                                                                            <label id="label-error" class="error" for="label">{{$errors->first('insurancePolicy')}}</label>
                                                                        @endif														

                                                            </div>
                                                        </div>
                                                    <hr>
                                                        <div class="form-group">
                                                                <label class="col-sm-2 control-label required">Emission Company</label>
                                                                <div class="col-sm-10">
                                                                        @if($errors->has('emissionCompanies'))
                                                                                {!! Form::select('emissionCompanies', $emissionCompanies, Input::old('emissionCompanies'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','disabled' => true]) !!}
                                                                                <label id="supervisor-error" class="error" for="maker">{{$errors->first('maker')}}</label>
                                                                        @else
                                                                                {!! Form::select('emissionCompanies', $emissionCompanies, $lorry[0]->emission_company_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','disabled' => true]) !!}
                                                                        @endif

                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label required">Emission Renew Date</label>
                                                            <div class="col-sm-10">                                                												
                                                                <input type="text" class="form-control @if($errors->has('insurancedate')) error @endif" name="Emissiondate" id="Emissiondate" placeholder="Emission Renew Date" value="{{$lorry[0]->emission_renew_date}}" readonly="">
                                                                        @if($errors->has('Emissiondate'))
                                                                            <label id="label-error" class="error" for="label">{{$errors->first('Emissiondate')}}</label>
                                                                        @endif														

                                                            </div>
                                                        </div>
                                                    <hr>
                                                        <div class="form-group">
                                                                <label class="col-sm-2 control-label required">Leasing Company</label>
                                                                <div class="col-sm-10">
                                                                        @if($errors->has('maker'))
                                                                                {!! Form::select('leasingCompanies', $leasingCompanies, Input::old('leasingCompanies'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','disabled' => true]) !!}
                                                                                <label id="supervisor-error" class="error" for="maker">{{$errors->first('maker')}}</label>
                                                                        @else
                                                                                {!! Form::select('leasingCompanies', $leasingCompanies, $lorry[0]->leasing_company_id,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','disabled' => true]) !!}
                                                                        @endif

                                                                </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label required">Leasing Amount</label>
                                                            <div class="col-sm-10">                                                												
                                                                <input type="text" class="form-control @if($errors->has('leasingAmount')) error @endif" name="leasingAmount" placeholder="Leasing Amount" value="{{$lorry[0]->leasing_amount}}" readonly="" >
                                                                        @if($errors->has('leasingAmount'))
                                                                            <label id="label-error" class="error" for="label">{{$errors->first('leasingAmount')}}</label>
                                                                        @endif														

                                                            </div>
                                                        </div>
                                                    <hr>
                                        </div>
                                        @if($lorry[0]->book !='')   
                                            <div class="form-group">      
                                                    <label class="col-sm-2 control-label required">Vehicle Book</label>
                                                    <div class="col-sm-10">      
                                                        <a class="" href="../../lorryAttachments/{{$lorry[0]->licence_plate }}/{{$lorry[0]->book }}">
                                                            <img src="../../lorryAttachments/{{$lorry[0]->licence_plate }}/{{$lorry[0]->book }}" height="auto" width="800">
                                                        </a>	
                                                    </div>
                                            </div> 
                                        @endif
                                        
                                         @if($lorry[0]->valuation !='')   
                                            <div class="form-group">      
                                                    <label class="col-sm-2 control-label required">Vehicle Book</label>
                                                    <div class="col-sm-10">      
                                                        <a class="" href="../../lorryValuation/{{$lorry[0]->licence_plate }}/{{$lorry[0]->valuation }}">
                                                            <img src="../../lorryValuation/{{$lorry[0]->licence_plate }}/{{$lorry[0]->valuation }}" height="auto" width="800">
                                                        </a>	
                                                    </div>
                                            </div> 
                                        @endif
                        
                       <div id="ownerBankdiv">
                            <hr>
                            <div class="form-group">                            
                                    <label class="col-sm-2 control-label">Owner's Bank</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control @if($errors->has('ownerBank')) error @endif" id="ownerBank" name="ownerBank" placeholder="Owner's Bank" value="{{$lorry[0]->ownerBank}}">
                                                        @if($errors->has('ownerBank'))
                                                                <label id="label-error" class="error" for="ownerBank">{{$errors->first('ownerBank')}}</label>
                                                        @endif

                                    </div>
                            </div>
                            <div class="form-group">                            
                                    <label class="col-sm-2 control-label">Bank Account Number</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control @if($errors->has('ownerBankAccount')) error @endif" id="ownerBankAccount" name="ownerBankAccount" placeholder="Bank Account Number" value="{{$lorry[0]->ownerBankAccount}}">
                                                        @if($errors->has('ownerBankAccount'))
                                                                <label id="label-error" class="error" for="ownerBankAccount">{{$errors->first('ownerBankAccount')}}</label>
                                                        @endif

                                    </div>
                            </div>
                            <div class="form-group">                            
                                    <label class="col-sm-2 control-label">Branch</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control @if($errors->has('branch')) error @endif" id="branch" name="branch" placeholder="Branch" value="{{$lorry[0]->ownerBankBranch}}">
                                                        @if($errors->has('branch'))
                                                                <label id="label-error" class="error" for="branch">{{$errors->first('branch')}}</label>
                                                        @endif

                                    </div>
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
        $('#update').click(function(e){               
            var y = document.getElementById("ownerSection");
            var re = y.options[y.selectedIndex].value;
            if(re ==''){
                sweetAlert(' Error','Please select owner section.',3);
                return false;
            }   
            
            if(re =='1'){             
                    var c =document.getElementById("company");
                    var ce = c.options[c.selectedIndex].value;                    
                    if(ce =='0'){
                        sweetAlert(' Error','Please select company.',3);
                        return false;
                    }                 
            }
            else{
                var owner =document.getElementById("owner").value;                            
                if(owner ==''){
                        sweetAlert(' Error','Please enter owner.',3);
                        return false;
                }   
            }
            
            var licensePlate =document.getElementById("licensePlate").value;                            
            if(licensePlate ==''){
                sweetAlert(' Error','Please enter license Plate.',3);
                return false;
            }  
            
            var maker =document.getElementById("maker"); 
            var selectMaker = maker.options[maker.selectedIndex].value;  
            if(selectMaker =='0'){
                sweetAlert(' Error','Please select maker.',3);
                return false;
            }  
            
            var model =document.getElementById("model"); 
            var sModel = model.options[model.selectedIndex].value;            
            if(sModel =='0'){
                sweetAlert(' Error','Please select model.',3);
                return false;
            }  
            
            var height =document.getElementById("height").value;                            
            if(height ==''){
                sweetAlert(' Error','Please enter carriage height.',3);
                return false;
            } 
            var Width =document.getElementById("Width").value;                            
            if(Width ==''){
                sweetAlert(' Error','Please enter carriage width.',3);
                return false;
            } 
            var length =document.getElementById("length").value;                            
            if(length ==''){
                sweetAlert(' Error','Please enter carriage length.',3);
                return false;
            } 
            var maxload =document.getElementById("maxload").value;                            
            if(maxload ==''){
                sweetAlert(' Error','Please enter max pay load.',3);
                return false;
            } 
            
        });
</script>
<script type="text/javascript">
	$(document).ready(function(){
         
                   var ownerSection = jQuery('select[name="ownerSection"]').val();                    
                   if(ownerSection==1)
                   {
                        $("#companydiv").show();
                        $("#companyLorryDiv").show();
                        $("#ownerdiv").hide();
                        $("#ownerBankdiv").hide();
                   }
                   else if(ownerSection==0)
                   {
                        $("#companydiv").hide();
                        $("#companyLorryDiv").hide();
                        $("#ownerdiv").show();
                        $("#ownerBankdiv").show();
                   }
             
                
		$('.form-validation').validate();
		$('#permissions').multiSelect();
                $( "#insurancedate" ).datepicker({
                  format: "yyyy-mm-dd", 
                });              
                $( "#Emissiondate" ).datepicker({
                  format: "yyyy-mm-dd",  
                });
                
                
               var makerID = jQuery('select[name="maker"]').val();   
              
                  jQuery.ajax({
                     url : '../json/modellist/' +makerID,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {
                            $('#model').empty();
                            $("#model").append('<option>Select Model</option>');
                            if(res)
                            {
                                $.each(res,function(key,value){
                                    if(value=<?php echo $lorry[0]->model_id?>){
                                        $('#model').append($("<option/>", {
                                           value: value,
                                           text: key,
                                           selected:'true',
                                        }));
                                    }else{
                                        $('#model').append($("<option />", {
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

<script type="text/javascript">
    jQuery(document).ready(function ()
    {
            jQuery('select[name="maker"]').on('change',function(){
               var makerID = jQuery(this).val();
    
               if(makerID)
               {
                  jQuery.ajax({
                     url : 'json/modellist/' +makerID,
                     type : "GET",
                     dataType : "json",
                     success:function(res)
                     {
                            $('#model').empty();
                            $("#model").append('<option>Select Model</option>');
                            if(res)
                            {
                                $.each(res,function(key,value){
                                    $('#model').append($("<option/>", {
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
                 $('#model').empty();
               }
            });
            
            
            jQuery('select[name="ownerSection"]').on('change',function(){
               var ownerSection = jQuery(this).val();   
               if(ownerSection==1)
               {
                    $("#companydiv").show();
                    $("#companyLorryDiv").show();
                    $("#ownerdiv").hide();
               }
               else if(ownerSection==0)
               {
                    $("#companydiv").hide();
                    $("#companyLorryDiv").hide();
                    $("#ownerdiv").show();
               }
            });
            
    });
    </script>

@stop
