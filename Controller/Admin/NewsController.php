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

namespace Havex\Bundle\SuluNewsBundle\Controller\Admin;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Sulu\Component\Rest\AbstractRestController;
use Sulu\Component\Rest\Exception\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Havex\Bundle\SuluNewsBundle\Admin\DoctrineListRepresentationFactory;
use Havex\Bundle\SuluNewsBundle\Api\News as NewsApi;
use Havex\Bundle\SuluNewsBundle\Entity\News;
use Havex\Bundle\SuluNewsBundle\Repository\NewsRepository;
use Havex\Bundle\SuluNewsBundle\Service\News\NewsService;

class NewsController extends AbstractRestController implements ClassResourceInterface
{
    // serialization groups for contact
    protected static $oneNewsSerializationGroups = [
        'partialMedia',
        'fullNews',
    ];

    /**
     * NewsController constructor.
     */
    public function __construct(
        ViewHandlerInterface $viewHandler,
        TokenStorageInterface $tokenStorage,
        private readonly NewsRepository $repository,
        private readonly NewsService $newsService,
        private readonly DoctrineListRepresentationFactory $doctrineListRepresentationFactory,
    ) {
        parent::__construct($viewHandler, $tokenStorage);
    }

    public function cgetAction(Request $request): Response
    {
        $locale = $request->query->get('locale');
        $listRepresentation = $this->doctrineListRepresentationFactory->createDoctrineListRepresentation(
            News::RESOURCE_KEY,
            [],
            ['locale' => $locale]
        );

        return $this->handleView($this->view($listRepresentation));
    }

    public function getAction(int $id, Request $request): Response
    {
        if (($entity = $this->repository->findById($id)) === null) {
            throw new NotFoundHttpException();
        }

        $apiEntity = $this->generateApiNewsEntity($entity, $this->getLocale($request));

        $view = $this->generateViewContent($apiEntity);

        return $this->handleView($view);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function postAction(Request $request): Response
    {
        $news = $this->newsService->saveNewNews($request->request->all(), $this->getLocale($request));

        $apiEntity = $this->generateApiNewsEntity($news, $this->getLocale($request));

        $view = $this->generateViewContent($apiEntity);

        return $this->handleView($view);
    }

    /**
     * @Rest\Post("/news/{id}")
     */
    public function postTriggerAction(int $id, Request $request): Response
    {
        $news = $this->repository->findById($id);
        if (!$news instanceof News) {
            throw new NotFoundHttpException();
        }

        $news = $this->newsService->updateNewsPublish($news, $request->query->all());

        $apiEntity = $this->generateApiNewsEntity($news, $this->getLocale($request));
        $view = $this->generateViewContent($apiEntity);

        return $this->handleView($view);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function putAction(int $id, Request $request): Response
    {
        $entity = $this->repository->findById($id);
        if (!$entity instanceof News) {
            throw new NotFoundHttpException();
        }

        $updatedEntity = $this->newsService->updateNews($request->request->all(), $entity, $this->getLocale($request));
        $apiEntity = $this->generateApiNewsEntity($updatedEntity, $this->getLocale($request));
        $view = $this->generateViewContent($apiEntity);

        return $this->handleView($view);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteAction(int $id): Response
    {
        try {
            $this->newsService->removeNews($id);
        } catch (\Exception) {
            throw new EntityNotFoundException(self::$entityName, $id);
        }

        return $this->handleView($this->view());
    }

    public static function getPriority(): int
    {
        return 0;
    }

    protected function generateApiNewsEntity(News $entity, string $locale): NewsApi
    {
        return new NewsApi($entity, $locale);
    }

    protected function generateViewContent(NewsApi $entity): View
    {
        $view = $this->view($entity);
        $context = new Context();
        $context->setGroups(static::$oneNewsSerializationGroups);

        return $view->setContext($context);
    }
}
