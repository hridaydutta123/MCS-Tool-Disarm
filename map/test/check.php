<?php
require("phpsqlajax_dbinfo.php");

function parseToXML($htmlStr) 
{ 
$xmlStr=str_replace('<','&lt;',$htmlStr); 
$xmlStr=str_replace('>','&gt;',$xmlStr); 
$xmlStr=str_replace('"','&quot;',$xmlStr); 
$xmlStr=str_replace("'",'&#39;',$xmlStr); 
$xmlStr=str_replace("&",'&amp;',$xmlStr); 
return $xmlStr; 
} 

// Opens a connection to a MySQL server
$connection=mysql_connect ('localhost', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table
$query = "SELECT latitude, longitude, type FROM file_details WHERE 1";

$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}
// set array
$file_array = array();
// look through query
while($row = mysql_fetch_assoc($result)){
  $file_array[] = $row; // add each row returned into an array
}
$file_lat = array_column($file_array, 'latitude'); //modify and put all file name in a single array.
$file_lng = array_column($file_array, 'longitude'); //modify and put all file name in a single array.
$lat_max = max($file_lat);
echo($lat_max . "<br>");
$lat_min = min($file_lat);
echo($lat_min . "<br>");
$lng_max = max($file_lng);
echo($lng_max . "<br>");
$lng_min = min($file_lng);
echo($lng_min . "<br>");
$lat_avg = (($lat_max + $lat_min)/2);
echo($lat_avg . "<br>");
$lng_avg = (($lng_max + $lng_min)/2);
echo($lng_avg . "<br>");
$dif_lat = ($lat_max - $lat_min);
$dif_lng = ($lng_max - $lng_min);
if($dif_lat <= 0.2 || $lng_max <= 0.4)
{
    $zoom = 12;
}
else if($dif_lat <= 1 || $lng_max <= 1.5)
{
$zoom = 9;
}
else if($dif_lat <= 3 || $lng_max <= 5)
{
$zoom = 7;
}
else if($dif_lat <= 12 || $lng_max <= 20)
{
$zoom = 5;
}
else
{
$zoom = 2;
}
echo $zoom;
sort($file_lat);
sort($file_lng);
	echo '<pre>';
	print_r($file_array); // show all array data
	echo '</pre>';
	echo '<pre>';
	print_r($file_lat); // show all array data
	echo '</pre>';
	echo '<pre>';
	print_r($file_lng); // show all array data
	echo '</pre>';
	echo '<pre>';
	print_r($file_lat); // show all array data
	echo '</pre>';
	echo '<pre>';
	print_r($file_lng); // show all array data
	echo '</pre>';
	

?>