<?php

namespace App\Factory;

use App\Entity\Pagina;
use App\Repository\PaginaRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Pagina>
 *
 * @method        Pagina|Proxy                     create(array|callable $attributes = [])
 * @method static Pagina|Proxy                     createOne(array $attributes = [])
 * @method static Pagina|Proxy                     find(object|array|mixed $criteria)
 * @method static Pagina|Proxy                     findOrCreate(array $attributes)
 * @method static Pagina|Proxy                     first(string $sortedField = 'id')
 * @method static Pagina|Proxy                     last(string $sortedField = 'id')
 * @method static Pagina|Proxy                     random(array $attributes = [])
 * @method static Pagina|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PaginaRepository|RepositoryProxy repository()
 * @method static Pagina[]|Proxy[]                 all()
 * @method static Pagina[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Pagina[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Pagina[]|Proxy[]                 findBy(array $attributes)
 * @method static Pagina[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Pagina[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PaginaFactory extends ModelFactory
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
            'titulo' =>  self::faker()->text(),
            'subtitulo' =>  self::faker()->text(),
            'texto' =>  self::faker()->text(),
            'ruta' =>  self::faker()->word(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Pagina $pagina): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Pagina::class;
    }
}
