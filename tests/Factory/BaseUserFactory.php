<?php declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\BaseUser;
use App\Repository\BaseUserRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<BaseUser>
 *
 * @method static BaseUser|Proxy createOne(array $attributes = [])
 * @method static BaseUser[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static BaseUser|Proxy find(object|array|mixed $criteria)
 * @method static BaseUser|Proxy findOrCreate(array $attributes)
 * @method static BaseUser|Proxy first(string $sortedField = 'id')
 * @method static BaseUser|Proxy last(string $sortedField = 'id')
 * @method static BaseUser|Proxy random(array $attributes = [])
 * @method static BaseUser|Proxy randomOrCreate(array $attributes = [])
 * @method static BaseUser[]|Proxy[] all()
 * @method static BaseUser[]|Proxy[] findBy(array $attributes)
 * @method static BaseUser[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static BaseUser[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BaseUserRepository|RepositoryProxy repository()
 * @method BaseUser|Proxy create(array|callable $attributes = [])
 */
final class BaseUserFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'email' => self::faker()->text(),
            'roles' => [],
            'password' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(BaseUser $baseUser): void {})
        ;
    }

    protected static function getClass(): string
    {
        return BaseUser::class;
    }
}
