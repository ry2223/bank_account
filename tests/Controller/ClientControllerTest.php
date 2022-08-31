<?php

namespace App\Tests\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    /** @test */
    public function new_client_account_can_be_saved_to_the_database(): void
    {
        $client = new Client();
        $client->setName('John Doe');
        $client->setAccountNumber('43210987654321');
        $client->setEmail('john.doe@example.com');
        $client->setPhoneNumber("123456789");

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        $clientData = $this->entityManager->getRepository(Client::class)->findOneBy([
            'accountNumber' => '43210987654321'
        ]);

        $this->assertEquals('John Doe', $clientData->getName());
        $this->assertEquals('43210987654321', $clientData->getAccountNumber());
        $this->assertEquals('john.doe@example.com', $clientData->getEmail());
        $this->assertEquals("123456789", $clientData->getPhoneNumber());
    }
}