<?php
namespace Kanow\Operations\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Karsten Nowak <captnnowi@gmx.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package operations
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Type extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Operation type
	 *
	 * @var \string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $title;

	/**
	 * icon for use in list or for whatever
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $image;

    /**
     * Type color
     *
     * @var \string
     */
    protected $color;

	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
   * Returns the image
   *
   * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
   */
  public function getImage() {
          return $this->image;
  }
  /**
   * Returns all images
   *
   * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
   */
  public function getAllImages() {
    $images = $this->getImage()->toArray();
    return $images;
  }
  /**
   * Returns the first image
   *
   * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
   */
  public function getFirstImage() {
  $image = $this->getImage()->toArray();
    return $image[0];
  }
  /**
   * Sets the image
   *
   * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
   * @return void
   */
  public function setImage($image) {
          $this->image = $image;
  }
    /**
     * Returns the color
     *
     * @return \string $color
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Sets the color
     *
     * @param \string $color
     * @return void
     */
    public function setColor($color) {
        $this->title = $color;
    }

}