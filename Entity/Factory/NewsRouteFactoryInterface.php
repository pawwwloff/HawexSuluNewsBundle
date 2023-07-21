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
use Havex\Bundle\SuluNewsBundle\Entity\HavexNews;

interface NewsRouteFactoryInterface
{
    public function generateNewsRoute(HavexNews $news): RouteInterface;

    public function updateNewsRoute(HavexNews $news, string $routePath): RouteInterface;
}
