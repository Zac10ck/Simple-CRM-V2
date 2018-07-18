
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://v4-alpha.getbootstrap.com/favicon.ico">






<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://v4-alpha.getbootstrap.com/favicon.ico">
    <title>Unisis CRM</title>


 <link href="dash_files/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dash_files/dashboard.css" rel="stylesheet">
  <style>@media print {#ghostery-purple-box {display:none !important}}</style></head>



    <!-- Bootstrap core CSS -->
    <link href="dash_files/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dash_files/dashboard.css" rel="stylesheet">
  <style>@media print {#ghostery-purple-box {display:none !important}}</style></head>

  <body>
    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="dash.php">Dashboard</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reports/index.php"><b>Reports</b></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mailto:abin.abraham@unisissolutions.com?Subject=Unisis%20CRM">Email</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
          
 <span class="pull-left"><a href="#addnew1" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New</a></span>
    <div style="height:.05px;"></div>
          
        </ul>
      </div></nav></body></html>



  <?php include('add_modal1.php'); ?>


<?php 
$connect = mysqli_connect("localhost", "root", "", "sample");
$query = "SELECT * FROM dar ORDER BY date DESC";
$result = mysqli_query($connect, $query);
?>
<html>
 <head>
  <title>Unisis CRM</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
 </head>
 <body>
  <div class="container">
   <h1 align="center">Unisis Client Database-Riyadh</h1>
   <br />
   
   <div class="table-responsive">
    <table id="product_data" class="table table-bordered table-striped">
     <thead>
      <tr>  
        <th>Date</th>
       <th>Client</th>
       <th>Person</th>
      
       <th>Phone</th>
	   <th>Activity</th>
	   
	   
      </tr>
     </thead>
    </table>
   </div>
  </div>



 </body>
</html>



<script type="text/javascript" language="javascript" >
$(document).ready(function(){
 
 load_data();

 function load_data(is_category)
 {
  var dataTable = $('#product_data').DataTable({
   "processing":true,
   "serverSide":true,
   "order":[],
   "ajax":{
    url:"fetch.php",
    type:"POST",
    data:{is_category:is_category}
   },
   "columnDefs":[
    {
     "targets":[2],
     "orderable":false,
    },
   ],
  });
 }

 $(document).on('change', '#category', function(){
  var category = $(this).val();
  $('#product_data').DataTable().destroy();
  if(category != '')
  {
   load_data(category);
  }
  else
  {
   load_data();
  }
 });
});
</script>
