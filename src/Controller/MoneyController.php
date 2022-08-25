<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Money;
use App\Form\Type\MoneyType;
use App\Repository\MoneyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MoneyController extends AbstractApiController
{
    public function __construct(
        private MoneyRepository $moneyRepository,
    ) {}

    public function indexAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $clientId = $request->get('clientId');
        $client = $doctrine->getRepository(Client::class)->findOneBy([
            'id' => $clientId,
        ]);

        if (!$client) {
            throw new NotFoundHttpException('Account not found');
        }

        return $this->respond($client);
    }

    public function transactionAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->buildForm(MoneyType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) { 
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Money $money */
        $money = $form->getData();

        $doctrine->getManager()->persist($money);
        $doctrine->getManager()->flush();

        return $this->respond($money, Response::HTTP_CREATED);
    }

    public function balanceAction(Request $request): Response
    {
        $clientId = $request->get('clientId');
        $client = $this->moneyRepository->showCurrentBalance([
            'id' => $clientId,
        ]);

        if (!$client) {
            throw new NotFoundHttpException('Account not found');
        }

        foreach($client as $money) {
            $deposit[] = intval($money['moneyDeposit']);
            $withdrawal[] = intval($money['moneyWithdrawal']);
        }

        $depositSum = array_sum($deposit);
        $withdrawalSum = array_sum($withdrawal);

        $balance = $depositSum - $withdrawalSum;

        return $this->respond("Account balance: $balance", Response::HTTP_OK);
    }

    public function historyAction(Request $request): Response
    {
        $clientId = $request->get('clientId');
        $client = $this->moneyRepository->showHistory([
            'id' => $clientId,
        ]);

        if (!$client) {
            throw new NotFoundHttpException('Account or transaction history not found');
        }

        return $this->respond($client, Response::HTTP_OK);
    }
}
