<?php
require("script/dbConnect.php"); //Connect to database
$query1= "SELECT MIN(ts) 'tsmin', MAX(ts) 'tsmax' FROM file_details WHERE 1";
$result1= mysql_query($query1);
while($row1=mysql_fetch_array($result1)) {
$tsmin=$row1['tsmin'];
$tsmax=$row1['tsmax'];
}
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


    <link href="css/prettyPhoto.css" rel="stylesheet">

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
	.view-image
	{
    -webkit-box-shadow: 0px 0px 10px #4d4d4d;
    -moz-box-shadow: 0px 0px 10px #4d4d4d;
    box-shadow: 0px 0px 10px #4d4d4d;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -khtml-border-radius: 8px;  
    border-radius: 8px;
    border:solid #fff 1px;
    overflow: hidden;
    padding: 1px;
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
                            Image
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="../index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-medkit"></i> Image
                            </li>
                        </ol>
                    </div>
                </div>
				<div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-blue">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="glyphicon glyphicon-refresh"></i> Image Result </h3>
                            </div>
                            <div class="panel-body">
                                    <form>
                                    <?php
                                    
                                        $mysqlserver="localhost";
                                        $mysqlusername="root";
                                        $mysqlpassword="password";
                                        $link=mysql_connect(localhost, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysql_error());

                                        $dbname = 'disarm';
                                        mysql_select_db($dbname, $link) or die ("Error selecting specified database on mysql server: ".mysql_error());

                                        $cdquery="SELECT filename FROM file_details where type = 'IMG'";
                                        $cdresult=mysql_query($cdquery) or die ("Query to get data from firsttable failed: ".mysql_error());

                                        $j=0;
                                        while ($cdrow=mysql_fetch_array($cdresult)) {
                                            $cdTitle = $cdrow["filename"];
    //<a href="images/fullscreen/2.jpg" rel="prettyPhoto" title="This is the description"><img src="images/thumbnails/t_2.jpg" width="60" height="60" alt="This is the title" /></a>

                                            echo '<a href="sync/'.$cdTitle.'" rel="prettyPhoto"><img class="view-image" width="100" height="100" src="sync/'.$cdTitle.'"/></a>&nbsp;&nbsp;&nbsp;' ;  
                                         }

                                    ?>
                                    </form>
                                
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
    <script src="js/jquery.prettyPhoto.js"></script>
    <script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				

				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
				$("a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
	</script>		
</body>

</html>
