<?php
require("script/dbConnect.php"); //Connect to database
$query1= "SELECT MIN(ts) 'tsmin', MAX(ts) 'tsmax' FROM file_details WHERE 1";
$result1= mysql_query($query1);
while($row1=mysql_fetch_array($result1)) {
$tsmin=$row1['tsmin'];
$tsmax=$row1['tsmax'];
}
/*$interval=60; //minutes
set_time_limit(0);
while (true)
{
    $now=time();
    include("directorySize.php");
    sleep($interval*10-(time()-$now));
}
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Master Control Station Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
	/*Select and input box style*/
	.selectwidthauto
	{
     width:auto !important;
	 margin-bottom: 10px;
	 margin-top: 10px;
	}
    </style>
<!-- Ajax Script to get district wise block name -->
<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
    }
	function getState(district) {		
		
		var strURL="findBlock.php?district="+district;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('blockdiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">MCS Dashboard</a>
            </div>
            <!-- Top Menu Items -->
            
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="inputData.php"><i class="glyphicon glyphicon-refresh"></i> Sync</a>
                    </li>
                    <li>
                        <a href="analysis/sAnalysis.php"><i class="fa fa-fw fa-bar-chart-o"></i> Analysis - Graphical</a>
                    </li>
                    <li>
                        <a href="analysis/tAnalysis.php"><i class="fa fa-fw fa-table"></i> Analysis - Tabular</a>
                    </li>
                    <li>
                        <a href="analysis/mAnalysis.php"><i class="glyphicon glyphicon-map-marker"></i> Visualize on map</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#customQueries"><i class="fa fa-fw fa-edit"></i> Custom Queries<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="customQueries" class="collapse">
							<li>
								<a href="javascript:;" data-toggle="collapse" data-target="#byDateTime"><i class="fa fa-fw fa-calendar"></i> Date & Time</a>
							</li>

							<ul id="byDateTime" class="collapse">
									<form action="custom/date.php" method="post">
									<?php
										echo '<input class="form-control selectwidthauto" type="text" name="start_date" value="'.$tsmin.'">';
										echo '<input class="form-control selectwidthauto" type="text" name="end_date" value="'.$tsmax.'">';
									?>
									<input class="form-control selectwidthauto" id="round" type="submit" value="Submit" name="submit" />
									</form>
							</ul>
							<li>
								<a href="javascript:;" data-toggle="collapse" data-target="#byBlock"><i class="fa fa-fw fa-group"></i> Block</a>
							</li>

							<ul id="byBlock" class="collapse">
									<form action="custom/block.php" method="post">
										<select name="district" class="form-control selectwidthauto" id="sel1" onChange="getState(this.value)">
											<option value="">Select District</option>
											<!-- Fetch District from dataBase-->
											<?php
											$query= "SELECT district from affected_areas where 1 group by district";
											$result= mysql_query($query);
											while($row=mysql_fetch_array($result)) {
											echo '<option value="'.$row['district'].'">'.$row['district'].'</option>';
											}
											?>
										  </select>
										  <!-- Fetch District from dataBase via Ajax call-->
										  <div id="blockdiv">
											<select name="block" class="form-control selectwidthauto" id="sel1">
												<option value="">Select District First</option>
											</select>
										</div>
										<?php
											echo '<input class="form-control selectwidthauto" type="text" name="start_date" value="'.$tsmin.'">';
											echo '<input class="form-control selectwidthauto" type="text" name="end_date" value="'.$tsmax.'">';
										?>
										<input class="form-control selectwidthauto" id="round" type="submit" value="Submit" name="submit" />
									</form>
							</ul>
							<li>
								<a href="javascript:;" data-toggle="collapse" data-target="#byRequirement"><i class="fa fa-fw fa-question"></i> Requirement</a>
							</li>

							<ul id="byRequirement" class="collapse">
									<form action="custom/requirement.php" method="post">
										<select name="requirementType" class="form-control selectwidthauto" id="sel1" onChange="getState(this.value)">
											<option value="food">Food</option>
											<option value="medicine">Medicine</option>
											<option value="shelter">Shelter</option>
										  </select>
										<?php
											echo '<input class="form-control selectwidthauto" type="text" name="start_date" value="'.$tsmin.'">';
											echo '<input class="form-control selectwidthauto" type="text" name="end_date" value="'.$tsmax.'">';
										?>
										<input class="form-control selectwidthauto" id="round" type="submit" value="Submit" name="submit" />
									</form>
							</ul>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-desktop"></i> File Viewer<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="#">Audio</a>
                            </li>
                            <li>
                                <a href="#">Video</a>
                            </li>
                            <li>
                                <a href="#">Image</a>
                            </li>
                            <li>
                                <a href="viewText.php">Text</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="generateReport.php"><i class="fa fa-fw fa-file-text-o"></i> Generate Report</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Sync
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="../index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-medkit"></i> Sync
                            </li>
                        </ol>
                    </div>
                </div>
				<div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="glyphicon glyphicon-refresh"></i> Sync Result</h3>
                            </div>
                            <div class="panel-body">
<?php
ini_set('max_execution_time', 0); //set execution time limit unlimited.
// a sinple function to create a database connection
function db_connect() {
    $conn = mysql_connect("localhost", "root", "");
    mysql_select_db("disarm", $conn);
}
// this function will open the chosen directory and returns and array with all filenames
function select_files($dir) {
    if (is_dir($dir)) {
        if ($handle = opendir($dir)) {
            $files = array();
            while (false !== ($file = readdir($handle))) {
                if (is_file($dir.$file) && $file != basename($_SERVER['PHP_SELF'])) $files[] = $file;
            }
            closedir($handle);
            if (is_array($files)) sort($files);
            return $files;
        }
    }
} 
// this function inserts the filename, type, Time to leave, the modification date of the current file etc in file_details table
function insert_file_record($name, $type, $ttl, $c_id, $r_id, $latitude, $longitude, $ts, $size, $mod_date, $serial, $file_content) {
    $sql = sprintf("INSERT INTO file_details SET filename = '%s', type = '%s', ttl = '%s', c_id = '%s', r_id = '%s', latitude = '%s', longitude = '%s', ts = '%s', size = '%s', lastdate = '%s', serial_no = '%s', text = '%s'", $name, $type, $ttl, $c_id, $r_id, $latitude, $longitude, $ts, $size, $mod_date, $serial, $file_content);
    if (mysql_query($sql)) {
        return true;
    } else {
        return false;
    }
}

// this function inserts the fileid, filename, medicine name, quantity in medicine table
function insert_health_record($fileid, $filename, $itemname, $qty) {
    $sql = sprintf("INSERT INTO medicine SET fileid = '%s',filename = '%s', medname = '%s', qty = '%d'",$fileid, $filename, $itemname, $qty);
    if (mysql_query($sql)) {
        return true;
    } else {
        return false;
    }
}

// this function inserts the fileid, filename, type etc in shelter table
function insert_shelter_record($fileid, $filename, $itemname, $a_temp, $a_material, $gov_support, $other_source) {
    $sql = sprintf("INSERT INTO shelter SET fileid = '%s',filename = '%s', type = '%s', a_temp = '%s', a_material = '%s', gov_support = '%s', other_source = '%s'",$fileid, $filename, $itemname, $a_temp, $a_material, $gov_support, $other_source);
    if (mysql_query($sql)) {
        return true;
    } else {
        return false;
    }
}
// this function inserts the fileid, filename, district name, block name in affected_areas table
function insert_areas_record($fileid, $filename, $district, $block, $latitude, $longitude, $s_area, $characteristic, $worst_affected, $cond) {
    $sql = sprintf("INSERT INTO affected_areas SET fileid = '%s',filename = '%s', district = '%s', block = '%s', latitude = '%s', longitude = '%s', s_area = '%s', characteristic = '%s', worst_affected = '%s', cond = '%s'",$fileid, $filename, $district, $block, $latitude, $longitude, $s_area, $characteristic, $worst_affected, $cond);
    if (mysql_query($sql)) {
        return true;
    } else {
        return false;
    }
}
// this function inserts the fileid, filename, type, quantity in victim table
function insert_victims_record($fileid,$filename, $itemname, $qty) {
    $sql = sprintf("INSERT INTO victim SET fileid = '%s',filename = '%s', type = '%s', qty = '%d'",$fileid, $filename, $itemname, $qty);
    if (mysql_query($sql)) {
        return true;
    } else {
        return false;
    }
}
// this function inserts the fileid, filename, food name, quantity in food table
function insert_food_record($fileid,$filename, $itemname, $qty) {
    $sql = sprintf("INSERT INTO food SET fileid = '%s',filename = '%s', foodname = '%s', qty = '%d'",$fileid, $filename, $itemname, $qty);
    if (mysql_query($sql)) {
        return true;
    } else {
        return false;
    }
}


// establish database connection
db_connect();

$erase_all_data = fopen ("all.txt", "w+"); //open text file to erase all data (if any)
fclose($erase_all_data); //close file

$file_content = NULL; //declare variable to avoid warning at insert data (if others file came before text file)

// creating the current path 
$path = dirname(__FILE__);
// the trailing slash for windows or linux
$path .= (substr($path, 0, 1) == "/") ? "/sync/" : "\\sync\\";
// get the filenames from the directory
$file_array = select_files($path);
// creating some controle variables and arrays
$num_files = count($file_array);
$success = 0;
$error_array = array();
// if the file array is not empty the loop will start
if ($num_files > 0) {
    foreach ($file_array as $val) {
        $fdate = date("Y-m-d", filectime($path.$val)); //extract file modified date
		/*$type = substr($val, 0, -44);  //extract file type
		$ttl = substr($val, 4, -41);  //extract time to live
		$c_id = substr($val, 7, -30);  //extract creator id
		$r_id = substr($val, 18, -19);  //extract receiver id
		$ts_p = substr($val, 29, -4);   //extract time stamp as integer
		*/
		list($type, $ttl, $c_id, $r_id, $latitude, $longitude, $ts_p, $serial) = explode("_", $val); //extract value separated by "_" in each variable
		$serial_new = substr($serial, 0, -4); //removing extension from last variable value.
		$ts_date = DateTime::createFromFormat('YmdHis', $ts_p); //define time stamp number format
		$ts = $ts_date->format("Y-m-d H:i:s"); //convert and store time stamp as date time format
		$size = filesize($path.$val);  //get file size
		$ext = pathinfo($path.$val, PATHINFO_EXTENSION); //get file extension
		if ($ext == "txt") //check if file is text file or not
		{

      $handle = fopen($path.$val, "r"); //open text file in read mode
      $i = 0;
      if ($handle) {
          while (($line = fgets($handle)) !== false) {
              $i+=1;
              $fileid = $val.$i;
			  $segments = explode(":", $line);
				if (count($segments) == 3) {
				list($itemtype, $itemname, $itemqty) = $segments;
				} elseif (count($segments) == 6) {
				list($itemtype, $itemname, $a_temp, $a_material, $gov_support, $other_source) = $segments;	
				} elseif (count($segments) == 7) {
				list($itemtype, $district, $block, $s_area, $characteristic, $worst_affected, $cond) = $segments;	
				}
				else {
				//error in listing data
				}
             //Send data to insert in medicine table
              if($itemtype == "Health"){
                if(insert_health_record($fileid, $val, $itemname, $itemqty)){
                };
              }
				//Send data to insert in shelter table
              if($itemtype == "Shelter"){
                if(insert_shelter_record($fileid, $val, $itemname, $a_temp, $a_material, $gov_support, $other_source)){
                };
              }
			  //Send data to insert in affected_areas table
			  if($itemtype == "Affected Areas"){
                if(insert_areas_record($fileid, $val, $district, $block, $latitude, $longitude, $s_area, $characteristic, $worst_affected, $cond)){
                };
              }
			  //Send data to insert in victim table
			  if($itemtype == "Victims"){
                if(insert_victims_record($fileid, $val, $itemname, $itemqty)){
                };
              }
				//Send data to insert in food table
              if($itemtype == "Food"){
                if(insert_food_record($fileid, $val, $itemname, $itemqty)){
                };
              }
          }

          fclose($handle);
      } else {
          // error opening the file.
      } 
		}
		
		if ($type == "SMS") //check if file is unstructured text file or not
		{
			$file_content = file_get_contents($path.$val); //if unstructured text file then get the content to store in database
			file_put_contents("all.txt", " ".$file_content, FILE_APPEND); // put file content to a text file
		}
		
		//Send data to insert in file_details table
        if (insert_file_record($val, $type, $ttl, $c_id, $r_id, $latitude, $longitude, $ts, $size, $fdate, $serial_new, $file_content)) {
            $success++;
			$file_content = NULL;
			
        } else {
            $error_array[] = $val;
        }   
    }
    echo "Copied ".$success." of ".$num_files." files...<br>"; //display no of files copied to database
    if (count($error_array) > 0) 
	{
		echo "Sync is done.";
	//echo "The following data are already present in database.<br><br>";
	//echo '<pre>';
	//print_r($error_array);
	//echo '</pre>';
	
	}
} else {
    echo "No files or error while opening directory";
}
?>
								
                            </div>
                        </div>
                    </div>
                </div>
				<!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
