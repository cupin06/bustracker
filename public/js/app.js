var map = new GMaps({
	el: '#map',
	lat: 3.159271,
	lng: 101.701358,
	zoom: 16
});

/*map.addMarker({
	lat: 3.159236,
	lng: 101.701775,
	title: 'University Kuala Lumpur',
	infoWindow: {
		content: '<p>University Kuala Lumpur</p>'
	}
});

map.addMarker({
	lat: 3.124816,
	lng: 101.673439,
	title: 'Hostel Perempuan',
	infoWindow: {
		content: '<p>Hostel Perempuan</p>'
	}
});

map.addMarker({
	lat: 3.119816,
	lng: 101.665262,
	title: 'Hostel Lelaki',
	infoWindow: {
		content: '<p>Hostel Lelaki</p>'
	}
});*/

/*****************************/
/* Custom Gmaps.js functions */
/*****************************/
var gMarkers = [], realMarkers = [];

GMaps.prototype.addMarkersOfType = function (poi_type) {
	// save the relevant map
	var theMap = this.map;
	// clear markers of this type
	realMarkers[poi_type]=[];
	// for each Gmaps marker
	$.each(gMarkers[poi_type],function(index, obj){
		// add the marker
		var marker = map.addMarker(obj);
		// save it as real marker
		realMarkers[poi_type].push(marker);
	});
};

GMaps.prototype.removeMarkersOfType = function (poi_type) {
	// for each real marker of this type
	$.each(realMarkers[poi_type],function(index, obj){
		// remove the marker
		obj.setMap(null);
	});
	// clear markers of this type
	realMarkers[poi_type]=[];
};

gMarkers['bus_route'] = [
	{lat:"3.119816",lng:"101.665262",infoWindow:{content:"<p>Hostel Lelaki</p>"},icon:"images/hotel.png"},
	{lat:"3.124816",lng:"101.673439",infoWindow:{content:"<p>Hostel Perempuan</p>"},icon:"images/hotel.png"},
	{lat:"3.159236",lng:"101.701775",infoWindow:{content:"<p>University Kuala Lumpur</p>"},icon:"images/unikl.png"}
];
map.addMarkersOfType('bus_route');

map.drawRoute({
	origin: [3.119816, 101.665262],
	destination: [3.124816, 101.673439],
	travelMode: 'driving',
	strokeColor: '#131540',
	strokeOpacity: 0.6,
	strokeWeight: 8
});

map.drawRoute({
	origin: [3.122985, 101.676168],
	destination: [3.159236, 101.701775],
	travelMode: 'driving',
	strokeColor: '#131540',
	strokeOpacity: 0.6,
	strokeWeight: 8
});

map.drawRoute({
	origin: [3.159236, 101.701775],
	destination: [3.124816, 101.673439],
	travelMode: 'driving',
	strokeColor: '#131540',
	strokeOpacity: 0.6,
	strokeWeight: 8
});

map.drawRoute({
	origin: [3.122985, 101.676168],
	destination: [3.119816, 101.665262],
	travelMode: 'driving',
	strokeColor: '#131540',
	strokeOpacity: 0.6,
	strokeWeight: 8
});


