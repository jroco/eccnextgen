<?php
$link = mysqli_connect("10.240.8.49", "pitbull", "tuerca2k", "CDR");
// Check connection
if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

//date_default_timezone_set('America/Santiago');

$date1 = date('Y-m-d H:i:s');
$date2 = date('Y-m-d H:i:s', strtotime('-10 hour'));
echo $date1;
echo $date2;

$sql = "select PROVEEDOR, COUNT(*) from ETL_CDR_ASTERISK_GCDR_OUTBOUND where CREATED < '" . $date1 . "' and CREATED >= '" . $date2 . "' group by PROVEEDOR order by COUNT(*) desc;";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>SCI ECC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../img/glyphicons-340-rabbit.png">
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="../bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
  <script type="text/JavaScript" src="../phpSecureLogin/js/sha512.js"></script> 
  <script type="text/JavaScript" src="../phpSecureLogin/js/forms.js"></script>

  <!-- Custom CSS -->             
  <link href="../bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../bootstrap-3.3.4-dist/css/sb-admin.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<nav class="navbar navbar-inverse">
<div class="container-fluid">
	<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="http://telefoniaecc/index.html">TelefoniaECC</a>           
	</div>
    		<div class="collapse navbar-collapse" id="myNavbar">                 
        	<ul class="nav navbar-nav">
                <li><a href="http://telefoniaecc/verticales.php">Verticalizacion</a></li>
                <li><a href="http://telefoniaecc/MyPolycom.html">Anexos</a></li>
                <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Informacion
                        <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <li><a href="http://telefoniaecc/Tramas.hml">Tramas</a></li>
                                <li><a href="http://telefoniaecc/Enlaces.html">Enlaces</a></li>
                                <li class="divider"></li>                            
                                <li><a href="http://telefoniaecc/servicios.php">Servicios ECC</a></li>
                                <li><a href="http://telefoniaecc/acdusers.php">ACD Contingencia</a></li>
                                </ul>                             
                </li>   
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Trafico<span class="caret"></span></a>
			<ul class="dropdown-menu">
			<li class="active"><a href="http://telefoniaecc/monitoreo/gcdroutmon.php">CDR OUT</a></li>
			</ul>
		</li>
        	</ul>
     			<ul class="nav navbar-nav navbar-right">
			<li><a href="#">NokDays<span class="badge"></span></a></li>
        		<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        		<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
     			</ul>
 		</div> <!-- myNavbar -->
</div> <!-- container-fluid -->
</nav>
<!-- New Commands -->
<div class="row">
<div class="col-sm-1"></div>
<div class="col-sm-10">
	<div class="panel panel-primary">
        	<div class="panel-heading">
        	<h3 class="panel-title"><i class="fa fa-long-arrow-right"></i>Records by Proveedor</h3>
        	</div>
        	<div class="panel-body">
        	<div class="flot-chart">
        	<div class="flot-chart-content" id="flot-bar-chart"></div>
        	</div>
        	<div class="text-right">
        	<a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
        	</div>
        	</div>
	</div>
</div>
</div>
<div class="col-sm-1"></div>
</div> <!-- row -->
<div class="container">
  <table class="table table-bordered">
    <thead>
        <tr>
        <th>PROVEEDOR</th>
        <th>ANSWER</th>
        </tr>
    </thead>
    <tbody>
<?php
// Attempt select query execution
if($result = mysqli_query($link, $sql)){                                         
$dataset1 = array();
    if(mysqli_num_rows($result) >= 0){
        while($row = mysqli_fetch_array($result)){
	$dataset1[] = array($row['PROVEEDOR'],intval($row[1]));
            echo "<tr>";
                echo "<td width=50% align=left>" . $row['PROVEEDOR'] . "</td>";
                echo "<td width=50% align=left>" . $row[1] . "</td>";
            echo "</tr>";                  
        }                                                                                                   
        // Close result set                                                                                       
        mysqli_free_result($result);
    } else{                                                                    
        echo "No records matching your query were found.";                       
    }                                                                              
} else{                                                                              
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);              
}                                                                                        

// Close connection                                                                                               
mysqli_close($link);
//echo json_encode($dataset2); 
?> 

</tbody>
</table>
</div> <!-- container -->

<script language="javascript">
var dataset1 = <?php echo json_encode($dataset1); ?>;
console.log(dataset1);
$(function() {
    var a1 = dataset1;

    $.plot("#flot-bar-chart", [ a1 ], {
                        series: {
                                bars: {
                                        show: true,
                                        align: "center"
                                }
                        },
                        xaxis: {
                                mode: "categories"
                        }
                });

});
</script>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/excanvas.min.js"></script>

</body>

</html>
