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

namespace Havex\Bundle\SuluNewsBundle\Twig;

use Havex\Bundle\SuluNewsBundle\Entity\HavexNews;
use Havex\Bundle\SuluNewsBundle\Repository\HavexNewsRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Extension to handle news in frontend.
 */
class NewsTwigExtension extends AbstractExtension
{
    public function __construct(
        private readonly HavexNewsRepository $newsRepository
    ) {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('sulu_resolve_hawex_news', [$this, 'resolveNewsFunction']),
        ];
    }

    public function resolveNewsFunction(int $id): ?HavexNews
    {
        $news = $this->newsRepository->find($id);

        return $news ?? null;
    }
}
