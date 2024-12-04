<?php

namespace App\Controller;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('/car/buy/{id}', name: 'car_buy')]
    public function buy(Car $car): Response
    {
        // Vérifier si l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        
        // Associer la voiture à l'utilisateur
        $car->setUser($user);
        
        // Sauvegarder en base de données
        $this->entityManager->persist($car);
        $this->entityManager->flush();

        $this->addFlash('success', 'Voiture achetée avec succès !');
        
        return $this->redirectToRoute('car_list');
    }
} 