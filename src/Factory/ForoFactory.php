<?php

namespace App\Factory;

use App\Entity\Foro;
use App\Repository\ForoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Foro>
 *
 * @method        Foro|Proxy                     create(array|callable $attributes = [])
 * @method static Foro|Proxy                     createOne(array $attributes = [])
 * @method static Foro|Proxy                     find(object|array|mixed $criteria)
 * @method static Foro|Proxy                     findOrCreate(array $attributes)
 * @method static Foro|Proxy                     first(string $sortedField = 'id')
 * @method static Foro|Proxy                     last(string $sortedField = 'id')
 * @method static Foro|Proxy                     random(array $attributes = [])
 * @method static Foro|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ForoRepository|RepositoryProxy repository()
 * @method static Foro[]|Proxy[]                 all()
 * @method static Foro[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Foro[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Foro[]|Proxy[]                 findBy(array $attributes)
 * @method static Foro[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Foro[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ForoFactory extends ModelFactory
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
            'nombre' => self::faker()->sentence(3), // Genera un nombre de foro con 3 palabras
            'descripcion' => self::faker()->paragraph(), // Genera una descripción aleatoria
            'postsNormalesLimit' => self::faker()->numberBetween(0, 100), // Límite de posts normales
            'postsImportantesLimit' => self::faker()->numberBetween(0, 50), // Límite de posts importantes
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // Puedes agregar lógica adicional después de la instanciación aquí
            // ->afterInstantiate(function(Foro $foro): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Foro::class;
    }
}
