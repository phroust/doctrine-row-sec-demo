<?php

namespace App\DataFixtures;

use App\Entity\Tenant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Tenant01 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tenant = new Tenant();
        $tenant->setName("tenant_01");
        $tenant->setStatus("active");
        $tenant->setTier("gold");

        $manager->persist($tenant);

        # this tenant does not have any users

        $manager->flush();
    }
}
