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

namespace Havex\Bundle\SuluNewsBundle\Tests\Unit\Traits\Entity;

use DateTime;
use Sulu\Bundle\RouteBundle\Entity\Route;
use Havex\Bundle\SuluNewsBundle\Entity\HavexHavexNews;

/**
 * Trait NewsTrait.
 */
trait NewsTrait
{
    public function generateEmptyNews(): HavexHavexNews
    {
        return new HavexHavexNews();
    }

    public function generateNewsWithContent(): HavexHavexNews
    {
        $news = new HavexHavexNews();
        $contentArray = $this->generateNewsContentArray();

        $news->setId($contentArray['id']);
        $news->setTitle($contentArray['title']);
        $news->setTeaser($contentArray['teaser']);
        $news->setContent($contentArray['content']);
        $news->setEnabled($contentArray['enable']);
        $news->setLocale($contentArray['locale']);
        $news->setRoute($contentArray['route']);
        $news->setPublishedAt(DateTime::createFromFormat('Y-m-d H:i:s', $contentArray['publishedAt']));

        return $news;
    }

    public function generateNewsContentArray(): array
    {
        return [
            'id' => 1,
            'title' => 'Test Title',
            'teaser' => 'Test Teaser',
            'content' => [
                [
                    'type' => 'title',
                    'title' => 'Test',
                ],
                [
                    'type' => 'editor',
                    'text' => '<p>Test Editor</p>',
                ],
            ],
            'locale' => 'en',
            'route' => new Route('/test-1', 1, HavexHavexNews::class, 'en'),
            'enable' => true,
            'publishedAt' => '2017-08-31 00:00:00',
        ];
    }

    public function generateSecondNewsWithContent(): HavexHavexNews
    {
        $news = new HavexHavexNews();
        $contentArray = $this->generateSecondNewsContentArray();

        $news->setId($contentArray['id']);
        $news->setTitle($contentArray['title']);
        $news->setTeaser($contentArray['teaser']);
        $news->setContent($contentArray['content']);
        $news->setEnabled($contentArray['enable']);
        $news->setLocale($contentArray['locale']);
        $news->setRoute($contentArray['route']);
        $news->setPublishedAt(DateTime::createFromFormat('Y-m-d H:i:s', $contentArray['publishedAt']));

        return $news;
    }

    public function generateSecondNewsContentArray(): array
    {
        return [
            'id' => 2,
            'title' => 'Test',
            'teaser' => 'Test',
            'content' => [
                [
                    'type' => 'title',
                    'title' => 'Test',
                ],
                [
                    'type' => 'editor',
                    'text' => '<p>Test Editor</p>',
                ],
            ],
            'locale' => 'en',
            'route' => new Route('/test-2', 2, HavexHavexNews::class, 'en'),
            'enable' => true,
            'publishedAt' => '2017-08-31 00:00:00',
        ];
    }

    public function generateNewsContentArrayWithoutContent(): array
    {
        return [
            'id' => 3,
            'title' => 'Test',
            'teaser' => 'Test',
            'content' => [],
            'locale' => 'en',
            'route' => new Route('/test-3', 3, HavexHavexNews::class, 'en'),
            'enable' => true,
            'publishedAt' => '2017-08-31 00:00:00',
        ];
    }
}
