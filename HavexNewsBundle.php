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

namespace Havex\Bundle\SuluNewsBundle;

use Sulu\Bundle\PersistenceBundle\PersistenceBundleTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Havex\Bundle\SuluNewsBundle\Entity\NewsInterface;

class HavexNewsBundle extends Bundle
{
    use PersistenceBundleTrait;

    public function build(ContainerBuilder $container): void
    {
        $this->buildPersistence(
            [
                NewsInterface::class => 'sulu.model.havex.news.class',
            ],
            $container
        );
    }
}
