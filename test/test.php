<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = new mysqli("localhost", "root", "", "disarm");

$result = $conn->query("SELECT type, latitude, longitude FROM file_details");

$outp = "[";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"Type":"'  . $rs["type"] . '",';
    $outp .= '"Latitude":"'   . $rs["latitude"]        . '",';
    $outp .= '"Longitude":"'. $rs["longitude"]     . '"}'; 
}
$outp .="]";

$conn->close();

echo($outp);
?>