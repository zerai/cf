<?php declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function(Config $config): void
{
    $classSet = ClassSet::fromDir(__DIR__ . '/src');

    $rulePlaceholder = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('App\Controller'))
        ->should(new HaveNameMatching('*Controller'))
        ->because("we want uniform naming");

    $config->add($classSet, $rulePlaceholder,);
};

