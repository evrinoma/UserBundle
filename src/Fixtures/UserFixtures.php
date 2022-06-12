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

namespace Evrinoma\UserBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;
use Evrinoma\UserBundle\Entity\User\BaseUser;

class UserFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        ['username' => 'test1', 'surname' => 'test1', 'email' => 'test1@test.ru', 'last_login' => '2008-10-23 06:21:51', 'password' => 'password1', 'patronymic' => 'test1', 'name' => 'test1', 'active' => 'a', 'expired_at' => null, 'roles' => ['ROLE_ADMIN_USER']],
        ['username' => 'test2', 'surname' => 'test2', 'email' => 'test2@test.ru', 'last_login' => '2019-11-23 07:21:52', 'password' => 'password2', 'patronymic' => 'test2', 'name' => 'test2', 'active' => 'b', 'expired_at' => '2008-10-23 10:21:50'],
        ['username' => 'test3', 'surname' => 'test3', 'email' => 'test3@test.ru', 'last_login' => '2019-07-23 08:21:53', 'password' => 'password3', 'patronymic' => 'test3', 'name' => 'test3', 'active' => 'd', 'expired_at' => '2019-07-23 08:21:53'],
        ['username' => 'test4', 'surname' => 'test4', 'email' => 'test4@test.ru', 'last_login' => '2021-12-23 09:21:54', 'password' => 'password4', 'patronymic' => 'test4', 'name' => 'test4', 'active' => 'a', 'expired_at' => '2021-12-24 09:21:54'],
        ['username' => 'test5', 'surname' => 'test5', 'email' => 'test5@test.ru', 'last_login' => '2022-01-23 11:21:55', 'password' => 'password5', 'patronymic' => 'test5', 'name' => 'test5', 'active' => 'b', 'expired_at' => '2022-01-24 11:21:55'],
        ['username' => 'test6', 'surname' => 'test6', 'email' => 'test6@test.ru', 'last_login' => '2022-03-23 12:21:56', 'password' => 'password6', 'patronymic' => 'test6', 'name' => 'test6', 'active' => 'd', 'expired_at' => '2022-03-24 12:21:56'],
        ['username' => 'test7', 'surname' => 'test7', 'email' => 'test7@test.ru', 'last_login' => null, 'password' => 'password7', 'patronymic' => 'test7', 'name' => 'test7', 'active' => 'a', 'expired_at' => null],
    ];

    protected static string $class = BaseUser::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = self::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setUsername($record['username'])
                ->setSurname($record['surname'])
                ->setEmail($record['email'])
                ->setPassword($record['password'])
                ->setPatronymic($record['patronymic'])
                ->setName($record['name'])
                ->setActive($record['active']);

            if (isset($record['expired_at'])) {
                $entity
                    ->setExpiredAt(new \DateTimeImmutable($record['expired_at']));
            }
            if (isset($record['last_login'])) {
                $entity
                    ->setLastLogin(new \DateTimeImmutable($record['last_login']));
            }

            $entity->addRole('ROLE_REGULAR_USER');

            if (isset($record['roles'])) {
                foreach ($record['roles'] as $role) {
                    $entity->addRole($role);
                }
            }

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::USER_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
