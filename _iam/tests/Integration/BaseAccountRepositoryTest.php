<?php declare(strict_types=1);

namespace Iam\Tests\Integration;

use Doctrine\ORM\EntityManager;
use Iam\Application\Model\BaseAccount;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseAccountRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager = null;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     */
    public function testAdd(): void
    {
        $repository = $this->entityManager
            ->getRepository(BaseAccount::class)
        ;

        $baseAccount = new BaseAccount('xxxx', 'irre@email.com', 'xxx');

        $repository->add($baseAccount, true);

        $baseAccountFromDB = $repository->find('xxxx');

        self::assertNotNull($baseAccountFromDB);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
