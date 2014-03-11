/*
function initialize() {
       var mapOptions = {
         center: new google.maps.LatLng(-34.397, 150.644),
         zoom: 8
       };
       var map = new google.maps.Map(document.getElementById("map-canvas"),
           mapOptions);
     }
     google.maps.event.addDomListener(window, 'load', initialize);
*/


function initialize() {
	var coordination = new google.maps.LatLng(51.753403, 11.023974);
	
  var mapOptions = {
    zoom: 11,
    center: coordination,
		//panControl: true,
	  zoomControl: false,
	  mapTypeControl: true,
		mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    },
	  //scaleControl: true,
	  streetViewControl: false,
	  overviewMapControl: true
  };


	var infowindow = new google.maps.InfoWindow({
	    content: 'Hier meine Beschreibung.<br />HTML funzt hier auch'
	});



  var map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
			
	var marker = new google.maps.Marker({
	    position: coordination,
			map: map,
	    title:'Hier war der Einsatz'
	});
	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.open(map,marker);
	});


	// To add the marker to the map, call setMap();
	//marker.setMap(map);
		 
			
			
}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' +
      'callback=initialize';
  document.body.appendChild(script);
}

window.onload = loadScript;