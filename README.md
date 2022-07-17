# Configuration

    contractor:
        db_driver: orm модель данных
        factory: App\User\Factory\UserFactory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\User\Entity\User сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию
        dto_class: App\User\Dto\UserDto класс dto с которым работает сущность
        preserve_dto: App\User\Dto\Preserve\UserDto мутабельный класс dto используется для генерации пользователя через консольную команду
        role_mediator: App\User\Role\CustomRoleMediator медиатор для управления логикой ролей пользователя 
        decorates:
          command - декоратор mediator команд пользователя 
          query - декоратор mediator запросов пользователя
        services:
          pre_validator - переопределение сервиса валидатора user
          pre_checker_password - переопределение сервиса првоерки пароля
          role_mediator - переопределение сервиса управления ролями
          create_bridge - переопределение сервиса моста между командой и логикой создания user
          role_bridge - переопределение сервиса моста между командой и логикой назначения ролей user

# CQRS model

Actions в контроллере разбиты на две группы создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)

получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface

группы сериализации

    1. api_get_user - получение цфо
    2. api_post_user - создание цфо
    3. api_post_user -  редактирование цфо

# Статусы:

    создание:
        пользователь создан HTTP_CREATED 201
    обновление:
        пользователь обновление HTTP_OK 200
    удаление:
        пользователь удален HTTP_ACCEPTED 202
    получение:
        пользователь(и) найдены HTTP_OK 200
    ошибки:
        если пользователь не найден UserNotFoundException возвращает HTTP_NOT_FOUND 404
        если пользователь не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если пользователь не прошел валидацию UserInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если пользователь не может быть сохранен UserCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сущности user нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегистрировать сервис с этикеткой evrinoma.user.constraint.property

    evrinoma.user.constraint.property.custom:
        class: App\User\Constraint\Property\Custom
        tags: [ 'evrinoma.usr.constraint.property' ]

## Description

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
