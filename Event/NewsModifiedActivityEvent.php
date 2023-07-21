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

namespace Havex\Bundle\SuluNewsBundle\Event;

use Sulu\Bundle\ActivityBundle\Domain\Event\DomainEvent;
use Havex\Bundle\SuluNewsBundle\Admin\NewsAdmin;
use Havex\Bundle\SuluNewsBundle\Entity\HavexHavexNews;

class NewsModifiedActivityEvent extends DomainEvent
{
    public function __construct(
        private readonly HavexHavexNews $news,
        private readonly array          $payload
    ) {
        parent::__construct();
    }

    public function getEventType(): string
    {
        return 'modified';
    }

    public function getResourceKey(): string
    {
        return HavexHavexNews::RESOURCE_KEY;
    }

    public function getResourceId(): string
    {
        return (string) $this->news->getId();
    }

    public function getEventPayload(): ?array
    {
        return $this->payload;
    }

    public function getResourceTitle(): ?string
    {
        return $this->news->getTitle();
    }

    public function getResourceSecurityContext(): ?string
    {
        return NewsAdmin::SECURITY_CONTEXT;
    }
}
