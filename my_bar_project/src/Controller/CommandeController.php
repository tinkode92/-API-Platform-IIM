<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CommandeController extends AbstractController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/serveur/commande", name="create_commande", methods={"POST"})
     */
    public function createCommande(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $commande = new Commande();
        $commande->setCreatedAt(new \DateTime());
        $commande->setStatus('en cours de préparation');
        $commande->setTableNumber($data['tableNumber']);
        $commande->setServeur($this->security->getUser());

        // Associez les boissons à la commande
        // ...

        $this->entityManager->persist($commande);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Commande created!'], Response::HTTP_CREATED);
    }

    // Ajoutez d'autres méthodes pour les autres opérations
}
