<?php

namespace Havex\Bundle\SuluNewsBundle\Tests\Unit\Twig;

use PHPUnit\Framework\TestCase;
use Havex\Bundle\SuluNewsBundle\Repository\NewsRepository;
use Havex\Bundle\SuluNewsBundle\Tests\Unit\Traits\Entity\NewsTrait;
use Havex\Bundle\SuluNewsBundle\Twig\NewsTwigExtension;

class NewsTwigExtensionTest extends TestCase
{
    use NewsTrait;

    public function testResolveNewsFunction()
    {
        $repoMock = $this->createMock(NewsRepository::class);
        $repoMock->method('find')->willReturn($this->generateNewsWithContent());
        $newsTwigExtension = new NewsTwigExtension($repoMock);
        $news = $newsTwigExtension->resolveNewsFunction(1);

        self::assertSame($news->getTitle(), 'Test Title');
        self::assertSame($news->getTeaser(), 'Test Teaser');
    }

    public function testResolveNewsFunctionEmpty()
    {
        $repoMock = $this->createMock(NewsRepository::class);
        $repoMock->method('find')->willReturn(null);
        $newsTwigExtension = new NewsTwigExtension($repoMock);
        $news = $newsTwigExtension->resolveNewsFunction(1);

        self::assertNull($news);
    }
}
