<?php

namespace App\DataFixtures;

use App\Entity\Tenant;
use App\Entity\TenantUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Tenant03 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tenant = new Tenant();
        $tenant->setName("tenant_03");
        $tenant->setStatus("active");
        $tenant->setTier("gold");

        $manager->persist($tenant);

        # add two users to the tenant
        $user02 = new TenantUser();
        $user02->setTenant($tenant);
        $user02->setEmail("user02@email.example");
        $user02->setGivenName("user_02");
        $user02->setFamilyName("tenant_03");
        $manager->persist($user02);

        $user03 = new TenantUser();
        $user03->setTenant($tenant);
        $user03->setEmail("user03@email.example");
        $user03->setGivenName("user_03");
        $user03->setFamilyName("tenant_03");
        $manager->persist($user03);

        $manager->flush();
    }
}
