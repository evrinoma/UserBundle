<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\UserBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Evrinoma\UserBundle\Manager\CommandManagerInterface;
use Evrinoma\UserBundle\Manager\QueryManagerInterface;
use Evrinoma\UserBundle\PreValidator\DtoPreValidator;
use Evrinoma\UtilsBundle\Controller\AbstractApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class UserApiController extends AbstractApiController implements ApiControllerInterface
{
    private string $dtoClass;
    /**
     * @var FactoryDtoInterface
     */
    private FactoryDtoInterface $factoryDto;

    /**
     * @var ?Request
     */
    private ?Request $request;
    /**
     * @var CommandManagerInterface|RestInterface
     */
    private CommandManagerInterface $commandManager;
    /**
     * @var QueryManagerInterface|RestInterface
     */
    private QueryManagerInterface $queryManager;
    /**
     * @var DtoPreValidator
     */
    private DtoPreValidator $preValidator;

    public function __construct(SerializerInterface $serializer, RequestStack $requestStack, FactoryDtoInterface $factoryDto, CommandManagerInterface $commandManager, QueryManagerInterface $queryManager, DtoPreValidator $preValidator, string $dtoClass)
    {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->commandManager = $commandManager;
        $this->queryManager = $queryManager;
        $this->dtoClass = $dtoClass;
        $this->preValidator = $preValidator;
    }

    /**
     * @Rest\Post("/api/user/create", options={"expose": true}, name="api_user_create")
     * @OA\Post(
     *     tags={"user"},
     *     description="the method perform create user",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\UserBundle\Dto\UserApiDto",
     *                     "username": "nikolns",
     *                     "email": "nikolns@ite-ng.ru",
     *                     "password": "1234",
     *                     "active": "b",
     *                     "name": "Ivan",
     *                     "surname": "Ivanov",
     *                     "patronymic": "Ivanovich",
     *                     "expired_at": "2021-12-30",
     *                     "roles": {"A", "B", "C"},
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\UserBundle\Dto\UserApiDto"),
     *                 @OA\Property(property="username", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="active", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="surname", type="string"),
     *                 @OA\Property(property="patronymic", type="string"),
     *                 @OA\Property(property="expired_at", type="string"),
     *                 @OA\Property(property="roles", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create user")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var UserApiDtoInterface $userApiDto */
        $userApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        $this->commandManager->setRestCreated();
        try {
            $this->preValidator->onPost($userApiDto);

            $json = [];
            $em = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($userApiDto, $commandManager, &$json) {
                    $json = $commandManager->post($userApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_post_user')->json(['message' => 'Create user', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Put("/api/user/save", options={"expose": true}, name="api_user_save")
     * @OA\Put(
     *     tags={"user"},
     *     description="the method perform save user for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\UserBundle\Dto\UserApiDto",
     *                     "id": "1",
     *                     "username": "nikolns",
     *                     "email": "nikolns@ite-ng.ru",
     *                     "password": "1234",
     *                     "active": "b",
     *                     "name": "Ivan",
     *                     "surname": "Ivanov",
     *                     "patronymic": "Ivanovich",
     *                     "expired_at": "2021-12-30",
     *                     "roles": {"A", "B", "C"},
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\UserBundle\Dto\UserApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="username", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="password", type="string"),
     *                 @OA\Property(property="active", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="surname", type="string"),
     *                 @OA\Property(property="patronymic", type="string"),
     *                 @OA\Property(property="expired_at", type="string"),
     *                 @OA\Property(property="roles", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save code")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var UserApiDtoInterface $userApiDto */
        $userApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);
        $commandManager = $this->commandManager;

        try {
            $this->preValidator->onPut($userApiDto);

            $json = [];
            $em = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($userApiDto, $commandManager, &$json) {
                    $json = $commandManager->put($userApiDto);
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->setSerializeGroup('api_put_user')->json(['message' => 'Save user', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Delete("/api/user/delete", options={"expose": true}, name="api_user_delete")
     * @OA\Delete(
     *     tags={"user"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\UserBundle\Dto\UserApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="1",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete user")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var UserApiDtoInterface $userApiDto */
        $userApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $commandManager = $this->commandManager;
        $this->commandManager->setRestAccepted();

        try {
            $this->preValidator->onDelete($userApiDto);

            $json = [];
            $em = $this->getDoctrine()->getManager();

            $em->transactional(
                function () use ($userApiDto, $commandManager, &$json) {
                    $commandManager->delete($userApiDto);
                    $json = ['OK'];
                }
            );
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->commandManager, $e);
        }

        return $this->json(['message' => 'Delete user', 'data' => $json], $this->commandManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/user/criteria", options={"expose": true}, name="api_user_criteria")
     * @OA\Get(
     *     tags={"user"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\UserBundle\Dto\UserApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="username",
     *         in="query",
     *         name="username",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="email",
     *         in="query",
     *         name="email",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return user")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var UserApiDtoInterface $userApiDto */
        $userApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->criteria($userApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_user')->json(['message' => 'Get user', 'data' => $json], $this->queryManager->getRestStatus());
    }

    /**
     * @Rest\Get("/api/user", options={"expose": true}, name="api_user")
     * @OA\Get(
     *     tags={"user"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\UserBundle\Dto\UserApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="1",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return user")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var UserApiDtoInterface $userApiDto */
        $userApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        try {
            $json = $this->queryManager->get($userApiDto);
        } catch (\Exception $e) {
            $json = $this->setRestStatus($this->queryManager, $e);
        }

        return $this->setSerializeGroup('api_get_user')->json(['message' => 'Get user', 'data' => $json], $this->queryManager->getRestStatus());
    }

    public function setRestStatus(RestInterface $manager, \Exception $e): array
    {
        switch (true) {
            case $e instanceof UserCannotBeSavedException:
                $manager->setRestNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $manager->setRestConflict();
                break;
            case $e instanceof UserNotFoundException:
                $manager->setRestNotFound();
                break;
            case $e instanceof UserInvalidException:
                $manager->setRestUnprocessableEntity();
                break;
            default:
                $manager->setRestBadRequest();
        }

        return ['errors' => $e->getMessage()];
    }
}
