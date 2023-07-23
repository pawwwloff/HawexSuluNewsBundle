<?php

declare(strict_types=1);

/*
 * This file is part of TheCadien/SuluNewsBundle.
 *
 * by Oliver Kossin and contributors.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Havex\Bundle\SuluNewsBundle\Api;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Sulu\Component\Rest\ApiWrapper;
use Havex\Bundle\SuluNewsBundle\Entity\HavexNews as NewsEntity;

/**
 * The HavexNews class which will be exported to the API.
 *
 * @ExclusionPolicy("all")
 */
class HavexNews extends ApiWrapper
{
    public function __construct(NewsEntity $contact, $locale)
    {
        // @var NewsEntity entity
        $this->entity = $contact;
        $this->locale = $locale;
    }

    /**
     * Get id.
     *
     * @VirtualProperty
     *
     * @SerializedName("id")
     * @Groups({"fullHavexNews"})
     */
    public function getId(): ?int
    {
        return $this->entity->getId();
    }

    /**
     * @VirtualProperty
     *
     * @SerializedName("title")
     * @Groups({"fullHavexNews"})
     */
    public function getTitle(): ?string
    {
        return $this->entity?->getTitle();
    }

    /**
     * @VirtualProperty
     *
     * @SerializedName("teaser")
     * @Groups({"fullHavexNews"})
     */
    public function getTeaser(): ?string
    {
        return $this->entity->getTeaser();
    }

    /**
     * @VirtualProperty
     *
     * @SerializedName("content")
     * @Groups({"fullHavexNews"})
     */
    public function getContent(): array
    {
        if (!$this->entity->getContent()) {
            return [];
        }

        return $this->entity->getContent();
    }

    /**
     * @VirtualProperty
     *
     * @SerializedName("enabled")
     * @Groups({"fullHavexNews"})
     */
    public function isEnabled(): bool
    {
        return $this->entity?->isEnabled();
    }

    /**
     * @VirtualProperty
     *
     * @SerializedName("publishedAt")
     * @Groups({"fullHavexNews"})
     */
    public function getPublishedAt(): ?\DateTime
    {
        return $this->entity?->getPublishedAt();
    }

    /**
     * @VirtualProperty
     *
     * @SerializedName("route")
     * @Groups({"fullHavexNews"})
     */
    public function getRoutePath(): ?string
    {
        if ($this->entity?->getRoute()) {
            return $this->entity->getRoute()?->getPath();
        }

        return '';
    }

    /**
     * Get tags.
     *
     * @VirtualProperty
     *
     * @SerializedName("tags")
     * @Groups({"fullHavexNews"})
     */
    public function getTags(): array
    {
        return $this->entity->getTagNameArray();
    }

    /**
     * Get the contacts avatar and return the array of different formats.
     *
     * @VirtualProperty
     *
     * @SerializedName("header")
     * @Groups({"fullHavexNews"})
     */
    public function getHeader(): array
    {
        if ($this->entity->getHeader()) {
            return [
                'id' => $this->entity->getHeader()->getId(),
            ];
        }

        return [];
    }

    /**
     * Get tags.
     *
     * @VirtualProperty
     *
     * @SerializedName("authored")
     * @Groups({"fullHavexNews"})
     */
    public function getAuthored(): \DateTime
    {
        return $this->entity->getCreated();
    }

    /**
     * Get tags.
     *
     * @VirtualProperty
     *
     * @SerializedName("created")
     * @Groups({"fullHavexNews"})
     */
    public function getCreated(): \DateTime
    {
        return $this->entity->getCreated();
    }

    /**
     * Get tags.
     *
     * @VirtualProperty
     *
     * @SerializedName("changed")
     * @Groups({"fullHavexNews"})
     */
    public function getChanged(): \DateTime
    {
        return $this->entity->getChanged();
    }

    /**
     * Get tags.
     *
     * @VirtualProperty
     *
     * @SerializedName("author")
     * @Groups({"fullHavexNews"})
     */
    public function getAuthor(): ?int
    {
        return $this->entity?->getCreator()?->getId();
    }

    /**
     * Get tags.
     *
     * @VirtualProperty
     *
     * @SerializedName("ext")
     * @Groups({"fullHavexNews"})
     */
    public function getSeo(): array
    {
        $seo = ['seo'];
        $seo['seo'] = $this->getEntity()->getSeo();

        return $seo;
    }
}
