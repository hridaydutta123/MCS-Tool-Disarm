<html>
<head>
<script type=�text/javascript� src=�https://www.google.com/jsapi�></script>
<script type=�text/javascript� src=�http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js�></script>
<script type=�text/javascript�>
google.load(�visualization�, �1?, {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
var jsonData = $.ajax({
url: �getData_json.php�,
dataType:�json�,
async: false
}).responseText;
// Create our data table out of JSON data loaded from server.
var data = new google.visualization.DataTable(jsonData);
var options = {
width: 800, height: 480,
title: �Company Performance�
};
var chart = new google.visualization.LineChart(document.getElementById(�chart_div�));
chart.draw(data, options);
}
</script>
</head>
<body>
<div id=�chart_div�></div>
</body>
</html>