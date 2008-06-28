<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps</title>
<style type="text/css">
      @import url("http://www.google.com/uds/css/gsearch.css");
      @import url("http://www.google.com/uds/solutions/localsearch/gmlocalsearch.css");
      }
    </style>
    
  </head>
  <body onunload="GUnload()">

    <div id="map" style="width: 800px; height: 600px"></div>
    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>



    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAoUgKPk_fHY98eQMOpa564hRMrNOVSW71a4LeZVP0bwJUASptARSipR_BivpiNo82ukJ7codHgA08sA" 
      type="text/javascript"></script>
    <script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0" type="text/javascript"></script>

    <script src="http://www.google.com/uds/solutions/localsearch/gmlocalsearch.js" type="text/javascript"></script>  
    <script src="http://www.acme.com/javascript/OverlayMessage.js" type="text/javascript"></script>
    <script type="text/javascript">



    //<![CDATA[

    if (GBrowserIsCompatible()) {

      // display the loading message
      var om = new OverlayMessage(document.getElementById('map'));      
      om.Set('<b>Caricamento...</b>');
      

      

      var icon = new GIcon();
      icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
      icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
      icon.iconSize = new GSize(12, 20);
      icon.shadowSize = new GSize(22, 20);
      icon.iconAnchor = new GPoint(6, 20);
      icon.infoWindowAnchor = new GPoint(5, 1);      

      iconblue = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_blue.png"); 
      icongreen = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_green.png"); 
      iconyellow = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_yellow.png"); 
		iconred = new GIcon(icon,"http://labs.google.com/ridefinder/images/mm_20_red.png"); 

      function createMarker(point,html,icon) {
        var marker = new GMarker(point, {icon:icon});
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }

      // new strategy - read the XML first, THEN create the map

	
      // read the markers from the XML
      
     GDownloadUrl("map_xml.php", function (doc) {
        var gmarkers = [];  
 	var ropes = [];    
        var xmlDoc = GXml.parse(doc);
        var markers = xmlDoc.documentElement.getElementsByTagName("marker");
	var old_la='41.8041';
        var old_lo='12.7002';  
        for (var i = 0; i < markers.length; i++) {
          // obtain the attribues of each marker
	        var lat = parseFloat(markers[i].getAttribute("lat"));
        	var lng = parseFloat(markers[i].getAttribute("lon"));
	        var point = new GLatLng(lat,lng);
		var timestamp=markers[i].getAttribute("timestamp");
		var html= "Timestamp: <b>" + timestamp + "</b><br />" ;
          	var marker = createMarker(point,html,iconred);
             	gmarkers.push(marker);


		var polyline = new GPolyline([
  		  new GLatLng(old_la,old_lo),
  		  new GLatLng(lat,lng)
		], "#ff0000", 10);
		ropes.push(polyline);
		 old_la = parseFloat(markers[i].getAttribute("lat"));
		 old_lo = parseFloat(markers[i].getAttribute("lon"));
        }

        // Display the map, with some controls and set the initial location 

        var map = new GMap2(document.getElementById("map"));
	//var lsc = new google.maps.LocalSearch(); 
	//map.addControl(new google.maps.LocalSearch());
	map.addControl(new google.maps.LocalSearch(), new GControlPosition(G_ANCHOR_BOTTOM_RIGHT, new GSize(10,20)));
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(41.8061861111,12.7022027778), 16, G_MAP_TYPE);
        var mm = new GMarkerManager(map, {borderPadding:1});


        mm.addMarkers(gmarkers,8,17);
        mm.refresh();

	var polyline = new GPolyline([
  		  new GLatLng(41.8061861111,12.7022027778),
  		  new GLatLng(41.9061861111,12.8022027778)
		], "#ff0000", 10);

	for (var i = 0; i < ropes.length; i++) {

		map.addOverlay(ropes[i]);
	}
		

        om.Clear(); // Clear the loading message
      });
    }

    // display a warning if the browser was not compatible
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }
  

    
    //]]>
    </script>
  </body>

</html>

