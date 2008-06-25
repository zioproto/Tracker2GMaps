<?php
require("dbinfo.php");
header("Content-type: text/xml");
// Start XML file, create parent node
//$doc = domxml_new_doc("1.0");

$doc = new DOMDocument('1.0', 'iso-8859-1');


$node = $doc->createElement("markers");
$parnode = $doc->appendChild($node);

// Opens a connection to a mySQL server
$connection=mysql_connect ('78.47.245.243', $username, $password);
if (!$connection) {
  die('Not connected : ' . mysql_error());
}

// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}


$query = "SELECT *
FROM `positions`
";


//echo $query."</br>";
$result = mysql_query($query);

if (!$result) {
  die('Invalid query: ' . mysql_error());
}



// Iterate through the rows, adding XML nodes for each
while ($row = @mysql_fetch_assoc($result)){
  // ADD TO XML DOCUMENT NODE
  $node = $doc->createElement("marker");
  $newnode = $parnode->appendChild($node);

  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lon", $row['lon']);
  $newnode->setAttribute("timestamp", $row['timestamp']);
}
echo $doc->saveXML();
?>
