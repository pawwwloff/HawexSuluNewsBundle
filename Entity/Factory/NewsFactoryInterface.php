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

use Havex\Bundle\SuluNewsBundle\Entity\HavexHavexNews;

interface NewsFactoryInterface
{
    public function generateNewsFromRequest(HavexHavexNews $news, array $data, string $locale): HavexHavexNews;
}
