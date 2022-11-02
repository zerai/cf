<?php declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $VehicleReportingModuleClassSet = ClassSet::fromDir(__DIR__ . '/_vehiclereporting/src');

    $VehicleReportingRules = [];

    $VehicleReportingRules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('VehicleReporting\Application\Model'))
        ->should(
            new NotHaveDependencyOutsideNamespace(
                'Iam\Application\Model',
                [
                ]
            )
        )
        ->because('we want a pure domain model.');

    $config
        ->add($VehicleReportingModuleClassSet, ...$VehicleReportingRules);
};
