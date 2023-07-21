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

namespace Havex\Bundle\SuluNewsBundle\Routing;

use Sulu\Bundle\RouteBundle\Routing\Defaults\RouteDefaultsProviderInterface;
use Havex\Bundle\SuluNewsBundle\Entity\HavexNews;
use Havex\Bundle\SuluNewsBundle\Repository\HavexNewsRepository;

class NewsRouteDefaultProvider implements RouteDefaultsProviderInterface
{
    public function __construct(private readonly NewsRepository $newsRepository)
    {
    }

    public function getByEntity($entityClass, $id, $locale, $object = null)
    {
        return [
            '_controller' => 'sulu_havex_news.controller::indexAction',
            'news' => $object ?: $this->newsRepository->findById((int) $id),
        ];
    }

    public function isPublished($entityClass, $id, $locale)
    {
        /** @var HavexNews $news */
        $news = $this->newsRepository->findById((int) $id);
        if (!$this->supports($entityClass) || !$news instanceof HavexNews) {
            return false;
        }

        return $news->isEnabled();
    }

    public function supports($entityClass)
    {
        return HavexNews::class === $entityClass;
    }
}
