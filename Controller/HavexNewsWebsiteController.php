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

namespace Havex\Bundle\SuluNewsBundle\Controller;

use Sulu\Bundle\PreviewBundle\Preview\Preview;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Havex\Bundle\SuluNewsBundle\Entity\HavexNews;

/**
 * Class HavexNewsWebsiteController.
 */
class HavexNewsWebsiteController extends AbstractController
{
    public function indexAction(HavexNews $news, $attributes = [], $preview = false, $partial = false): Response
    {
        if (!$news) {
            throw new NotFoundHttpException();
        }

        if ($partial) {
            $content = $this->renderBlock(
                'hawex/news/index.html.twig',
                'content',
                ['news' => $news]
            );
        } elseif ($preview) {
            $content = $this->renderPreview(
                'hawex/news/index.html.twig',
                ['news' => $news]
            );
        } else {
            $content = $this->renderView(
                'hawex/news/index.html.twig',
                ['news' => $news]
            );
        }

        return new Response($content);
    }

    protected function renderPreview(string $view, array $parameters = []): string
    {
        $parameters['previewParentTemplate'] = $view;
        $parameters['previewContentReplacer'] = Preview::CONTENT_REPLACER;

        return $this->renderView('@SuluWebsite/Preview/preview.html.twig', $parameters);
    }

    /**
     * Returns rendered part of template specified by block.
     */
    protected function renderBlock(mixed $template, mixed $block, mixed $attributes = [])
    {
        $twig = $this->container->get('twig');
        $attributes = $twig->mergeGlobals($attributes);

        $template = $twig->load($template);

        $level = \ob_get_level();
        \ob_start();

        try {
            $rendered = $template->renderBlock($block, $attributes);
            \ob_end_clean();

            return $rendered;
        } catch (\Exception $e) {
            while (\ob_get_level() > $level) {
                \ob_end_clean();
            }

            throw $e;
        }
    }
}
