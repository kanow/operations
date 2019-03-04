// See post: http://asmaloney.com/2014/01/code/creating-an-interactive-map-with-leaflet-and-openstreetmap/

var mapData = jQuery('.leaflet-map').data('map');
console.log(mapData.zoomControl);
var map = L.map( 'leaflet-map', {
    // center and zoom ahs to be set manually if no fitBounds is activated
    // center: [50.0, 11.0],
    // zoom: 8
    zoomControl: mapData.zoomControl
});

L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  subdomains: ['a', 'b', 'c']
}).addTo( map )

var myIcon = L.icon({
  iconUrl: mapData.mapFolder + 'images/operations-pin24.png',
  iconRetinaUrl: mapData.mapFolder + 'images/operations-pin48.png',
  iconSize: [16, 24],
  iconAnchor: [16, 24],
  popupAnchor: [-8, -20],
});



// get markers(items) from each item and push it to an array
var markers = [];
if(jQuery('.leaflet-map.single').length > 0)
{
    markers.push(jQuery('.leaflet-map.single').data('marker'));
} else {
    jQuery('.list-item').each(function() {
        markers.push(jQuery(this).data('marker'))
    });
}


// automatically zoom and centering depending of markers
var arrayOfLatLngs = [];
for (var i=0; i < markers.length; ++i)
{
    arrayOfLatLngs.push([markers[i].lat, markers[i].lng]);
}
var bounds = new L.LatLngBounds(arrayOfLatLngs);
map.fitBounds(bounds);


if(jQuery('.leaflet-map.single').length > 0)
{
    // set content for popup
    for ( var i=0; i < markers.length; ++i )
    {
        markerTitle = markers[i].title;
        L.marker( [markers[i].lat, markers[i].lng], {icon: myIcon} )
            .bindPopup( '<p>' + markerTitle + '</p>'  )
            .addTo( map );
    }
} else {
    // set content for popup
    for ( var i=0; i < markers.length; ++i )
    {
        markerUri = markers[i].uri;
        markerTitle = markers[i].title;
        markerTeaser = markers[i].teaser;
        L.marker( [markers[i].lat, markers[i].lng], {icon: myIcon} )
            .bindPopup( '<a href="' + markerUri + '">' + markerTitle + '</a>' + '<p>' + markerTeaser + '</p>'  )
            .addTo( map );
    }
}

