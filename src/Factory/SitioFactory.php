<?php

namespace App\Factory;

use App\Entity\Sitio;
use App\Repository\SitioRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Sitio>
 *
 * @method        Sitio|Proxy                     create(array|callable $attributes = [])
 * @method static Sitio|Proxy                     createOne(array $attributes = [])
 * @method static Sitio|Proxy                     find(object|array|mixed $criteria)
 * @method static Sitio|Proxy                     findOrCreate(array $attributes)
 * @method static Sitio|Proxy                     first(string $sortedField = 'id')
 * @method static Sitio|Proxy                     last(string $sortedField = 'id')
 * @method static Sitio|Proxy                     random(array $attributes = [])
 * @method static Sitio|Proxy                     randomOrCreate(array $attributes = [])
 * @method static SitioRepository|RepositoryProxy repository()
 * @method static Sitio[]|Proxy[]                 all()
 * @method static Sitio[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Sitio[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Sitio[]|Proxy[]                 findBy(array $attributes)
 * @method static Sitio[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Sitio[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class SitioFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'header' => self::faker()->text(),
            'nombre_sitio'=>self::faker()->text(),
            'logo_sitio'=>self::faker()->text(),
            'instagram'=>self::faker()->text(),
            'facebook'=>self::faker()->text(),
            'twiter'=>self::faker()->text(),
            'mail'=>self::faker()->text(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Sitio $sitio): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Sitio::class;
    }
}
