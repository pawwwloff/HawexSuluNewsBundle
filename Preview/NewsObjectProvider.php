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

namespace Havex\Bundle\SuluNewsBundle\Preview;

use Sulu\Bundle\PreviewBundle\Preview\Object\PreviewObjectProviderInterface;
use Havex\Bundle\SuluNewsBundle\Admin\NewsAdmin;
use Havex\Bundle\SuluNewsBundle\Entity\HavexHavexNews;
use Havex\Bundle\SuluNewsBundle\Repository\NewsRepository;

class NewsObjectProvider implements PreviewObjectProviderInterface
{
    public function __construct(private readonly NewsRepository $newsRepository)
    {
    }

    public function getObject($id, $locale): ?HavexHavexNews
    {
        return $this->newsRepository->findById((int) $id);
    }

    public function getId($object): string
    {
        return $object->getId();
    }

    public function setValues($object, $locale, array $data): void
    {
        // TODO: Implement setValues() method.
    }

    public function setContext($object, $locale, array $context): HavexHavexNews
    {
        if (\array_key_exists('template', $context)) {
            $object->setStructureType($context['template']);
        }

        return $object;
    }

    public function serialize($object): string
    {
        return \serialize($object);
    }

    public function deserialize($serializedObject, $objectClass): HavexHavexNews
    {
        return \unserialize($serializedObject);
    }

    public function getSecurityContext($id, $locale): ?string
    {
        return NewsAdmin::SECURITY_CONTEXT;
    }
}
