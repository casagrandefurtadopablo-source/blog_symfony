<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Story\AppStory;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       AppStory::load();
    }
}
