@extends('layouts.sammy_new.master') @section('title','Transport Summary')
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
		<a href="{{{url('transportManagement/addInvoice')}}}">Summary</a>
  	</li>

</ol>
<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-bordered">
				<div class="panel-heading border">
					<div class="row">
						<div class="col-xs-6"><strong>Summary</strong></div>
<!--						<div class="col-xs-6 text-right"><a href="{{{url('transportManagement/add')}}}"><button class="btn btn-success"><i class="fa fa-plus" style="width: 28px;"></i>Transport Request Add</button></a></div>-->
					</div>
				</div>
                                <div class="panel panel-bordered panel-primary" style="margin:5px;">
                                        <div class="panel-heading">Search By</div>
                                        <div class="panel-body" id="myRadioGroup">
<!--                                              <label class="radio-inline">
                                                  <input type="radio" name="optradio" id="optradio" value="1" checked>Trip Date
                                              </label>
                                              <label class="radio-inline">
                                                <input type="radio" name="optradio" id="optradio" value="2">Lorry
                                              </label>
                                              <label class="radio-inline">
                                                <input type="radio" name="optradio" id="optradio" value="4">Customer
                                              </label>  
                                              <label class="radio-inline">
                                                <input type="radio" name="optradio" id="optradio" value="3">Trip Number
                                              </label>  -->
                                             
                                            
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
                                     
                                           
<!--                                        <div style=" margin-top:60px;">
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
                                        </div>-->
                                            <div class="pull-right" style=" margin:10px;">
                                            <button id="search" type="button" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                            
                                        </div>
     
                                </div>
                       
                            

				
                                    <div id="curve_chart" style="width:100%; height: 500px"></div>
				
			</div>
		</div>
	</div>

@stop
@section('js')
<script src="{{asset('assets/sammy_new/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
	var id = 0;
	var table = '';
	$(document).ready(function(){
            $("#optradio2").hide();
            $("#optradio3").hide();
            $("#optradio4").hide();
            $("#content").hide();
            
            
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
            
		table = generateTable('.datatable', '{{url('transportLorry/json/summaysearchlist')}}/'+0+'/'+0,[],[]);

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
                    var invoicedatefrom =document.getElementById("invoicedatefrom").value;
                    var invoicedateto =document.getElementById("invoicedateto").value;
                
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        var jsonData = $.ajax({
              type: "GET",
              url: "{{url('transportLorry/json/summaysearchlist')}}/"+invoicedatefrom+'/'+invoicedateto,
              dataType:"json",
              async: false
          }).responseText;
          var obj = JSON.parse(jsonData); 
     
    
    

 
    var dataRows = [['Lorry', 'Fuel', 'Repair Cost', 'Service Cost']];
    for (var i = 0; i < obj.data.length; i++) {
      dataRows.push([obj.data[i][1],obj.data[i][4],obj.data[i][5],obj.data[i][6]]);
    }
 
 
        function drawChart() {
          var data = google.visualization.arrayToDataTable(dataRows);

          var options = {
            title: 'Lorry',
            curveType: 'function',
            legend: { position: 'bottom' }
          };

          var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

          chart.draw(data, options);
        }

          }
</script>
<!--    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      
      var invoicedatefrom =document.getElementById("invoicedatefrom").value;
      var invoicedateto =document.getElementById("invoicedateto").value;
      
      var jsonData = $.ajax({
            type: "GET",
            url: "{{url('transportLorry/json/summaysearchlist')}}/"+invoicedatefrom+'/'+invoicedateto,
            dataType:"json",
            async: false
        }).responseText;

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>-->

@stop
