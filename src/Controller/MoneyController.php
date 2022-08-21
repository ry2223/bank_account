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

    public function withdrawAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $clientId = $request->get('id');
        $client = $doctrine->getRepository(Client::class)->findOneBy([
            'id' => $clientId,
        ]);

        $form = $this->buildForm(MoneyType::class, $client, [
            'method' => $request->getMethod(),
        ]);

        $form = $this->buildForm(MoneyType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) { 
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Money $money */
        $money = $form->getData();

        $doctrine->getManager()->persist($money);
        $doctrine->getManager()->flush();

        return $this->respond($money);
    }

    public function depositAction(Request $request, ManagerRegistry $doctrine): Response
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

        return $this->respond($money);
    }
}
