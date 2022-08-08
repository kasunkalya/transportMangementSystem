@extends('layouts.sammy_new.master') @section('title','Add New Book')
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
            <a href="javascript:;">Book Management</a>
        </li>
        <li class="active">Add New Book</li>
    </ol>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-bordered">
                <div class="panel-heading border">
                    <strong>Add New Book</strong>
                </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal form-validation" method="post" enctype="multipart/form-data">
                        {!!Form::token()!!}

                        <div class="form-group">
                            <label class="col-sm-2 control-label required">Center</label>
                            <div class="col-sm-8">

                                @if($errors->has('center'))
                                    {!! Form::select('center',$center, Input::old('center'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                    <label id="supervisor-error" class="error" for="center">{{$errors->first('center')}}</label>
                                @else
                                    {!! Form::select('center',$center, Input::old('center'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                @endif

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control @if($errors->has('title')) error @endif" name="title" placeholder="Book Title" required value="{{Input::old('title')}}">
                                @if($errors->has('title'))
                                    <label id="label-error" class="error" for="label">{{$errors->first('title')}}</label>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                             <label class="col-sm-2 control-label required">ISBN</label>
                                  <div class="col-sm-8">
                                       <input type="text" class="form-control @if($errors->has('isbn')) error @endif" name="isbn" placeholder="Book ISBN" required value="{{Input::old('isbn')}}">
                                             @if($errors->has('isbn'))
                                                 <label id="label-error" class="error" for="label">{{$errors->first('isbn')}}</label>
                                             @endif
                                  </div>
                        </div>
                        <div class="form-group">
                             <label class="col-sm-2 control-label required">Author</label>
                                  <div class="col-sm-8">
                                       <input type="text" class="form-control @if($errors->has('author')) error @endif" name="author" placeholder="Book Author" required value="{{Input::old('author')}}">
                                             @if($errors->has('author'))
                                                 <label id="label-error" class="error" for="label">{{$errors->first('author')}}</label>
                                             @endif
                                  </div>
                        </div>
                        <div class="form-group">
                           <label class="col-sm-2 control-label required">Category</label>
                                <div class="col-sm-8">
                                      @if($errors->has('subject'))
                                          {!! Form::select('category',$category, Input::old('category'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                          <label id="supervisor-error" class="error" for="category">{{$errors->first('category')}}</label>
                                          @else
                                          {!! Form::select('category',$category, Input::old('category'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                          @endif
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">Type</label>
                            <div class="col-sm-8">

                                @if($errors->has('type'))
                                    {!! Form::select('type',$type, Input::old('type'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                    <label id="supervisor-error" class="error" for="type">{{$errors->first('type')}}</label>
                                @else
                                    {!! Form::select('type',$type, Input::old('type'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                @endif

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">Subject</label>
                            <div class="col-sm-8">

                                @if($errors->has('subject'))
                                    {!! Form::select('subject',$subject, Input::old('subject'),['class'=>'chosen error','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                    <label id="supervisor-error" class="error" for="subject">{{$errors->first('subject')}}</label>
                                @else
                                    {!! Form::select('subject',$subject, Input::old('subject'),['class'=>'chosen','style'=>'width:100%;','required','data-placeholder'=>'Set After']) !!}
                                @endif

                            </div>
                        </div>

                        <div class="form-group">
                             <label class="col-sm-2 control-label required">Rack No</label>
                                  <div class="col-sm-8">
                                       <input type="text" class="form-control @if($errors->has('rack')) error @endif" name="rack" placeholder="Rack Number" required value="{{Input::old('rack')}}">
                                             @if($errors->has('rack'))
                                                 <label id="label-error" class="error" for="label">{{$errors->first('rack')}}</label>
                                             @endif
                                  </div>
                        </div>
                        <div class="form-group">
                             <label class="col-sm-2 control-label required">Shell No</label>
                                  <div class="col-sm-8">
                                       <input type="text" class="form-control @if($errors->has('shell')) error @endif" name="shell" placeholder="Shell Number" required value="{{Input::old('shell')}}">
                                             @if($errors->has('shell'))
                                                 <label id="label-error" class="error" for="label">{{$errors->first('shell')}}</label>
                                             @endif
                                  </div>
                        </div>


                        <div class="pull-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    <script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.form-validation').validate();
            $('#permissions').multiSelect();
        });


    </script>
@stop
