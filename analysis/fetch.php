<html>
<head>
<title>Fetch text from multiple file</title>
<script>
function homeButton(){
   window.location.assign('../index.php');
}
</script>
</head>
<body>
<button onclick="homeButton()">Back to Home</button>
</body>
</html>
<?php
if(!empty($_POST)) {
    $start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	echo '<h2>Files between time interval '.$start_date.' and '.$end_date.' are:</h2>';
}
?>
<?php
function db_connect() {
    $conn = mysql_connect("localhost", "root", "");
    mysql_select_db("disarm", $conn);
}
db_connect(); // establish database connection
$erase_all_data = fopen ("all.txt", "w+"); //open text file to erase all data (if any)
fclose($erase_all_data); //close file
// creating the current path 
$path = dirname(__FILE__);
// the trailing slash for windows or linux
$path .= (substr($path, 0, 1) == "/") ? "/sync/" : "\\sync\\";
$files=mysql_query("SELECT filename FROM file_details WHERE ts Between '$start_date' and '$end_date'") or die(mysql_query);
// set array
$file_array = array();
// look through query
while($row = mysql_fetch_assoc($files)){
  $file_array[] = $row; // add each row returned into an array
}
$file_names = array_column($file_array, 'filename'); //modify and put all file name in a single array.
//print single array
echo '<pre>';
print_r($file_names);
echo '</pre>';
//put text of all text files of the array in a single text file
foreach ($file_names as $val) {
		$ext = pathinfo($path.$val, PATHINFO_EXTENSION); //get file extension
		if ($ext == "txt") //check if file is text file or not
		{
		$file_content = file_get_contents($path.$val); //if text file then get the content to store in database
		file_put_contents("all.txt", " ".$file_content, FILE_APPEND); // put file content to a text file
		}
}

/*
// debug:
	echo'<br><br><br>';
	echo '<pre>';
	print_r($file_array); // show all array data
	echo '</pre>';
*/
?>