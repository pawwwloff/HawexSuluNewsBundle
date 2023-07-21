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

namespace Havex\Bundle\SuluNewsBundle\Tests\Unit\Traits\Api;

use Havex\Bundle\SuluNewsBundle\Api\News as ApiNews;

/**
 * Trait NewsTrait.
 */
trait NewsTrait
{
    use \Havex\Bundle\SuluNewsBundle\Tests\Unit\Traits\Entity\HavexNewsTrait;

    public function generateEmptyApiNews(): ApiNews
    {
        return new ApiNews($this->generateEmptyNews(), 'de');
    }

    public function generateApiNewsWithContent(): ApiNews
    {
        return new ApiNews($this->generateNewsWithContent(), 'de');
    }
}
