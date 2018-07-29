<?php
$link = mysqli_connect("192.168.251.205", "gusano", "gusano2k", "castor");
// Check connection
if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}

//date_default_timezone_set('America/Santiago');

$date1 = date('Y-m-d');
$date2 = date('Y-m-d', strtotime('-2 month'));
$date3 = date('Y-m-') . "01";
//echo $date1;
//echo $date2;
//echo $date3;

//$sql = "select * from GCDROUTMON where FECHA >= '$date1' order by FECHA asc;";
//$sql1 = "select * from GCDROUTMONID where FECHA >= '$date1' order by FECHA asc;";
$sql = "select * from GCDROUTMON where FECHA >= '" . $date2 . "' and FECHA <= '" . $date1 . "' order by FECHA asc;";
$sql1 = "select * from GCDROUTMONID where FECHA >= '" . $date2 . "' and FECHA <= '" . $date1 . "' order by FECHA asc;";
$sql2 = "select count(*) COUNTER from GCDROUTMON where FECHA >= '" . $date3 . "' and STATUS = 'Nok';";

//my $NOK int;
if($result = mysqli_query($link, $sql2)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
        $NOK = intval($row[0]);
        }
        // Close result set                                                                                       
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
}

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
	<a class="navbar-brand" href="http://telefoniaecc.escc.cl/index.html">TelefoniaECC</a>           
	</div>
    		<div class="collapse navbar-collapse" id="myNavbar">                 
        	<ul class="nav navbar-nav">
		<li><a href="http://telefoniaecc.escc.cl/Arquitectura.html">Arquitectura</a></li>
                <li><a href="http://telefoniaecc.escc.cl/verticales/verticales.html">Verticalizacion</a></li>
                <li><a href="http://telefoniaecc.escc.cl/MyPolycom.html">Anexos</a></li>
                <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Informacion
                        <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <li><a href="http://telefoniaecc.escc.cl/Tramas.hml">Tramas</a></li>
                                <li><a href="http://telefoniaecc.escc.cl/Enlaces.html">Enlaces</a></li>
                                <li class="divider"></li>                            
                                <li><a href="http://telefoniaecc.escc.cl/servicios.php">Servicios ECC</a></li>
                                <li><a href="http://telefoniaecc.escc.cl/acdusers.php">ACD Contingencia</a></li>
                                </ul>                             
                </li>   
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Trafico<span class="caret"></span></a>
			<ul class="dropdown-menu">
			<li class="active"><a href="http://telefoniaecc.escc.cl/monitoreo/gcdroutmon.php">CDR OUT</a></li>
			</ul>
		</li>
		<li><a href="http://telefoniaecc.escc.cl/Conferencia/confe.html">Conference Rooms</a></li>
        	</ul>
     			<ul class="nav navbar-nav navbar-right">
			<li><a href="#">NokDays<span class="badge"><?php print $NOK;?></span></a></li>
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
<div class="col-sm-1"></div>
</div> <!-- row -->
<div class="container">
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
    if(mysqli_num_rows($result) >= 0){
        while($row = mysqli_fetch_array($result)){
	$dataset1[] = array(intval($row['UTIME']),intval($row['COUNTER']));
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

if($result = mysqli_query($link, $sql1)){
$dataset2 = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
        $dataset2[] = array(intval($row['UTIME']),intval($row['COUNTER']));
        }
        // Close result set                                                                                       
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql1. " . mysqli_error($link);
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
var dataset2 = <?php echo json_encode($dataset2); ?>;
var NOK = <?php echo json_encode($NOK); ?>;
console.log(dataset1);
console.log(dataset2);
console.log(NOK);
$(function() {
    var a1 = dataset1;
    var a2 = dataset2;
    var data = [
            {
                label: "CDR OUT Ideal",
                data: a2,
        	bars:{
			fill: true,
            		fillColor: 'rgba(087,166,057,0.1)',
            		lineWidth: 2,
			fillOpacity: 1.0
        	}
            },
            {
                label: "CDR OUT Real",
                data: a1,
		showNumbers: true
            }
        ];
    var barOptions = {
        series: {
            bars: {
                show: true,
                barWidth: 86400000,
                align: "center"
            }
        },
        xaxis: {
            mode: "time",
            timeformat: "%y-%m-%d",
            minTickSize: [1, "day"],
            clickable: true,
	    axisLabel: 'Fecha',
	    axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
            axisLabelPadding: 5
        },
        grid: {
            hoverable: true,
	    aboveData: true
        },
        legend: {
            show: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "Date: %x Counter: %y"
        }
    };

    $.plot($("#flot-bar-chart"), data, barOptions);

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
