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

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sulu\Bundle\ActivityBundle\Application\Collector\DomainEventCollectorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Havex\Bundle\SuluNewsBundle\Entity\Factory\NewsFactory;
use Havex\Bundle\SuluNewsBundle\Entity\Factory\NewsRouteFactory;
use Havex\Bundle\SuluNewsBundle\Entity\HavexHavexNews;
use Havex\Bundle\SuluNewsBundle\Event\NewsCreatedActivityEvent;
use Havex\Bundle\SuluNewsBundle\Event\NewsModifiedActivityEvent;
use Havex\Bundle\SuluNewsBundle\Event\NewsRemovedActivityEvent;
use Havex\Bundle\SuluNewsBundle\Repository\NewsRepository;

class NewsService implements NewsServiceInterface
{
    /**
     * @var object|string
     */
    private ?UserInterface $loginUser = null;

    /**
     * ArticleService constructor.
     */
    public function __construct(
        private readonly NewsRepository $newsRepository,
        private readonly NewsFactory $newsFactory,
        private readonly NewsRouteFactory $routeFactory,
        TokenStorageInterface $tokenStorage,
        private readonly DomainEventCollectorInterface $domainEventCollector
    ) {
        if (null !== $tokenStorage->getToken()) {
            $this->loginUser = $tokenStorage->getToken()->getUser();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveNewNews(array $data, string $locale): HavexHavexNews
    {
        $news = null;
        try {
            $news = $this->newsFactory->generateNewsFromRequest(new HavexHavexNews(), $data, $locale);
        } catch (\Exception) {
        }

        /** @var HavexHavexNews $news */
        if (!$news->getCreator()) {
            $news->setCreator($this->loginUser->getContact());
        }
        $news->setchanger($this->loginUser->getContact());

        $this->newsRepository->save($news);

        $this->routeFactory->generateNewsRoute($news);

        $this->domainEventCollector->collect(new NewsCreatedActivityEvent($news, ['name' => $news->getTitle()]));
        $this->newsRepository->save($news);

        return $news;
    }

    /**
     * @param mixed $data
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function updateNews($data, HavexHavexNews $news, string $locale): HavexHavexNews
    {
        try {
            $news = $this->newsFactory->generateNewsFromRequest($news, $data, $locale);
        } catch (\Exception) {
        }

        $news->setchanger($this->loginUser->getContact());

        if ($news->getRoute()->getPath() !== $data['route']) {
            $route = $this->routeFactory->updateNewsRoute($news, $data['route']);
            $news->setRoute($route);
        }

        $this->domainEventCollector->collect(new NewsModifiedActivityEvent($news, ['name' => $news->getTitle()]));
        $this->newsRepository->save($news);

        return $news;
    }

    public function updateNewsPublish(HavexHavexNews $news, array $data): HavexHavexNews
    {
        switch ($data['action']) {
            case 'enable':
                $news = $this->newsFactory->generateNewsFromRequest($news, [], null, true);

                break;

            case 'disable':
                $news = $this->newsFactory->generateNewsFromRequest($news, [], null, false);

                break;
        }
        $this->domainEventCollector->collect(new NewsModifiedActivityEvent($news, ['name' => $news->getTitle()]));
        $this->newsRepository->save($news);

        return $news;
    }

    public function removeNews(int $id): void
    {
        $news = $this->newsRepository->findById($id);
        if (!$news instanceof HavexHavexNews) {
            throw new \Exception($id);
        }

        $this->domainEventCollector->collect(new NewsRemovedActivityEvent($news, ['name' => $news->getTitle()]));
        $this->newsRepository->remove($id);
    }
}
