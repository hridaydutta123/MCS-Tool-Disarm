<?php
require("../script/dbConnect.php"); //Connect to database
if(!empty($_POST)) {
	if( isset($_POST['block']) )
{
	    $sth = mysql_query("SELECT type, SUM(qty) as quantity FROM victim WHERE filename in(SELECT filename FROM file_details WHERE ts Between '$start_date' and '$end_date') AND filename in(SELECT filename FROM affected_areas WHERE district ='$district' AND block ='$block')GROUP BY type");
} elseif (isset($_POST['start_date']))
{
		$sth = mysql_query("SELECT type, SUM(qty) as quantity FROM victim WHERE filename in(SELECT filename FROM file_details WHERE ts Between '$start_date' and '$end_date') GROUP BY type");
}
}
else 
{
	$sth = mysql_query("SELECT type, SUM(qty) as quantity FROM victim GROUP BY type");
}

$rows = array();
//flag is not needed
$flag = true;
$table = array();
$table['cols'] = array(

    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'type', 'type' => 'string'),
    array('label' => 'quantity', 'type' => 'number')
);

$rows = array();
while($r = mysql_fetch_assoc($sth)) {
    $temp = array();
    // the following line will be used to slice the Pie chart
    $temp[] = array('v' => (string) $r['type']); 

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
    <script type="text/javascript" src="../js/jsapi.js"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);

      function drawTable() {
		var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
		var options = {
			page: 'enable',
			pageSize: 5,
		  showRowNumber: 'true',
          is3D: 'true',
          width: '100%',
		  hight: '100%'
        };

        var table = new google.visualization.Table(document.getElementById('victimTable_div'));

        table.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="victimTable_div"></div>
  </body>
</html>