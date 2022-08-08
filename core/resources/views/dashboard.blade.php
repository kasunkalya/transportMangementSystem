@extends('layouts.sammy_new.master') @section('title','Dashboard')
@section('current_title','Dashboard')
@section('content')
<style type="text/css">
  .bg-black {
    color: #616161;
    background-color: #556B8D;
}


.bg-red {
    color: #616161;
    background-color: #EFA131;
}

.bg-blue {
    color: #616161;
    background-color: #55822A;
}

.widget .widget-title {
    display: block;
    font-size: 25px;
    line-height: 1;
    color: #fff;
    font-family:'Open Sans',sans-serif;
}

.widget .widget-subtitle {
    font-size: 12px;
    color: #fff;
}

.bg-white3 {
    color: #EFA131;
    background-color: #fff;
}


.bg-white1 {
    color: #556B8D;
    background-color: #fff;
}

.bg-white2 {
    color: #55822A;
    background-color: #fff;
}

.widget .widget-icon {
    display: inline-block;
    vertical-align: middle;
    width: 40px;
    height: 40px;
    border-radius: 20px;
    text-align: center;
    font-size: 25px;
    line-height: 40px;
}

small, .small {
    font-size: 15px;
}
dt,.bold {
    font-weight: 700;
}

.bg-white {
    color: #616161;
    background-color: white;
    border: 1px solid #ccc;
}

.bg-lightblue {
    color: white;
    background-color: #4CC3D9;
}

.bg-brown {
    color: white;
    background-color: #D96557;
}

.bg-success {
    color: white;
    background-color: #FFC65D;
}

.bg-primary {
    color: white;
    background-color: #34495e;
}

.text-success {
    color: #556B8D;
}

.main-panel > .header .navbar-nav .dropdown-menu {
    margin-top: 2px;
    padding: 0;
    border-color: rgba(0, 0, 0, 0.1);
    border-top: 0;
    background-color: white;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    -moz-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    -webkit-border-radius: 0;
    -moz-border-radius: 0;
    border-radius: 0;
    width: 100%;
}
</style>


<div class="row">
  <div class="col-md-4">
    <section class="widget bg-lightblue text-center" style="height: 99px;">
      <div class="widget-details">
        <h2 class="no-margin bold">{{$lorry}}</h2>
        <small class="text-uppercase">Number Of Lorries</small>
      </div>
      <div class="widget-details">
        <div class="climacon hail sun fa-4x"></div>
      </div>
    </section>
  </div>
    
  <div class="col-md-4">
    <section class="widget bg-brown text-center" style="height: 99px;">
      <div class="widget-details">
        <h2 class="no-margin bold">{{$route}}</h2>
        <small class="text-uppercase">Number Of Transport Routes</small>
      </div>
      <div class="widget-details">
        <div class="climacon hail sun fa-4x"></div>
      </div>
    </section>
  </div>
    
  <div class="col-md-4">
    <section class="widget bg-success text-center" style="height: 99px;">
      <div class="widget-details">
        <h2 class="no-margin bold">{{$employee}}</h2>
        <small class="text-uppercase">Number Of Employees</small>
      </div>
      <div class="widget-details">
        <div class="climacon hail sun fa-4x"></div>
      </div>
    </section>
  </div>    
</div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Expire Records</h4>
        </div>
        <div class="modal-body">
                          
                    <div id="demo5"></div>                 
                    <div id="demo3"></div> 
           
      
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 

<div class="row">
  <div class="col-md-6">
    <div class="widget bg-white">
      <div class="widget-details widget-list">
        <div class="mb20">
          <h4 class="no-margin text-uppercase">Today Trips</h4>         
        </div>
        
            <table class="table table-bordered bordered table-striped table-condensed datatable">
	              	<thead>
		                <tr>
		                  	<th class="text-center" width="4%">#</th>
		                  	<th class="text-center" style="font-weight:normal;">Invoice No</th>
		                  	<th class="text-center" style="font-weight:normal;">Invoice Date</th>
		                  	<th class="text-center" width="4%" style="font-weight:normal;">Lorry</th>
                            <th class="text-center" width="4%" style="font-weight:normal;">Route</th>
		                </tr>
		               
	              	</thead>
	    </table>
          
          
          
      </div>
    </div>
  </div>    
  <div class="col-md-6"> 
    <div class="widget bg-white">
          <div class="canvas-holder">
            <div id="columnchart_values"></div>
          </div>  
    </div>


  </div>
</div>
@stop
@section('js')
  <!-- page level scripts -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script src="{{asset('assets/sammy_new/vendor/d3/d3.min.js')}}"></script>
  <script src="{{asset('assets/sammy_new/vendor/rickshaw/rickshaw.min.js')}}"></script>
  <script src="{{asset('assets/sammy_new/vendor/flot/jquery.flot.js')}}"></script>
  <script src="{{asset('assets/sammy_new/vendor/flot/jquery.flot.resize.js')}}"></script>
  <script src="{{asset('assets/sammy_new/vendor/flot/jquery.flot.categories.js')}}"></script>
  <script src="{{asset('assets/sammy_new/vendor/flot/jquery.flot.pie.js')}}"></script>
  
  <script type="text/javascript">
     $(window).on('load',function(){
        $('#myModal').modal('show');
    });
    
	var id = 0;
	var table = '';
	$(document).ready(function(){
		table = generateTable('.datatable', '{{url('transportManagement/json/dailylist')}}',[]);
	});

	
</script>
  <!-- /page level scripts -->

  <!-- initialize page scripts -->
  <script src="{{asset('assets/sammy_new/scripts/pages/dashboard.js')}}"></script>
  <!-- /initialize page scripts -->
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    
    
    var jsonData = $.ajax({
              type: "GET",
              url: "{{url('transportLorry/json/summayDaily')}}/<?php echo date('Y-m-d') ?>/<?php echo date('Y-m-d') ?>",
              dataType:"json",
              async: false
          }).responseText;
          var obj = JSON.parse(jsonData); 
          

    
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Day", "Transport", { role: "style" } ],
        ["Fule Cost", obj[2], "#b87333"],
        ["Service Cost", obj[4], "silver"],
        ["Repair Cost", obj[3], "orange"],  
        ["Driver Cost", obj[5], "#ff5733"],
        ["Helper Cost", obj[6], "#ffec33"],
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Daily Summary",
        width: 500,
        height: 570,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
@stop
