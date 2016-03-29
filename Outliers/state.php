<!DOCTYPE html>
<meta charset="utf-8">
<!-- Bootstrap -->

  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link type="text/css" rel="stylesheet" href="css/min.css"/>
<style>
body {
    position: 80
    margin: 0;
    padding: 0;
    background-color: #1f1f1f;
    font-family: TisaWebPro;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    color: #c6c6c6
}
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}
.bar {
  fill: steelblue;
}
.bar:hover {
  fill: black ;
}
.x.axis path {
  display: none;
}
.d3-tip {
  line-height: 1;
  font-weight: bold;
  padding: 12px;
  background: rgba(0, 0, 0, 0.8);
  color: #fff;
  border-radius: 2px;
}
/* Creates a small triangle extender for the tooltip */
.d3-tip:after {
  box-sizing: border-box;
  display: inline;
  font-size: 10px;
  width: 100%;
  line-height: 1;
  color: rgba(0, 0, 0, 0.8);
  content: "\25BC";
  position: absolute;
  text-align: center;
}
/* Style northward tooltips differently */
.d3-tip.n:after {
  margin: -1px 0 0 0;
  top: 100%;
  left: 0;
}
            table {
                border-collapse: collapse;
                border: 2px black solid;
                font: 12px sans-serif;
            }
            td {
                border: 1px black solid;
                padding: 5px;
            }

#main {
	position: relative;	
}
#map {
    position: absolute;
    padding-right: 20px;
    clear:both;
}

#stations {
    
    padding-right: 20px;
    position: absolute; 
	padding-top: 610px; 
	left: 3px; 
   	float: left;
    clear: left;
}



</style>
<head>

<?php
	// The value of the variable state is 
	echo "<h1><center>State: " . $_GET["state"] . "</center></h1>";
	$file = $_GET["state"];
	
	$i=0;
$filename = "state/data/".$file.".csv";
$contents = file($filename);
foreach($contents as $line) {
	
    $line = preg_replace( "/\r|\n/", "", $line );
	$line = str_replace("'", ' ', $line);
    
	$line_array = explode(",",$line);
    if($i==0)
    {
        foreach($line_array as $key=>$val)
        {
            $csv_heading[$key] = trim($val);
        }
    }
    else
    {
        foreach($line_array as $key=>$val)
        {
            $csv_array[$i][$csv_heading[$key]] = $val;
        }
    }
    $i++;
}
//print_r (sizeof($csv_array));
//print_r($csv_array[84]["latitude"]);
	
	
?>

<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />

</head>
<body>
<div class="sidebar1">
<ul class="nav nav-tabs">
  <li role="presentation"><a href="index.html">Home</a></li>
  <li role="presentation"><a href="animation.html">Animation</a></li>
  <li role="presentation" class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="analysis.html" role="button" aria-expanded="false">
      Analysis <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li role="presentation"><a href="analysis.html">Each State</a></li>
      <li role="presentation"><a href="yearly.html">All States</a></li>
    </ul>
  </li>
  <li role="presentation"><a href="help.html">How we did it?</a></li>
</ul>
</div>

<!-- end .sidebar1 -->
<div id="main">
<div id="map" style="width: 1100px; height: 600px">

	<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script>
		var map = L.map('map').setView([40.00, -100.00], 5);
		L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="http://mapbox.com">Mapbox</a>',
			id: 'examples.map-i875mjb7'
		}).addTo(map);
		
<?php 
$avgLat = 0.00;
$avgLon = 0.00;
foreach($csv_array as $arr){
	$lat = $arr["latitude"];
	$lon = $arr["longitude"];
	$station = $arr["id"];
	$name = $arr["name"];
	$avgLat += (float) $lat;
	$avgLon += (float) $lon;			
	echo "var link = ('<a href=station.php?state=$file&station=$station>$station</a>');";
	//.click(function() {
	//    alert("test");
	//})[0];
	//echo	"L.marker([$lat, $lon]).addTo(map)";
	//echo	"		.bindPopup('<b>This is a test link </b><br>Click me.'+"; 
	//echo " link).openPopup();";
	echo "L.marker([$lat, $lon]).addTo(map).bindPopup('<b> $name </b><br>Station ID: '+ link).openPopup();";
}
	
$avgLat = round($avgLat/sizeof($csv_array),3);
$avgLon = round($avgLon/sizeof($csv_array),3);	
echo "map.setView([$avgLat , $avgLon], 5);";
?>
</script>
</div>
<div id="stations">
<h2>Stations in : <?php echo $file ; ?> </h2>
<?php
$item = 1;
	echo "<table border='1' table-layout: fixed; margin-left: 2px; margin-right: 2px; style='width: 800px'>";
	echo " <caption>    </caption>";
	//echo " <thead> <tr> <th width='100' colspan='5' rowspan='1'> Result $item </th>";
	echo "<tbody>";
	echo "<tr>";
	echo "<td>";
	echo "<br>";
	echo "<font color='silver'> <b> ";
	echo "Station ID &nbsp;&nbsp;";
	echo "</font> </b> ";
	echo "</td>";
	echo "<td>";
	echo "<br>";
	echo "<font color='silver'> <b> ";
	echo "Name &nbsp;&nbsp;";
	echo "</td>";
	echo "<td>";
	echo "<br>";
	echo "<font color='silver'> <b> ";
	echo "Latitude &nbsp;&nbsp;";
	echo "</td>";
	echo "<td>";
	echo "<br>";
	echo "<font color='silver'> <b> ";
	echo "Longitude &nbsp;&nbsp;";
	echo "</td>";
	echo "<td>";
	echo "<br>";
	echo "<font color='silver'> <b> ";
	echo "Reports &nbsp;&nbsp;";
	echo "</td>";
	
	echo "</tr>";
	
foreach($csv_array as $arr){	
	echo "<tr>";
	echo "<td>";
	echo "<br>";
	//<a href=". $filename . ">TestLink</a>
	echo "<a href='station.php?state=$file";
	
	echo "&station=";
	echo $arr['id'];
	echo "'>";
	echo $arr['id'];
	echo "</a>";
	
	
	echo "&nbsp;&nbsp;";
	echo "</td>";
	echo "<td>";
	echo "<br>";
	echo $arr["name"];
	//echo $csv_array[$item]["name"];
	echo "&nbsp;&nbsp;";
	echo "</td>";
	echo "<td>";
	echo "<br>";
	echo $arr["latitude"];
	//echo $csv_array[$item]["latitude"];
	echo "&nbsp;&nbsp;";
	echo "</td>";
	echo "<td>";
	echo "<br>";
	echo $arr["longitude"];
	//echo $csv_array[$item]["longitude"];
	echo "&nbsp;&nbsp;";
	echo "</td>";
	echo "<td>";
	echo "<br>";
	echo $arr["count"];
	//echo $csv_array[$item]["count"];
	echo "&nbsp;&nbsp;";
	echo "</td>";
	echo "</tr>";
	
}
echo "</tbody></table>";
?>        
</div></div>        
</body>
</html>