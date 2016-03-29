<!DOCTYPE html>
<meta charset="utf-8">

<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
 <link type="text/css" rel="stylesheet" href="css/min.css"/>
<style>

body {
  font: 10px sans-serif;
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


</style>
<body>

<div class="sidebar1">
<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Home</a></li>
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


<?php

	// The value of the variable year is found
	//echo "<h1>year: " . $_GET["year"] . "</h1>";
	//echo "<h1>month: " . $_GET["month"] . "</h1>";
	$year = $_GET["year"] ;
	$month = $_GET["month"];
	$file = $year."-".$month;
	

?>
<h2><center> <?php echo "<h1>" . $file . "</h1>";?> </center></h2>


<div><center>
	<TABLE BORDER="0" cellpadding="0" CELLSPACING="0">
	<TR>

	<TD WIDTH="800" HEIGHT="465" BACKGROUND="month/strong_cold/<?php echo($file); ?>.png" VALIGN="top-center">

	<FONT SIZE="+1" COLOR="Black">Strong Cold</FONT></TD>

	</TR>
	</TABLE></center>
</div>
<div><center>
	<TABLE BORDER="0" cellpadding="0" CELLSPACING="0">
	<TR>

	<TD WIDTH="800" HEIGHT="465" BACKGROUND="month/weak_cold/<?php echo($file); ?>.png" VALIGN="top-center">

	<FONT SIZE="+1" COLOR="Black">Weak Cold</FONT></TD>

	</TR>
	</TABLE></center>
</div>
<div><center>
	<TABLE BORDER="0" cellpadding="0" CELLSPACING="0">
	<TR>

	<TD WIDTH="800" HEIGHT="465" BACKGROUND="month/weak_hot/<?php echo($file); ?>.png" VALIGN="top-center">

	<FONT SIZE="+1" COLOR="Black">Weak Hot</FONT></TD>

	</TR>
	</TABLE></center>    
</div>
<div><center>
	<TABLE BORDER="0" cellpadding="0" CELLSPACING="0">
	<TR>

	<TD WIDTH="800" HEIGHT="465" BACKGROUND="month/strong_hot/<?php echo($file); ?>.png" VALIGN="top-center">

	<FONT SIZE="+1" COLOR="Black">Strong Hot</FONT></TD>

	</TR>
	</TABLE></center>
</div>





</body>
