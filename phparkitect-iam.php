<?php declare(strict_types=1);

/*
 * This file is part of the zerai/cf application
 *
 * @copyright (c) Zerai Teclai <teclaizerai@googlemail.com>.
 * @copyright (c) Francesca Bonadonna <francescabonadonna@googlemail.com>.
 *
 * This software consists of voluntary contributions made by many individuals
 * {@link https://github.com/zerai/cf/graphs/contributors developer} and is licensed under the MIT license.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $IamModuleClassSet = ClassSet::fromDir(__DIR__ . '/_iam/src');

    $IamRules = [];

    $IamRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('Iam\Application\Model'))
        ->should(
            new NotHaveDependencyOutsideNamespace(
                'Iam\Application\Model',
                [
                    'Symfony\Component\Security\Core\User\UserInterface',
                    'Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface',
                ]
            )
        )
        ->because('we want a pure domain model.');

    $config
        ->add($IamModuleClassSet, ...$IamRules);
};
