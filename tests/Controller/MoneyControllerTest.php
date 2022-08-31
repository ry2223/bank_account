<?php

namespace App\Tests\Controller;

use App\Entity\Money;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoneyControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        // parent::setUp();

        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /** @test */
    public function money_transaction_saved_to_the_database()
    {
        $moneyWithdrawal = new Money();
        $moneyWithdrawal->setMoneyWithdrawal(3000.10);
        $moneyWithdrawal->setClient(null);

        $moneyDeposit = new Money();
        $moneyDeposit->setMoneyDeposit(4000.25);
        $moneyDeposit->setClient(null);

        $this->entityManager->persist($moneyWithdrawal);
        $this->entityManager->persist($moneyDeposit);
        $this->entityManager->flush();

        $withdrawalData = $this->entityManager->getRepository(Money::class)->findOneBy([
            'moneyWithdrawal' => 3000.10
        ]);

        $depositData = $this->entityManager->getRepository(Money::class)->findOneBy([
            'moneyDeposit' => 4000.25
        ]);

        $this->assertEquals(3000.10, $withdrawalData->getMoneyWithdrawal());
        $this->assertEquals(4000.25, $depositData->getMoneyDeposit());
    }

    /** @test */
    public function money_balance_is_calculated_correctly(): void
    {
        $data = [
            'account' => [
                "moneyDeposit" => 7000.12,
                "moneyWithdrawal" => 5000.02
            ]
        ];

        foreach($data as $money) {
            $deposit[] = $money['moneyDeposit'];
            $withdrawal[] = $money['moneyWithdrawal'];
        }

        $depositSum = array_sum($deposit);
        $withdrawalSum = array_sum($withdrawal);

        $balance = $depositSum - $withdrawalSum;

        $this->assertEquals(2000.10, $balance);
    }
}