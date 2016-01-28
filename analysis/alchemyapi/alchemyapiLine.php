<?php
	$file = file_get_contents('../all.txt', true);
    require_once '../alchemyapi/alchemyapi.php';
    $alchemyapi = new AlchemyAPI();
?>

<?php
$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'text', 'type' => 'string'),
    array('label' => 'relevance', 'type' => 'number')

);

$rows = array();
$response = $alchemyapi->keywords('text', $file, array('sentiment'=>1));
foreach ($response['keywords'] as $keyword) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $keyword['text']); 

    // Values of each slice
    $temp[] = array('v' => (float) $keyword['relevance']); 
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
	var line_options = {
          is3D: 'true',
          width: '100%',
          height: '100%'
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
	  var chart = new google.visualization.LineChart(document.getElementById('linechartAlchemy_div'));
     chart.draw(data, line_options);
    }
    </script>
  </head>

  <body>
    <!--this is the div that will hold the pie chart-->
	<div id="linechartAlchemy_div"></div>
  </body>
</html>