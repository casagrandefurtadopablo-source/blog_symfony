<?php

namespace App\Story;

use App\Factory\CategoryFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Attribute\AsFixture;
use Zenstruck\Foundry\Story;

#[AsFixture(name: 'main')]
final class AppStory extends Story
{
    public function build(): void
    {
        CategoryFactory::createMany(3);
        PostFactory::createMany(50);
        UserFactory::createOne();
    }
}
