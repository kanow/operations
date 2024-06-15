<?php

namespace Kanow\Operations\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Type extends AbstractEntity
{
    /**
  * Operation type
  *
  * @var string
  */
    #[Validate(['validator' => 'NotEmpty'])]
    protected $title;

    /**
  * icon for use in list or for whatever
  *
  * @var FileReference
  */
    protected $image;

    /**
     * Type color
     *
     * @var string
     */
    protected $color;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
   * Returns the image
   *
   * @return FileReference $image
   */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param ObjectStorage $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }
    /**
     * Returns the color
     *
     * @return string $color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Sets the color
     *
     * @param string $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

}
