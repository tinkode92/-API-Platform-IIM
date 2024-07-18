<?php

namespace App\Controller;

use App\Entity\Boisson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoissonController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/barman/boisson", name="create_boisson", methods={"POST"})
     */
    public function createBoisson(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $boisson = new Boisson();
        $boisson->setName($data['name']);
        $boisson->setPrice($data['price']);
        // Ajoutez l'association avec Media si nécessaire

        $this->entityManager->persist($boisson);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'Boisson created!'], Response::HTTP_CREATED);
    }

    // Ajoutez d'autres méthodes pour les autres opérations
}
