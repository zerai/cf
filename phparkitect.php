<?php declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\RuleBuilders\Architecture\Architecture;

return static function (Config $config): void {
    $classSet = ClassSet::fromDir(__DIR__)
        ->excludePath('_iam/tests')
        ->excludePath('_vehiclereporting/tests')
        ->excludePath('vendor')
        ->excludePath('tests')
        ->excludePath('cache')
        ->excludePath('var')
        ->excludePath('bin')
        ->excludePath('src/DataFixtures')
        ->excludePath('migrations')
        ->excludePath('config')
        ->excludePath('public')
        ->excludePath('tools/')
        ->excludePath('ecs.php')
        ->excludePath('phparkitect.php')
        ->excludePath('rector.php')
    ;

    $exagonalArchitecture = Architecture::withComponents()
        ->component('IdentityAccessManager')->definedBy('Iam\*')
        ->component('VehicleReporting')->definedBy('VehicleReporting\*')
        ->where('IdentityAccessManager')->shouldNotDependOnAnyComponent()
        ->where('VehicleReporting')->shouldNotDependOnAnyComponent()
        ->rules();

    $config->add($classSet, ...$exagonalArchitecture);
};
