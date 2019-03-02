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
	* google map for operation
	*/
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

 class MapsingleViewHelper extends AbstractViewHelper {

     protected $escapeOutput = false;

     use CompileWithRenderStatic;

     public function initializeArguments()
     {
         $this->registerArgument('object', '\KN\Operations\Domain\Model\Operation', 'The Operation object', true);
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
		$coordinates = "var Coordinates = new google.maps.LatLng(".$arguments['object']->getLatitude().",".$arguments['object']->getLongitude().");";
		
		if($arguments['object']->getZoom()) {
			$zoom = $arguments['object']->getZoom();
		} else {
			$zoom = $arguments['settings'][map][defaultZoomSingle];
		}
		
		$this->templateVariableContainer->add($arguments['as'], $arguments['object']);
		$description = $this->renderChildren();
		$this->templateVariableContainer->remove($arguments['as']);
		
		($arguments['settings']['map']['styles']!='')?$mapStyles = ",\nstyles: [".$arguments['settings']['map']['styles']."]\n":$mapStyles = "\n";
		$mapOptions = "var mapOptions = {\n
    zoom:$zoom,\n
    center: Coordinates,\n
		//panControl: true,\n
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
	  overviewMapControl: true" . $mapStyles . "
	  
  };\n";
		
		$map = "var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);";
		
		$infowindow = "var infowindow = new google.maps.InfoWindow({\n
	    content:'$description'\n
	});\n";
		
		$marker = "var marker = new google.maps.Marker({\n
		position: Coordinates,\n
		map: map,\n
	});\n";
		
		$addListener = "google.maps.event.addListener(marker, 'click', function() {\n
	  infowindow.open(map,marker);\n
	});\n";

		$initialize = "function initialize() {".$coordinates."\n".$mapOptions."\n".$map."\n".$infowindow."\n".$marker."\n".$addListener."}";
		
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

$mapData = '<script type="text/javascript">'.$initialize.$loadScript.'</script>';
		
		//\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($map);
		return $mapData;
	}
}

