<?php

namespace App\Factory;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentProxyObjectFactory<Post>
 */
final class PostFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(private SluggerInterface $slugger)
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Post::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'category' => CategoryFactory::randomOrCreate(),
            'text' => self::faker()->paragraphs(4, true),
            'title' => self::faker()->words(4, true),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
          ->afterInstantiate(function(Post $post): void {
            $post->setSlug($this->slugger->slug($post->getTitle())->lower()->toString());
          })
        ;
    }
}
