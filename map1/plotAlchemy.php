<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Google Maps MarkerClusterer for food request</title>
<style type="text/css">
.map-infowindow {
    border:3px ridge blue;
    padding:6px;
}
</style>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://localhost/disarm/map/js/markerclusterer.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
var customIcons = {
      AUD: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      IMG: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
	  VID: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
	  TXT: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_gray.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };
	
function initialize(elementId, stateAbbr) {
    var callback = function (data, status, xhr) {
        //data will be the xml returned from the server
        if (status == 'success') {
            createMap(elementId, data);
        }
    };
    //using jQuery to fire off an ajax request to load the xml,
    //using our callback as the success function
    $.ajax(
        {
            url : 'http://localhost/disarm/map/fetchAlchemy.php',
            data : 'state='+ stateAbbr,
            dataType : 'xml',
            success : callback
        }
    );
}

function createMap(elementId, xml) {
    var i, xmlMarker, icon, type, lat, lng, latLng,
        mapAlchemy = new google.maps.Map(
            document.getElementById(elementId),
            {
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        ),
        infoWindow = new google.maps.InfoWindow({maxWidth:800}),
        xmlMarkers = xml.getElementsByTagName('marker'),
        markers = [],
        latlngs = [],
        bounds = new google.maps.LatLngBounds();
    //private function, for scope retention purposes
    function createMarker(latlng, icon) {
        latlngs.push(latlng);
        var marker = new google.maps.Marker({
            position: latlng,
            map: mapAlchemy,
			icon: icon.icon,
            shadow: icon.shadow
        });
        google.maps.event.addListener(
            marker,
            "click",
            function () {
                var info = '<div class="map-infowindow"><h4 class="map-info-title">Latitude and Longitude<br>';
                info += latLng +'</h4>';
                infoWindow.setContent(info);
                infoWindow.open(mapAlchemy, marker);
            }
        );
        markers.push(marker);
    }
    for (i = 0; i < xmlMarkers.length; i++) {
        xmlMarker = xmlMarkers[i];
        //lat & lng in the xml file are strings, convert to Number
        lat = Number(xmlMarker.getAttribute('lat'));
        lng = Number(xmlMarker.getAttribute('lng'));
		type = xmlMarker.getAttribute("type");
		icon = customIcons[type] || {};
        latLng = new google.maps.LatLng(lat, lng);
        createMarker(
            latLng,
			icon
        );
    }
    markerCluster = new MarkerClusterer(mapAlchemy, markers);
    for (i = 0; i < latlngs.length; i++) {
        bounds.extend(latlngs[i]);
    }
    mapAlchemy.fitBounds(bounds);
    return mapAlchemy;
}

google.maps.event.addDomListener(
    window,
    'load',
    function () {
        initialize('mapAlchemy', 'FL');
        buildStatesSelect();
    }
);

</script>
</head>
<body>
	<div id="mapAlchemy" style="width: 100%; height:400px;"></div>
</body>
</html>