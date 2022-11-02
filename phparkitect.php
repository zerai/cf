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
