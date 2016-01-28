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
    array('label' => 'relevance', 'type' => 'number'),
	array('label' => 'sentiment', 'type' => 'string')

);

$rows = array();
$response = $alchemyapi->keywords('text', $file, array('sentiment'=>1));
foreach ($response['keywords'] as $keyword) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $keyword['text']); 

    // Values of each slice
    $temp[] = array('v' => (float) $keyword['relevance']);
	$temp[] = array('v' => (string) $keyword['sentiment']['type']);
    $rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
//echo $jsonTable;
?>

<html>
  <head>
    <script type="text/javascript" src="../js/jsapi.js"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);

      function drawTable() {
		var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
		var options = {
			page: 'enable',
			pageSize: 10,
		  showRowNumber: 'true',
          is3D: 'true',
          width: '100%',
		  hight: '100%'
        };

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="table_div"></div>
  </body>
</html>