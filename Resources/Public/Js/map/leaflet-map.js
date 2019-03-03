// See post: http://asmaloney.com/2014/01/code/creating-an-interactive-map-with-leaflet-and-openstreetmap/

var map = L.map( 'leaflet-map', {
  center: [20.0, 5.0],
  minZoom: 2,
  zoom: 2
})

L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
  subdomains: ['a', 'b', 'c']
}).addTo( map )

var mapData = jQuery('.leaflet-map').data('map');

var myIcon = L.icon({
  iconUrl: mapData.mapFolder + 'images/pin24.png',
  iconRetinaUrl: mapData.mapFolder + 'images/pin48.png',
  iconSize: [29, 24],
  iconAnchor: [9, 21],
  popupAnchor: [0, -14]
})

markers = [];
jQuery('.list-item').each(function() {
  markers.push(jQuery(this).data('marker'))
});

for ( var i=0; i < markers.length; ++i )
{
  markerUri = markers[i].uri;
  markerTitle = markers[i].title;
  markerTeaser = markers[i].teaser;
 L.marker( [markers[i].lat, markers[i].lng], {icon: myIcon} )
  .bindPopup( '<a href="' + markerUri + '">' + markerTitle + '</a>' + '<p>' + markerTeaser + '</p>'  )
  .addTo( map );
}
