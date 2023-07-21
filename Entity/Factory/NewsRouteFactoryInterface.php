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

namespace Havex\Bundle\SuluNewsBundle\Entity\Factory;

use Sulu\Bundle\RouteBundle\Model\RouteInterface;
use Havex\Bundle\SuluNewsBundle\Entity\News;

interface NewsRouteFactoryInterface
{
    public function generateNewsRoute(News $news): RouteInterface;

    public function updateNewsRoute(News $news, string $routePath): RouteInterface;
}
