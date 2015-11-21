<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bus Tracker</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="http://maps.google.com/maps/api/js?key=AIzaSyARWwkONQ4RXXVJrrYRBCaOtYrp9hAg2sU"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="map"></div>
<div id="currentLocation">
    <h3>Current Location</h3>
    <b>Address:</b> <span id="address"></span><br />
    <b>Latitude:</b> <span id="latitude"></span><br />
    <b>Longitude:</b> <span id="longitude"></span><br />
    <b>Estimated Arrival Time:</b> <span id="arrival_time"></span><br />
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script src="js/gmaps/gmaps.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/app.js"></script>
<script>
    var es = new EventSource("<?php echo action('GpsController@polingGPSData'); ?>");

    es.addEventListener("message", function(e) {
        var gpsData = JSON.parse(e.data);

        $('#latitude').text(gpsData.latitude);
        $('#longitude').text(gpsData.longitude);
        $('#address').text(gpsData.address);
        var arrivalTime = parseInt(gpsData.estimated_duration.replace(/^\D+/g, ''));
        $('#arrival_time').text(arrivalTime + ' minutes');
        console.log(realMarkers['current_location']);
        if (realMarkers['current_location']) {
            map.removeMarkersOfType('current_location');
        }

        gMarkers['current_location'] = [
            {lat:gpsData.latitude,lng:gpsData.longitude,infoWindow:{content:"<p>Hostel Lelaki</p>"},icon:"images/bus.png"}
        ];
        map.addMarkersOfType('current_location');
        map.setCenter(gpsData.latitude, gpsData.longitude);
        console.log(e.data);
    }, false);
</script>
</body>
</html>