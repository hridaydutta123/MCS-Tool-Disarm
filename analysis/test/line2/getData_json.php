<?php

// This is just an example of reading server side data and sending it to the client.
// It reads a json formatted text file and outputs it.

$string = file_get_contents(“sampleData_json.json”);
echo $string;

// Instead you can query your database and parse into JSON etc etc

?>

Finally here is the JSON data file ‘sampleData_json.json’:
{
“cols”: [
{"id":"","label":"year","type":"string"},
{"id":"","label":"sales","type":"number"},
{"id":"","label":"expenses","type":"number"}
],
“rows”: [
{"c":[{"v":"2001"},{"v":3},{"v":5}]},
{“c”:[{"v":"2002"},{"v":5},{"v":10}]},
{“c”:[{"v":"2003"},{"v":6},{"v":4}]},
{“c”:[{"v":"2004"},{"v":8},{"v":32}]},
{“c”:[{"v":"2005"},{"v":3},{"v":56}]}
]
}