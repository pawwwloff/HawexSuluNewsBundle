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

namespace Havex\Bundle\SuluNewsBundle\Service\News;

use Havex\Bundle\SuluNewsBundle\Entity\HavexNews;

interface NewsServiceInterface
{
    public function saveNewNews(array $data, string $locale): HavexNews;

    public function updateNews($data, HavexNews $article, string $locale): HavexNews;
}
