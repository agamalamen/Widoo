function getCurrentLocation() {
	event.preventDefault();
	if($('#location').val() == 'current_location') {
		if(navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var pos = [position.coords.latitude, position.coords.longitude];
			console.log(pos);
			window.location = "/projects/bookings-sa/browse/" + "current-location/" + $("#industry").val() +
			 "?lat=" + pos[0] + "&lng=" + pos[1];
			});
		}
	} else {
		window.location = "/projects/bookings-sa/browse/" + $("#location").val() + "/" + $("#industry").val();
	}
}

$("#pick-time-date").change(function(event){
    var date = $('#pick-time-date').val();

    var weekday = ["Sun","Mon","Tues","Wed","Thu","Fri","Sat"];

	var a = new Date(date);
	var day = weekday[a.getDay()];

	window.location = "/projects/bookings-sa/checkout/" + service + "/pick-time?day=" + day + "&date=" + date;

	//checkout/{service}/pick-time

});

jQuery(function($) {
    // Asynchronously Load the map API
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyD5EzOhPNUpDIGhUTWHSzpNW4vyvaT_IL8&callback=initialize";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };

    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);


    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

    // Loop through our array of markers & place each one on the map
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0],
            icon: markers[i][3],
        });

        // Allow each marker to have an info window
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(10);
        google.maps.event.removeListener(boundsListener);
    });

}

$(document).on('click','#star',function(){
		var rate = $(this).children().text();
		window.location = "/projects/bookings-sa/actions/rating/" + businessId + "/" + rate;
});
