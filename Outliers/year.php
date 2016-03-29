<!DOCTYPE html>
<meta charset="utf-8">
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
  stroke: #fff;
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

<?php

	// The value of the variable year is found
	echo "<h1>Outliers: " . $_GET["year"] . "</h1>";

?>

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

<!-- end .sidebar1 -->


<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
<script>

//var margin = {top: 20, right: 20, bottom: 50, left: 40},
var margin = {top: 30, right: 100, bottom: 50, left: 50},
    width = 1100 - margin.left - margin.right,
    height = 680 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .rangeRound([height, 0]);

var color = d3.scale.ordinal()
	.range(["#097ACC", "#8FCAFF", "#FF9888", "#CC0A00"]);
	//.range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b"]);
    //.range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .tickFormat(d3.format(".2s"));

var tip = d3.tip()
  .attr('class', 'd3-tip')
  .offset([-10, 0])
  .html(function(d) {
    return "<strong>"+d.name +":</strong> <span style='color:red'>" + (-1*((d.y0) - (d.y1))) + "</span>" 
	//+ "<br> <strong>Percent:</strong> <span style='color:red'>" + (d.total) + "</span>"
	;
  })

var svg = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

svg.call(tip);

d3.csv("data/<?php echo $_GET["year"] ; ?>.csv", function(error, data) {
  color.domain(d3.keys(data[0]).filter(function(key) { return key !== "Month"; }));

  data.forEach(function(d) {
    var y0 = 0;
    d.types = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name]}; });
    d.total = d.types[d.types.length - 1].y1;
  });

  //data.sort(function(a, b) { return b.total - a.total; });

  x.domain(data.map(function(d) { return d.Month; }));
  y.domain([0, d3.max(data, function(d) { return d.total; })]);

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
	  //rotate text and add hyperlink
	  .selectAll("text")	
	  .style("text-anchor", "end")
      .style("fill","#DE3378")
		.attr("dx", "-.8em")
		.attr("dy", ".15em")
		.attr("transform", function(d) {
			return "rotate(-65)"
		});
	 
d3.selectAll("text")
    .filter(function(d){ return typeof(d) == "string"; })
    .style("cursor", "pointer")
    .on("click", function(d){
        document.location.href = ("month.php?year=" + <?php echo $_GET["year"] ; ?> + "&month=" + d);
    });

	  

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .selectAll("text")
      .style("text-anchor", "end")
      .style("fill","#DE3378")
    .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .style("fill","#FFFFFF")
      .text("Outliers");

  var month = svg.selectAll(".Month")
      .data(data)
    .enter().append("g")
      .attr("class", "g")
      .attr("transform", function(d) { return "translate(" + x(d.Month) + ",0)"; });

  month.selectAll("rect")
      .data(function(d) { return d.types; })
    .enter().append("rect")
	
	  //.attr("class", "bar")
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.y1); })
      .attr("height", function(d) { return y(d.y0) - y(d.y1); })
      .style("fill", function(d) { return color(d.name); })
	  //.on('click',clickMe)	  
	  //.on('mouseover', tip.show)
      //.on('mouseout', tip.hide)
	  .on("mouseover", function(d){
		  		tip.show(d) ;
				var xPos = parseFloat(d3.select(this).attr("x"));
				var yPos = parseFloat(d3.select(this).attr("y"));
				var height = parseFloat(d3.select(this).attr("height"))
				d3.select(this).attr("stroke","blue").attr("stroke-width",0.8)})
				
	  .on("mouseout", function(d){
			tip.hide(d);
			d3.select(this).attr("stroke","pink").attr("stroke-width",0.2);})		
	  

  var legend = svg.selectAll(".legend")
      .data(color.domain().slice().reverse())
    .enter().append("g")
      .attr("class", "legend")
      .attr("transform", function(d, i) { return "translate(100," + i * 20 + ")"; });

  legend.append("rect")
      .attr("x", width - 18)
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color);

  legend.append("text")
      .attr("x", width - 24)
      .attr("y", 9)
      .attr("dy", ".35em")
      .style("text-anchor", "end")
      .style("fill","#FFFFFF")
      .text(function(d) { return d; });
	  
	//function clickMe(){alert("http://localhost/fe550/project/index.html")}
	//function clickLink(){"http://localhost/fe550/project/stacked-monthly.html";}
	
	
	

});

</script>
