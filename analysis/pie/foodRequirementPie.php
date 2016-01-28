<?php
require("../script/dbConnect.php"); //Connect to database
if(!empty($_POST)) {
	if( isset($_POST['block']) )
{
	    $sth = mysql_query("SELECT foodname, SUM(qty) as quantity FROM food WHERE filename in(SELECT filename FROM file_details WHERE ts Between '$start_date' and '$end_date') AND filename in(SELECT filename FROM affected_areas WHERE district ='$district' AND block ='$block')GROUP BY foodname");
} elseif (isset($_POST['start_date']))
{
    $sth = mysql_query("SELECT foodname, SUM(qty) as quantity FROM food WHERE filename in(SELECT filename FROM file_details WHERE ts Between '$start_date' and '$end_date') GROUP BY foodname");
}
}
else 
{
	$sth = mysql_query("SELECT foodname, SUM(qty) as quantity FROM food GROUP BY foodname");
}

$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'foodname', 'type' => 'string'),
    array('label' => 'quantity', 'type' => 'number')

);

$rows = array();
while($r = mysql_fetch_assoc($sth)) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $r['foodname']); 

    // Values of each slice
    $temp[] = array('v' => (int) $r['quantity']); 
    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
//echo $jsonTable;
?>

<html>
  <head>
    <!--Load the Ajax API-->
    <script type="text/javascript" src="../js/jsapi.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
      var options = {
          is3D: 'true',
          width: '100%',
          height: '100%'
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.PieChart(document.getElementById('foodRequirementPie_div'));
      chart.draw(data, options);
    }
    </script>
  </head>

  <body>
    <!--this is the div that will hold the pie chart-->
    <div id="foodRequirementPie_div"></div>
  </body>
</html>