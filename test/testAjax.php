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
   window.location.assign('alchemyapi_php-master/alchemyapiTest.php');
}
</script>
<script>
function plot(){
   window.location.assign('map/plot.php');
}
</script>
<script>
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


<form>
<select name="users" onchange="showUser(this.value)">
<option value="" disabled selected>Select your option</option>
<?php
$mysqlserver="localhost";
$mysqlusername="root";
$mysqlpassword="";
$link=mysql_connect(localhost, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysql_error());

$dbname = 'disarm';
mysql_select_db($dbname, $link) or die ("Error selecting specified database on mysql server: ".mysql_error());

$cdquery="SELECT filename FROM file_details";
$cdresult=mysql_query($cdquery) or die ("Query to get data from firsttable failed: ".mysql_error());

while ($cdrow=mysql_fetch_array($cdresult)) {
$cdTitle=$cdrow["filename"];
echo '<option value="'.$cdTitle.'">'.$cdTitle.'</option>';
	
}
   
?>
</select>
</form>
<br>
<div id="txtHint"><b>Person info will be listed here...</b></div>


<body>
</html>