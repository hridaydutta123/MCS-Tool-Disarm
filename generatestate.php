<?php
$con=mysql_connect("localhost","root","password") or die("Failed to connect with database!!!!");
mysql_select_db("disarm", $con);
// output headers so that the file is downloaded rather than displayed
//header('Content-Type: text/csv; charset=utf-8');
//header('Content-Disposition: attachment; filename=report.csv');

	
// create a file pointer connected to the output stream
//$output = fopen('php://output', 'w');
// output the column headings
//fputcsv($output, array('Food Name', 'Quantity'));
// fetch the data
$rows = mysql_query('SELECT latitude,longitude,filename FROM file_details');
// loop over the rows, outputting them
while ($row = mysql_fetch_array($rows))
// fputcsv($output, $row);
{
	$lat[] = $row['latitude'];
	$long[] = $row['longitude'];
	$filename[] = $row['filename'];
}

for ($i = 1; $i <= count($lat); $i++) 
{
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat[$i]).','.trim($long[$i]).'&sensor=false';
	
	$json = @file_get_contents($url);
	$data = json_decode($json);
	$pieces = explode(",", $data->results[0]->formatted_address);
	//echo json_encode($pieces).",";
	end($pieces);
	echo prev($pieces)." ";
}
?>
