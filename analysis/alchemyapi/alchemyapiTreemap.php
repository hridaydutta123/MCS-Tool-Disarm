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
	array('label' => 'sentiment', 'type' => 'string'),
    array('label' => 'relevance', 'type' => 'number')

);

$rows = array();
$response = $alchemyapi->keywords('text', $file, array('sentiment'=>1));
foreach ($response['keywords'] as $keyword) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $keyword['text']);
	$temp[] = array('v' => (string) $keyword['sentiment']['type']);

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
<script type="text/javascript" src="../js/jsapi.js"></script>
<script type="text/javascript" src="../js/DrasticTreemapGApi.js"></script>
<script type="text/javascript">
	google.load("visualization", "1");
	google.load("swfobject", "2.2");
  
	// Set callback to run when API is loaded
	google.setOnLoadCallback(drawVisualization); 

	// Called when the Visualization API is loaded.
	function drawVisualization() {
	
	// Create and populate a data table.
var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
	// Instantiate our object.
	var vis = new drasticdata.DrasticTreemap(document.getElementById('thediv'));
	
	// Draw the treemap with the data we created locally and some options:
	vis.draw(data, {
		groupbycol: "sentiment",
		labelcol: "text",
		variables: "relevance",
		width: '50%',
		hight: '100%'
		}
	);
   }
   
</script>
</head>
<body>
<div id="thediv" style="width:1065px; height:300px; border: none;"></div>
</body>
</html>