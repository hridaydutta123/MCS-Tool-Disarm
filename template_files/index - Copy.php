<html>
<head>
<title>DISARM</title>
<style Type = "text/css">
html, body { height:100%; margin:0; padding:0 }
div { position:fixed; width:33.33%; height:50% }
#NW { top:0;   left:0;   background:black  }
#NM { top:0;   left:33.33%;   background:gray  }
#NE { top:0;   left:66.67%; background:black    }
#SW { top:50%; left:0;   background:gray   }
#SM { top:50%; left:33.33%;   background:black  }
#SE { top:50%; left:66.67%; background:gray     } 
h2 {padding-left: 10px; font-family:verdana; font-size:18px; color: white;}
bott {padding-left: 10px;}

input#round, button#round{
border : solid 1px #e6e6e6;
	border-radius : 3px;
	moz-border-radius : 3px;
	-webkit-box-shadow : 0px 0px 2px rgba(0,0,0,1.0);
	-moz-box-shadow : 0px 0px 2px rgba(0,0,0,1.0);
	box-shadow : 0px 0px 2px rgba(0,0,0,1.0);
	font-size : 20px;
	color : #696869;
	padding : 1px 17px;
	background : #ffffff;
	background : -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(49%,#f1f1f1), color-stop(51%,#e1e1e1), color-stop(100%,#f6f6f6));
	background : -moz-linear-gradient(top, #ffffff 0%, #f1f1f1 49%, #e1e1e1 51%, #f6f6f6 100%);
	background : -webkit-linear-gradient(top, #ffffff 0%, #f1f1f1 49%, #e1e1e1 51%, #f6f6f6 100%);
	background : -o-linear-gradient(top, #ffffff 0%, #f1f1f1 49%, #e1e1e1 51%, #f6f6f6 100%);
	background : -ms-linear-gradient(top, #ffffff 0%, #f1f1f1 49%, #e1e1e1 51%, #f6f6f6 100%);
	background : linear-gradient(top, #ffffff 0%, #f1f1f1 49%, #e1e1e1 51%, #f6f6f6 100%);
	filter : progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f6f6f6',GradientType=0 );

}
</style>
<script>
function open_script(){
   window.location.assign('inputData.php');
}
</script>
<script>
function alchemyAPI(){
   window.location.assign('alchemyapi/alchemyapiTable.php');
}
</script>
<script>
function plot(){
   window.location.assign('map/plot.php');
}
function analysis(){
   window.location.assign('analysis/analysis.php');
}
</script>

<script>  // script to fetch text data using ajax
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","getText.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<div id="NW">
	<h2>Click the Sync button to Sync the data with database</h2>
	<bott><button id="round" onclick="open_script()">Sync</button></bott>
</div>
<div id="NM">
	<h2>Click the AlchemyAPI button to text analysis</h2>
	<bott><button id="round" onclick="alchemyAPI()">AlchemyAPI</button></bott>
</div>
<div id="NE">
<h2>Click the Sync button to Sync the data with database</h2>
	<bott><button id="round" onclick="analysis()">Analysis</button></bott>
</div>
<div id="SW">
	<h2>Click the Fetch button to fetch text from text files</h2>
	<form action="fetch.php" method="post">
		<bott><input type="text" name="start_date" value="2015-06-02 00:48:36"><br><br></bott>
		<bott><input type="text" name="end_date" value="2015-06-02 00:48:56"/><br><br></bott>
		<bott><input id="round" type="submit" value="Fetch" name="submit" /></bott>
	</form>
</div>
<div id="SM">
	<h2>Click the Plot button to plot latitude and longitude on map</h2>
	<bott><button id="round" onclick="plot()">Plot</button></bott>
</div>
<div id="SE">
<h2>Select text file from list to see the text message</h2>
<form>
<bott><select style="font-size : 11.5px; height: 30px;" name="users" onchange="showUser(this.value)">
<option value="" disabled selected>Select your option</option>
<?php
$mysqlserver="localhost";
$mysqlusername="root";
$mysqlpassword="";
$link=mysql_connect(localhost, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysql_error());

$dbname = 'disarm';
mysql_select_db($dbname, $link) or die ("Error selecting specified database on mysql server: ".mysql_error());

$cdquery="SELECT filename FROM file_details where type = 'TXT'";
$cdresult=mysql_query($cdquery) or die ("Query to get data from firsttable failed: ".mysql_error());

while ($cdrow=mysql_fetch_array($cdresult)) {
$cdTitle=$cdrow["filename"];
echo '<option value="'.$cdTitle.'">'.$cdTitle.'</option>';	
}  
?>
</select></bott>
</form>
<br>
<div id="txtHint"><bott><b>Text will be shown here...</b></bott></div>
</div>
<body>
</html>