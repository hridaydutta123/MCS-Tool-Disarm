<?php
	$file = file_get_contents('../all.txt', true);
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../css/wordCloud.css"/>
    <script type="text/javascript" src="../js/wordCloud.js"></script>
    <script type="text/javascript" src="../js/jsapi.js"></script>
	<script type="text/javascript">
      google.load("visualization", "1");
      google.setOnLoadCallback(draw);
      function draw() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Text1');
        data.addRows(1);
        data.setCell(0, 0, '<?php echo json_encode($file); ?>');
        var outputDiv = document.getElementById('wcdiv');
        var wc = new WordCloud(outputDiv);
        wc.draw(data, null);
      }
    </script>
  </head>
  <body>
    <div id="wcdiv" style = "width: 1065px;"></div>
  </body>
</html>