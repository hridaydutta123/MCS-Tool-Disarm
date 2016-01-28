<?php
$district=$_GET['district'];
require("script/dbConnect.php"); //Connect to database
// Query to populate block list
$query="SELECT block FROM affected_areas WHERE district='$district' group by block ORDER BY block";
$result=mysql_query($query);
?>
<select name="block" class="form-control selectwidthauto">
<option value="">Select Block</option>
<?php 
while($row=mysql_fetch_array($result)) {
echo '<option value="'.$row['block'].'">'.$row['block'].'</option>';
}
?>
</select>