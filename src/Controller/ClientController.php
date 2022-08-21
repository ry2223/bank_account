<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Client;
use App\Form\Type\ClientType;
use App\Repository\ClientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientController extends AbstractApiController
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {}

    public function indexAction(ManagerRegistry $doctrine): Response
    {
        $client = $doctrine->getRepository(Client::class)->findAll();

        return $this->respond($client);
    }

    public function showAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $clientId = $request->get('id');
        $client = $doctrine->getRepository(Client::class)->findOneBy([
            'id' => $clientId,
        ]);

        if (!$client) {
            throw new NotFoundHttpException('Account not found');
        }

        return $this->respond($client);
    }

    public function balanceAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $clientId = $request->get('id');
        $client = $this->clientRepository->showCurrentBalance([
            'id' => $clientId,
        ]);

        if (!$client) {
            throw new NotFoundHttpException('Account not found');
        }

        return $this->respond($client);
    }

    public function createAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->buildForm(ClientType::class);
        $form->handleRequest($request);
        
        if (!$form->isSubmitted() || !$form->isValid()) { 
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Client $client */
        $client = $form->getData();

        $doctrine->getManager()->persist($client);
        $doctrine->getManager()->flush();

        return $this->respond($client);
    }

    public function updateAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $clientId = $request->get('id');
        $client = $doctrine->getRepository(Client::class)->findOneBy([
            'id' => $clientId,
        ]);

        if (!$client) {
            throw new NotFoundHttpException('Account not found');
        }

        $form = $this->buildForm(ClientType::class, $client, [
            'method' => $request->getMethod(),
        ]);

        $form->handleRequest($request);
        
        if (!$form->isSubmitted() || !$form->isValid()) { 
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Client $client */
        $client = $form->getData();

        $doctrine->getManager()->persist($client);
        $doctrine->getManager()->flush();

        return $this->respond($client);
    }

    public function deleteAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $clientId = $request->get('id');
        $client = $doctrine->getRepository(Client::class)->findOneBy([
            'id' => $clientId,
        ]);

        if (!$client) {
            throw new NotFoundHttpException('Account not found');
        }

        $doctrine->getManager()->remove($client);
        $doctrine->getManager()->flush();

        return $this->respond(null);
    }
}
