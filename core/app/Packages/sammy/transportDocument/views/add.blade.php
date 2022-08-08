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
    	<a href="{{{url('transportDocument/list')}}}">Document Layout</a>
  	</li>
  	<li class="active">Add Document Layout</li>
</ol>
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-bordered">
      		<div class="panel-heading border">
        		<strong>Add Document Layout</strong>
      		</div>
          	<div class="panel-body">
          		<form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
          		{!!Form::token()!!}	
					<div class="form-group">
	            		<label class="col-sm-2 control-label">Document Type</label>	 
						<div class="col-sm-10">
							@if($errors->has('documentType'))
								{!! Form::select('documentType', $entekDocument, Input::old('documentType'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'documentType']) !!}
								<label id="supervisor-error" class="error" for="ownerSection">{{$errors->first('ownerSection')}}</label>
							@else
								{!! Form::select('documentType', $entekDocument, Input::old('documentType'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'documentType']) !!}
							@endif
						</div>
	                </div>
					
					<div class="form-group">
	            		<label class="col-sm-2 control-label required">Document Name</label>
	            		<div class="col-sm-10">
                                    <input type="text" class="form-control @if($errors->has('document_name')) error @endif" name="document_name" id="document_name" placeholder="Document Name" required value="{{Input::old('document_name')}}">
							@if($errors->has('document_name'))
								<label id="label-error" class="error" for="document_name">{{$errors->first('document_name')}}</label>
							@endif
	            		</div>
	                </div>
					
					 <div class="form-group">	
		                 <label class="col-sm-2 "></label>	                	
		            		<div  class="col-sm-10 " >			            		
					              		<?php $i=1;foreach ($tagList as $key => $value): ?>						             
						              		{{$value->name}},						              
					              		<?php endforeach ?>					            		            			
		            		</div>
		                </div>
					
					 <div class="form-group">
					 <label class="col-sm-2 control-label required">Document Layout</label> 
		            		<div  class="col-sm-12">
		            		<textarea class="ckeditor" id name="editor1">{{Input::old('editor1')}}</textarea>
		            			
		            		</div>
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
<script src="{{asset('assets/sammy_new/vendor/ckeditor2/ckeditor.js')}}"></script>
<script src="{{asset('assets/sammy_new/vendor/ckeditor2/samples/js/sample.js')}}"></script>
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
