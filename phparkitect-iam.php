<?php declare(strict_types=1);

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
