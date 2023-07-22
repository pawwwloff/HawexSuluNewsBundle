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
use Havex\Bundle\SuluNewsBundle\Admin\HavexNewsAdmin;
use Havex\Bundle\SuluNewsBundle\Entity\HavexNews;
use Havex\Bundle\SuluNewsBundle\Repository\HavexNewsRepository;

class HavexNewsObjectProvider implements PreviewObjectProviderInterface
{
    public function __construct(private readonly HavexNewsRepository $newsRepository)
    {
    }

    public function getObject($id, $locale): ?HavexNews
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

    public function setContext($object, $locale, array $context): HavexNews
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

    public function deserialize($serializedObject, $objectClass): HavexNews
    {
        return \unserialize($serializedObject);
    }

    public function getSecurityContext($id, $locale): ?string
    {
        return HavexNewsAdmin::SECURITY_CONTEXT;
    }
}
