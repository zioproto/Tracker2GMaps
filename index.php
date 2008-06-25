<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php

$mysql = new mysqli('localhost', 'tracker', 'yourpasswordhere', 'tracker');
$results = $mysql->query("SELECT * FROM positions");
echo "Numero posizioni: ".$results->num_rows."<br />";
$i = 1;
while($row = $results->fetch_assoc())
{
    sprintf("%d. %s %s <br />", $i, $row['lat'], $row['lon']);
    ++$i;
} 

?>

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example: Map Markers</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAACggU4V4EJTy6fbFxrBctrhTfnFi14kPUhkd9fcPKQiookKo3RxRCdCRZiXc0ky2UESBLV8nklJY6aA"
            type="text/javascript"></script>
    <script type="text/javascript">
    
    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(41.8819, 12.1419), 7);
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());

        // Add 10 markers to the map at random locations
        var bounds = map.getBounds();
        var southWest = bounds.getSouthWest();
        var northEast = bounds.getNorthEast();
        var lngSpan = northEast.lng() - southWest.lng();
        var latSpan = northEast.lat() - southWest.lat();
<?php
$query = "SELECT lat,lon FROM positions";

$results = $mysql->query($query);

while($row = $results->fetch_assoc())
//$row = $results->fetch_assoc();
{

++$i;
?>

          var point = new GLatLng(<?php echo $row['lat']?>,
                                  <?php echo $row['lon']?>);
          map.addOverlay(new GMarker(point));

<?php

}
?>
        }
      }
    

    </script>
  </head>

  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: 500px; height: 300px"></div>
  </body>
</html>

