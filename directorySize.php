<?php
// Directory
$directory = "sync/";

// Returns array of files
$files = scandir($directory);

// Count number of files and store them to variable..
$num_files = count($files)-2;
 echo '<script type="text/javascript">alert("' . $num_files . '")</script>';
?>