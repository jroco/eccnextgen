<?php
$link = mysqli_connect("192.168.251.205", "gusano", "gusano2k", "castor");
// Check connection
if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "select * from GCDROUTMON where FECHA >= '2016-04-01' order by FECHA asc;";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>SCI ECC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap-3.3.4-dist/css/bootstrap.min.css">          
  <link rel="shortcut icon" href="../img/glyphicons-340-rabbit.png">
  <script src="../jquery/1.11.2/jquery-1.11.2.js"></script>
  <script src="../bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
  <script type="text/JavaScript" src="../phpSecureLogin/js/sha512.js"></script> 
  <script type="text/JavaScript" src="../phpSecureLogin/js/forms.js"></script>

  <!-- Custom CSS -->     
  <link href="../bootstrap-3.3.4-dist/css/sb-admin.css" rel="stylesheet">
                            
  <!-- Morris Charts CSS -->      
  <link href="../bootstrap-3.3.4-dist/css/plugins/morris.css" rel="stylesheet">

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
                <li><a href="verticales.php">Verticalizacion</a></li>
                <li><a href="MyPolycom.html">Anexos</a></li>
                <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Informacion
                        <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <li><a href="Tramas.hml">Tramas</a></li>
                                <li><a href="Enlaces.html">Enlaces</a></li>
                                <li class="divider"></li>                            
                                <li><a href="Servicios.html">Servicios ECC</a></li>
                                <li><a href="acdusers.php">ACD Contingencia</a></li>
                                </ul>                             
                </li>   
		<li class="active"><a href="http://telefoniaecc/monitoreo/gcdroutmon.php">Monitoreo</a></li>
        </ul>
     <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
     </ul>
    </div> <!-- myNavbar -->
  </div> <!-- container-fluid -->
</nav>
<!-- New Commands -->
<div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> CDR OUT Answer Records</h3>
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
  <table class="table table-bordered">
    <thead>
        <tr>
        <th>FECHA</th>
        <th>COUNTER</th>
	<th>DAYSOFTHEWEEK</th>
	<th>STATUS</th>
        </tr>
    </thead>
    <tbody>
<?php
// Attempt select query execution
if($result = mysqli_query($link, $sql)){                                         
$dataset1 = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
	$dataset1[] = array($row['UTIME'],$row['COUNTER']);
            echo "<tr>";
                echo "<td width=25% align=left>" . $row['FECHA'] . "</td>";
                echo "<td width=25% align=left>" . $row['COUNTER'] . "</td>";
		echo "<td width=25% align=left>" . $row['DAYOFTHEWEEK'] . "</td>";
                echo "<td width=25% align=left>" . $row['STATUS'] . "</td>";
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
        
?> 

</tbody>
</table>

</div>

    <!-- jQuery 
    <script src="js/jquery.js"></script>
-->
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
<!--
    <script src="js/plugins/morris/morris-data.js"></script>
-->
    <!-- Flot Charts JavaScript -->
    <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
<!--
    <script src="js/plugins/flot/flot-data.js"></script>
-->
<script language="javascript">
var dataset1 = <?php echo json_encode($dataset1); ?>;
$(function() {
    var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 80400000,
		align: "center"
            }
        },
        xaxis: {
            mode: "time",
            timeformat: "%y-%m-%d",
            minTickSize: [1, "day"],
	    clickable: true
        },
        grid: {
            hoverable: true
        },
        legend: {
            show: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "X: %x | Y: %y"
        }
    };
    $.plot($("#flot-bar-chart"), [dataset1], barOptions);

});
</script>

</body>

</html>
