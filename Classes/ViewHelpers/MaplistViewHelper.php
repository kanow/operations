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

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

 class MaplistViewHelper extends AbstractViewHelper {

     use CompileWithRenderStatic;

     protected $escapeOutput = false;

     public function initializeArguments()
     {
         $this->registerArgument('objects', '\TYPO3\CMS\Extbase\Persistence\QueryResultInterface', 'The QueryResultinterface', true);
         $this->registerArgument('settings', 'array', 'Settings', true);
         $this->registerArgument('as', 'string', 'Render content as', true);
     }

	/**
	 *
	 * @param array $arguments
	 * @param \Closure $renderChildrenClosure
	 * @param RenderingContextInterface $renderingContext
	 * @return string
	 */

	public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
		
		// get the location data from QueryResultInterface
		foreach ($arguments['objects'] as $singleElement) {
			if($singleElement->getLatitude() && $singleElement->getLongitude()) {
				
				$longitudes = $singleElement->getLongitude();
				$latitudes = $singleElement->getLatitude();
				
					$this->templateVariableContainer->add($arguments['as'], $singleElement);
					$description = $this->renderChildren();
					$this->templateVariableContainer->remove($arguments['as']);
				
				$locations .= '[\''.$description.'\','.$latitudes.','.$longitudes.'],';
			}
		}
		
		$overrideLatList = $arguments['settings']['map']['overrideCenterLatList'];
		$overrideLongList = $arguments['settings']['map']['overrideCenterLongList'];
		$overrideZoomList = $arguments['settings']['map']['overrideZoomList'];

		$bounds = "var bounds = new google.maps.LatLngBounds();\n";
		$fitBounds = "map.fitBounds(bounds);";
		$extendBounds = "bounds.extend(myLatLng);\n";
		// if override centering and zoom
		if($overrideLatList && $overrideLongList && $overrideZoomList) {
			$fitBounds = "";
			$extendBounds = "";
			$overrideCentering = "center: new google.maps.LatLng($overrideLatList,$overrideLongList),\n";
			$overrideZoom = "zoom:$overrideZoomList,\n";
		} else {
			$overrideCentering = "";
			$overrideZoom ="";
		}

		$locations = 'var locations = ['.substr($locations,0,-1).'];';

		$mapOptions = "var mapOptions = {\n
			$overrideZoom
			$overrideCentering
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
		

		$map = "var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);";
		$infowindow = "var infowindow = new google.maps.InfoWindow();\n";
		$markerI = "var marker, i;\n";
		$markers = "var markers = new Array();\n";
		
		$loopToAddMarkersAndCentering = "for (i = 0; i < locations.length; i++) {\n
		var myLatLng = new google.maps.LatLng(locations[i][1], locations[i][2]);\n
		$extendBounds
    marker = new google.maps.Marker({\n
      position: myLatLng,\n
      map: map\n
    });\n
    markers.push(marker);\n
    google.maps.event.addListener(marker, 'click', (function(marker, i) {\n
      return function() {\n
        infowindow.setContent(locations[i][0]);\n
        infowindow.open(map, marker);\n
      }\n
    })(marker, i));\n
		$fitBounds
  }\n";

		$initialize = "\n function initialize() {\n $bounds \n $mapOptions \n $map \n $infowindow \n $markerI \n $markers \n $loopToAddMarkersAndCentering \n }\n";
		
		$apikey = $arguments['settings']['map']['apikey'];
		if($apikey) {
			$src = "http://maps.googleapis.com/maps/api/js?key=$apikey&sensor=false&callback=initialize";
		} else {
			$src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
		}
		 
		$loadScript = "\nfunction loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = '$src';
  document.body.appendChild(script);
}
window.onload = loadScript;";
		
		
$mapData = '<script type="text/javascript">'.$locations.$initialize.$loadScript.'</script>';
		
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($map);
		return $mapData;
	}
}

