<?php
namespace Kanow\Operations\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
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
class Resource extends AbstractEntity {

	/**
	 * Title of resource
	 *
	 * @var string
	 * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
	 */
	protected $title;

	/**
	 * Abbreviation title
	 *
	 * @var string
	 */
	protected $short;

	/**
	 * Description of resource
	 *
	 * @var string
	 */
	protected $description;

	/**
		* Media
   	* @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
   	*/
  	protected $media;

    /**
     * A website url or internal link
     *
     * @var string
     */
    protected $link;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the short
	 *
	 * @return string $short
	 */
	public function getShort() {
		return $this->short;
	}

	/**
	 * Sets the short
	 *
	 * @param string $short
	 * @return void
	 */
	public function setShort($short) {
		$this->short = $short;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

  /**
    * Returns the media
    *
    * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage $media
    */
   public function getMedia() {
      return $this->media;
   }
  /**
   * Returns all media
   *
   * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $media
   */
  public function getAllMedia() {
    $allMedia = $this->getMedia()->toArray();
    return $allMedia;
  }
  /**
   * Returns the first media
   *
   * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $media
   */
  public function getFirstMedia() {
    $media = $this->getMedia()->toArray();
    return $media[0];
  }
  /**
   * Sets the media
   *
   * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $media
   * @return void
   */
  public function setMedia($media) {
      $this->media = $media;
  }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

}
