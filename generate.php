<?php
$con=mysql_connect("localhost","root","password") or die("Failed to connect with database!!!!");
mysql_select_db("disarm", $con);
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=report.csv');

	if(isset($_POST['formSubmit'])) 
    {
		$food = $_POST['Food'];
		$medicine = $_POST['Medicine'];
		$victim = $_POST['Victim'];
		$affected = $_POST['Affected'];
		$shelter = $_POST['Shelter'];
    }

if($food==true)
{
	
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
// output the column headings
fputcsv($output, array('Food Name', 'Quantity'));
// fetch the data
$rows = mysql_query('SELECT foodname, SUM(qty) as quantity FROM food GROUP BY foodname');
// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
}

if($medicine==true)
{
	
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Medicine Name', 'Quantity'));
// fetch the data
$rows = mysql_query('SELECT medname, SUM(qty) as quantity FROM medicine GROUP BY medname');
// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);

}



if($victim==true)
{
	
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Victim Type', 'Quantity'));
// fetch the data
$rows = mysql_query('SELECT type, SUM(qty) as quantity FROM victim GROUP BY type');
// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
}



if($affected==true)
{
	
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('District', 'Block', 'Area Specification', 'Socio-economic Characteristics', 'Worst-affected', 'Condition'));
// fetch the data
$rows = mysql_query('SELECT district, block, s_area, characteristic, worst_affected, cond FROM affected_areas ORDER BY district');
// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
}
if($shelter==true)
{
	
// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Type', 'Temporary Shelter Available', 'Building Material Available', 'Support from Local Government'));
// fetch the data
$rows = mysql_query('SELECT type, a_temp, a_material, gov_support FROM shelter ORDER BY type');
// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
}

?>
