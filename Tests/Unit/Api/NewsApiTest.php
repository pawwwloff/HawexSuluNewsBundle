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

namespace Havex\Bundle\SuluNewsBundle\Tests\Unit\Api;

use PHPUnit\Framework\TestCase;
use Havex\Bundle\SuluNewsBundle\Entity\HavexHavexNews;
use Havex\Bundle\SuluNewsBundle\Tests\Unit\Traits\Api\NewsTrait;

/**
 * @internal
 *
 * @coversNothing
 */
final class NewsApiTest extends TestCase
{
    use NewsTrait;

    public function testEmptyApiDto(): void
    {
        $apiDto = $this->generateEmptyApiNews();

        static::assertInstanceOf(HavexHavexNews::class, $apiDto->getEntity());

        static::assertNull($apiDto->getId());
        static::assertNull($apiDto->getTitle());
        static::assertNull($apiDto->getTeaser());
        static::assertSame([], $apiDto->getHeader());
        static::assertSame([], $apiDto->getContent());
        static::assertNull($apiDto->getPublishedAt());
        static::assertSame([], $apiDto->getTags());
        static::assertSame('', $apiDto->getRoutePath());
    }

    public function testApiDtoWithContent(): void
    {
        $apiDto = $this->generateApiNewsWithContent();

        static::assertInstanceOf(HavexHavexNews::class, $apiDto->getEntity());

        static::assertSame(1, $apiDto->getId());
        static::assertSame('Test Title', $apiDto->getTitle());
        static::assertSame('Test Teaser', $apiDto->getTeaser());
        static::assertSame(
            [
                [
                    'type' => 'title',
                    'title' => 'Test',
                ],
                [
                    'type' => 'editor',
                    'text' => '<p>Test Editor</p>',
                ],
            ],
            $apiDto->getContent()
        );
        static::assertSame('2017-08-31 00:00:00', $apiDto->getPublishedAt()->format('Y-m-d H:i:s'));
        static::assertSame('/test-1', $apiDto->getRoutePath());
    }
}
