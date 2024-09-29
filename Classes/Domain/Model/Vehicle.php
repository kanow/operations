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
class Vehicle extends AbstractEntity
{
    /**
     * Title of vehicle
     *
     * @var string
     */
    #[Validate(['validator' => 'NotEmpty'])]
    protected string $title;

    /**
     * Abbreviation of vehicle
     *
     * @var string
     */
    protected string $short;

    /**
     * Description of vehicle
     *
     * @var string
     */
    protected string $description;

    /**
     * Media
     * @var ObjectStorage<FileReference>
     */
    protected ObjectStorage $media;

    /**
     * A website url or internal link
     *
     * @var string
     */
    protected string $link;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the short
     *
     * @return string $short
     */
    public function getShort(): string
    {
        return $this->short;
    }

    /**
     * Sets the short
     *
     * @param string $short
     */
    public function setShort(string $short): void
    {
        $this->short = $short;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns the media
     *
     * @return ObjectStorage<FileReference> $media
     */
    public function getMedia(): ObjectStorage
    {
        return $this->media;
    }

    /**
     * Returns the first media
     *
     * @return FileReference $media
     */
    public function getFirstMedia(): FileReference
    {
        $media = $this->getMedia()->toArray();
        return $media[0];
    }

    /**
     * Sets the media
     *
     * @param ObjectStorage<FileReference> $media
     */
    public function setMedia(ObjectStorage $media): void
    {
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
