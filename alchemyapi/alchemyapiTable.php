<html>
<head>
<title>Analysis of text data</title>
<script>
function homeButton(){
   window.location.assign('../index.php'); //back to home page
}
</script>
</head>
<body>
<button onclick="homeButton()">Back to Home</button>
<br>
<br>
<?php
	$file = file_get_contents('../all.txt', true);
    require_once 'alchemyapi.php';
    $alchemyapi = new AlchemyAPI();
?>
<form name="entity" action="?page=entity" method="POST" autocomplete="off">
  <table border = '1px solid black' style="border-collapse: collapse; width: 960px;">
    <tr>
      <th> Entity </th>
      <th> Type </th>
    </tr>
<?php
    $response = $alchemyapi->entities('text', $file , null);
    foreach ($response['entities'] as $entity) {
?>
	<tr>
      <td> <?= (string) $entity['text'] ?> </td>
      <td> <?= (string) $entity['type'] ?> </td>
    </tr>
<?php
    }
?>
</table>
</form>
<form name="entity" action="?page=entity" method="POST" autocomplete="off">
  <table border = '1px solid black' style="border-collapse: collapse; width: 960px;">
    <tr>
      <th> Keyword </th>
      <th> Relevance </th>
      <th> Sentiment </th>
    </tr>
<?php
	echo '<br>';
    $response = $alchemyapi->keywords('text', $file , array('sentiment'=>1));
    foreach ($response['keywords'] as $keyword) {
?>
<tr>
      <td> <?= (string) $keyword['text'] ?> </td>
      <td> <?= (float) $keyword['relevance'] ?> </td>
      <td> <?= (string) $keyword['sentiment']['type'] ?> </td>
    </tr>
	
<?php
    }
?>
</table>
</form>
<body>
</html>