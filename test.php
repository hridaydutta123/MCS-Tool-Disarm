<?php
require("script/dbConnect.php"); //Connect to database
$query1= "SELECT MIN(ts) 'ts' FROM file_details WHERE 1";
											$result1= mysql_query($query1);
											while($row=mysql_fetch_array($result1)) {
											echo '<input type="text" name="start_date" value="'.$row['ts'].'">';
											}
											
											
											
											
											
											SELECT filename, foodname, qty FROM `food` WHERE filename in(SELECT filename FROM file_details WHERE ts Between '2015-07-01 23:49:10' and '2015-07-01 23:51:26') ORDER BY `food`.`foodname` ASC
?>