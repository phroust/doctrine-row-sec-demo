<?php

namespace App\DataFixtures;

use App\Entity\Tenant;
use App\Entity\TenantUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Tenant02 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tenant = new Tenant();
        $tenant->setName("tenant_02");
        $tenant->setStatus("active");
        $tenant->setTier("gold");

        $manager->persist($tenant);

        # add a single user to the tenant
        $user01 = new TenantUser();
        $user01->setTenant($tenant);
        $user01->setEmail("user01@email.example");
        $user01->setGivenName("user_01");
        $user01->setFamilyName("tenant_02");
        $manager->persist($user01);

        $manager->flush();
    }
}
