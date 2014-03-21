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

//var Lat = 51.753403 ,Lang =11.023974,Desc='Hier meine Beschreibung.<br />HTML funzt hier auch'; 
function initialize() {
	var coordination = new google.maps.LatLng(Lat,Lang);
	
  var mapOptions = {
    zoom: Zoom,
    center: coordination,
		//panControl: true,
	  zoomControl: true,
	  zoomControlOptions: {
	  	style:google.maps.ZoomControlStyle.SMALL,
		position: google.maps.ControlPosition.TOP_LEFT
	  },
	mapTypeControl: true,
	mapTypeControlOptions: {
		style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
	},
	  //scaleControl: true,
	  streetViewControl: false,
	  overviewMapControl: true
  };


	var infowindow = new google.maps.InfoWindow({
	    content:Desc
	});



  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			
	var marker = new google.maps.Marker({
	position: coordination,
	map: map,
//	title:'Hier war der Einsatz'
	});
	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.open(map,marker);
	});

			
}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' +
      'callback=initialize';
  document.body.appendChild(script);
}

window.onload = loadScript;
