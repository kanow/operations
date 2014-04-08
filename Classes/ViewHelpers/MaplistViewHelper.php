<?php
namespace KN\Operations\ViewHelpers;

/*                                                                        *
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

	/**
	* list for google maps items
	*/

 class MaplistViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $objects
	 * @param array $settings
	 * @param string $description content for infowindow
	 * @return string
	 */

	public function render(\TYPO3\CMS\Extbase\Persistence\QueryResultInterface $objects,$settings,$description=NULL) {
		
		// get the location data from QueryResultInterface
		foreach ($objects as $singleElement) {
			if($singleElement->getLatitude() && $singleElement->getLongitude()) {
				
				$longitudes = $singleElement->getLongitude();
				$latitudes = $singleElement->getLatitude();
				
				if(!$description) {
					$description = $singleElement->getTitle();
				}
				
				$locations .= '["'.$description.'",'.$latitudes.','.$longitudes.'],';
				
				//$mapData = 'var Lat = new Array('.substr($longitudes,0,-1).'), Lang = new Array('.substr($latitudes,0,-1).'), Desc = new Array('.substr($description,0,-1).')';
			}
		}
		
		$locations;
		$locations = 'var locations = ['.substr($locations,0,-1).'];';
		
		$bounds;
		$bounds = "var bounds = new google.maps.LatLngBounds();\n";
		
		$mapOptions;
		$mapOptions = "var mapOptions = {\n
		  zoomControl: true,\n
		  zoomControlOptions: {\n
		  	style:google.maps.ZoomControlStyle.SMALL,\n
			position: google.maps.ControlPosition.TOP_LEFT\n
		  },\n
		mapTypeControl: true,\n
		mapTypeControlOptions: {\n
			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU\n
		},\n
		  //scaleControl: true,\n
		  streetViewControl: false,\n
		  overviewMapControl: true\n
	  };\n";
		
		$map;
		$map = "var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);";
		
		$infowindow;
		$infowindow = "var infowindow = new google.maps.InfoWindow();\n";
		
		$markerI;
		$markerI = "var marker, i;\n";
		
		$markers;
		$markers = "var markers = new Array();\n";
		
		$loopToAddMarkersAndCentering;
		$loopToAddMarkersAndCentering = "for (i = 0; i < locations.length; i++) {\n
		var myLatLang = new google.maps.LatLng(locations[i][1], locations[i][2]);\n
		bounds.extend(myLatLang);\n
		
    marker = new google.maps.Marker({\n
      position: myLatLang,\n
      map: map\n
    });\n

    markers.push(marker);\n

    google.maps.event.addListener(marker, 'click', (function(marker, i) {\n
      return function() {\n
        infowindow.setContent(locations[i][0]);\n
        infowindow.open(map, marker);\n
      }\n
    })(marker, i));\n
		
		map.fitBounds(bounds);
  }";

		
		// if overrideZoom set
		$overrideZoom;
		if($settings['map']['overrideZoom']) {
			$overrideZoom = "var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {\n
      this.setZoom(".$settings[map][overrideZoom].");\n
      google.maps.event.removeListener(boundsListener);\n
  });\n";
		}
		
		
		
		$initialize;
		$initialize = "function initialize() {".$bounds."\n".$mapOptions."\n".$map."\n".$infowindow."\n".$markerI."\n".$markers."\n".$loopToAddMarkersAndCentering."\n".$overrideZoom."}";
		
		$loadScript;
		$loadScript = "\nfunction loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' +
      'callback=initialize';
  document.body.appendChild(script);
}
window.onload = loadScript;";
		
		
$mapData = '<script type="text/javascript">'.$locations.$initialize.$loadScript.'</script>';
		
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($map);
		return $mapData;
	}
}

?>
