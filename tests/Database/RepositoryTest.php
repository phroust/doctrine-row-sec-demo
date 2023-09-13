<?php declare(strict_types=1);

namespace App\Tests\Database;

use App\Entity\Tenant;
use App\Entity\TenantUser;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RepositoryTest extends KernelTestCase
{

    private ObjectManager $entityManager;

    private Registry $doctrine;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        /** @var Registry $doctrine */
        $doctrine = $kernel->getContainer()
            ->get('doctrine');

        $this->doctrine = $doctrine;

        $this->entityManager = $this->doctrine->getManager();
    }

    /**
     * This tests if the superuser can see all tenants
     */
    public function testSuperuserCanSeeAllTenants()
    {
        $em = $this->doctrine->getManager('superuser');

        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder();

        $count = $qb->select('count(t.id)')->from(Tenant::class, 't')->getQuery()->getSingleScalarResult();

        # there are 3 Tenants
        self::assertEquals(3, $count);
    }

    /**
     * This tests if the superuser can see all users
     */
    public function testSuperuserCanSeeAllTenantUsers()
    {
        $em = $this->doctrine->getManager('superuser');

        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder();

        $count = $qb->select('count(u.id)')->from(TenantUser::class, 'u')->getQuery()->getSingleScalarResult();

        # there are 3 Users
        self::assertEquals(3, $count);
    }

    /**
     * This tests that the database will not return a tenant if no matching ID was set
     *
     * @return void
     */
    public function testApplicationUserCannotSeeUnrelatedTenants(): void
    {
        $this->forceTenantId(-1);

        $repo = $this->entityManager
            ->getRepository(Tenant::class);


        self::assertEmpty($repo->count([]));
    }

    /**
     * This tests that the database will not return users if no matching ID was set
     *
     * @return void
     */
    public function testApplicationUserCannotSeeUnrelatedUsers(): void
    {
        $this->forceTenantId(-1);

        $repo = $this->entityManager
            ->getRepository(TenantUser::class);


        self::assertEmpty($repo->count([]));
    }

    /**
     * This tests that the database will only return a single tenant matching the tenantID.
     * All tenants different from the ID must not be returned from the database.
     *
     * @dataProvider tenantDataProvider
     */
    public function testCanFindCorrectTenant(string $tenantName): void
    {
        $id = $this->getTenantIdForName($tenantName);
        $this->forceTenantId($id);

        $repo = $this->entityManager->getRepository(Tenant::class);

        $tenants = $repo->findAll();

        self::assertCount(1, $tenants);
        self::assertEquals($tenantName, $tenants[0]->getName());
    }

    /**
     * This tests that the database will only return users matching the tenantID.
     *  All users not belonging to the tenantID must not be returned from the database.
     *
     * @dataProvider tenantUserDataProvider
     */
    public function testCanFindCorrectUsersForTenant(string $tenantName, array $expectedUserEmails): void
    {
        $id = $this->getTenantIdForName($tenantName);
        $this->forceTenantId($id);

        $repo = $this->entityManager->getRepository(TenantUser::class);

        /** @var []TenantUser $users */
        $users = $repo->findAll();

        self::assertCount(count($expectedUserEmails), $users);

        /** @var TenantUser $user */
        foreach ($users as $user) {
            if (!in_array($user->getEmail(), $expectedUserEmails)) {
                self::fail(sprintf('did not expect to find user "%s"', $user->getEmail()));
            }
        }
    }

    private function forceTenantId(int $tenantId): void
    {
        $this->doctrine->getConnection()->exec(sprintf("SET app.current_tenant TO %d;", $tenantId));
    }


    private function getTenantIdForName(string $tenantName): int
    {
        $em = $this->doctrine->getManager('superuser');

        /** @var QueryBuilder $qb */
        $qb = $em->createQueryBuilder();

        return $qb
            ->select('t.id')
            ->from(Tenant::class, 't')
            ->where('t.name = :tenant_name')
            ->setParameter('tenant_name', $tenantName)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function tenantDataProvider(): array
    {
        return [
            'Tenant 1' => ['tenant_01'],
            'Tenant 2' => ['tenant_02'],
            'Tenant 3' => ['tenant_03']

        ];
    }

    public function tenantUserDataProvider(): array
    {
        return [
            'Tenant 1' => ['tenant_01', []],
            'Tenant 2' => ['tenant_02', ['user01@email.example']],
            'Tenant 3' => ['tenant_03', ['user02@email.example', 'user03@email.example']]

        ];
    }

}