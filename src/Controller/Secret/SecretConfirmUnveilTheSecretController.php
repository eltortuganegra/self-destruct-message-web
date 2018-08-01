<?php

namespace App\Controller\Secret;


use App\domain\Infrastructure\Repositories\RepositoriesFactory;
use App\domain\Services\SecretFindService\SecretFindServiceRequest;
use App\domain\Services\SecretFindService\SecretIsExpiredException;
use App\domain\Services\SecretUnveilService\SecretNotFoundException;
use App\domain\Services\ServicesFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecretConfirmUnveilTheSecretController extends Controller
{
    private $service;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $secretRepository = RepositoriesFactory::getDoctrineSecretRepository($entityManager);
        $this->service = ServicesFactory::createSecretFindService($secretRepository);
    }

    public function execute(Request $request, string $secretId)
    {
        $request = new SecretFindServiceRequest($secretId);
        try {
            $this->service->execute($request);

            return $this->renderSecretConfirmationPage($secretId);
        } catch(SecretNotFoundException $exception) {

            return $this->renderSecretNotFound();
        } catch(SecretIsExpiredException $exception) {

            return $this->renderSecretNotFound();
        }
    }

    private function renderSecretNotFound(): Response
    {
        return $this->render(
            'secret_show/error.html.twig',
            [
                'controller_name' => 'SecretUnveilController',
            ],
            new Response('', 404)
        );
    }

    private function renderSecretConfirmationPage(string $secretId): Response
    {
        $urlForUnveilSecret = $this->generateUrl(
            'secret_unveil',
            [
                'secretId' => $secretId
            ]
        );

        return $this->render('secret/secret_confirm_unveil_the_secret.html.twig', [
            'data' => [
                'linkForShareUrl' => $urlForUnveilSecret,
            ]
        ]);
    }
}