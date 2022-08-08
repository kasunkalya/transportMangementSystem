@extends('layouts.sammy_new.master') @section('title','Edit Transport Charging Types')
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
			<a href="{{{url('transportChargin/list')}}}">Transport Charging Types</a>
		</li>
		<li class="active">Edit Transport Charging Types</li>
	</ol>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-bordered">
				<div class="panel-heading border">
					<strong>Edit Transport Charging Types</strong>
				</div>
				<div class="panel-body">
					<form role="form" class="form-horizontal form-validation" method="post">
						{!!Form::token()!!}
						<div class="form-group">
							<label class="col-sm-2 control-label required">Code</label>
							<div class="col-sm-10">
                                                            <input type="text" class="form-control @if($errors->has('code')) error @endif" readonly name="code" placeholder="Code" required value="{{$transportChargin[0]->charging_code}}">
								@if($errors->has('code'))
									<label id="label-error" class="error" for="code">{{$errors->first('code')}}</label>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label required">Multiply by the QTY</label>
							<div class="col-sm-10">
								@if($errors->has('mbtqt'))
									{!! Form::select('mbtqt', array(null=>'Select Value','1' => 'Yes', '0' => 'No'),null,['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'mbtqt']) !!}
									<label id="supervisor-error" class="error" for="mbtqt">{{$errors->first('mbtqt')}}</label>
								@else
									{!! Form::select('mbtqt', array(null=>'Select Value','1' => 'Yes', '0' => 'No'),$transportChargin[0]->multiply,['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After','id'=>'mbtqt']) !!}
								@endif
								<label id="label-default" class="error" for="code">Select Yes if the selected charging amount need to multiply by the QTY</label>

							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label required">Name</label>
							<div class="col-sm-10">
                                                            <input type="text" class="form-control @if($errors->has('name')) error @endif" name="name" id="name" placeholder="Name" required value="{{$transportChargin[0]->type_name}}">
								@if($errors->has('name'))
									<label id="label-error" class="error" for="name">{{$errors->first('name')}}</label>
								@endif
								<label id="label-default" class="error" for="name">i.e - Per Km, Fixed, Per Mt, etc</label>
							</div>
						</div>
                                                
                                                <div class="panel-heading border">
                                                    <strong>Sub Category</strong>
                                                </div> 
                                                @foreach ($transportSubChargin as $transportSubChargin)
                                                <br>
                                                    <div class="form-group">
                                                            <label class="col-sm-2 control-label">Category Name</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="c_name[]" placeholder="Category Name" value="{{$transportSubChargin->type_name}}">
                                                                <input type="hidden" class="form-control" name="c_id[]" placeholder="Category Name" value="{{$transportSubChargin->id}}">
                                                            </div>
                                                    </div>
                                                    <hr>
                                                @endforeach
                                                <span id="responce"></span>		
                                                <div class="pull-left">
                                                        <button type="button" onclick="addInput()" class="btn btn-primary"><i class="fa fa-arrow-circle-down"></i> Add new</button>
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
	<script type="text/javascript">
        $('#add').click(function(e){               
            var y = document.getElementById("mbtqt");
            var re = y.options[y.selectedIndex].value;
            if(re ==''){
                sweetAlert(' Error','Please select multiply by the QTY.',3);
                return false;
            }   
            var name =document.getElementById("name").value;                            
            if(name ==''){
                sweetAlert(' Error','Please enter name.',3);
                return false;
            } 
            
        });
</script>
    <script>
        var countBox =1;
        var boxName = 0;
        function addInput()
            {
                var boxName="textBox"+countBox; 
                document.getElementById('responce').innerHTML+='<div class="form-group"><label class="col-sm-2 control-label">Category Name</label><div class="col-sm-10"><input type="text" class="form-control" name="c_name[]" placeholder="Contact Person" id="c_name"></div></div><div class="form-group"><label class="col-sm-2 control-label"></label><div class="col-sm-10"><input type="hidden" class="form-control" name="c_id[]" placeholder="Contact Person" id="c_id" value="0"></div></div><hr>';
                countBox += 1;
           }
    </script>
        <script type="text/javascript">
		$(document).ready(function(){
			$('.form-validation').validate();
			$('#permissions').multiSelect();
		});
	</script>
@stop
