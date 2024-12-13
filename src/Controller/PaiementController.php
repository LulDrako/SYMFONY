<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Paiement;
use App\Entity\Voiture;

class PaiementController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('/panier', name: 'panier')]
    public function panier(SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        return $this->render('paiement/panier.html.twig', [
            'panier' => $panier
        ]);
    }

    #[Route('/paiement', name: 'paiement')]
    public function paiement(SessionInterface $session): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $panier = $session->get('panier', []);
        $total = array_reduce($panier, fn($sum, $voiture) => $sum + $voiture['prix'], 0);

        return $this->render('paiement/paiement.html.twig', [
            'panier' => $panier,
            'total' => $total,
            'user' => $this->getUser()
        ]);
    }

    #[Route('/valider-paiement', name: 'valider_paiement', methods: ['POST'])]
    public function validerPaiement(
        Request $request, 
        EntityManagerInterface $entityManager, 
        SessionInterface $session
    ): Response
    {
        $panier = $session->get('panier', []);
        if (empty($panier)) {
            return $this->redirectToRoute('panier', [
                'error' => 'Le panier est vide, veuillez ajouter une voiture.'
            ]);
        }

        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('paiement', [
                'error' => 'Utilisateur non authentifié'
            ]);
        }

        $montant = $request->request->get('montant');
        $methode_paiement = $request->request->get('methode_paiement');
        $numero_carte_bleu = $request->request->get('numero_carte_bleu');

        $voiture = reset($panier);
        $voitureId = $voiture['id'];

        $voitureEntity = $entityManager->getRepository(Voiture::class)->find($voitureId);

        if (!$voitureEntity) {
            return $this->redirectToRoute('paiement', [
                'error' => 'Voiture introuvable'
            ]);
        }

        $paiement = new Paiement();
        $paiement->setMontant($montant);
        $paiement->setMethodePaiement($methode_paiement);
        $paiement->setStatut('en attente');
        $paiement->setNumeroCarteBleu($numero_carte_bleu);
        $paiement->setUser($user);
        $paiement->setVoiture($voitureEntity);

        $entityManager->persist($paiement);
        $entityManager->flush();

        $session->remove('panier');

        return $this->redirectToRoute('confirmation');
    }

    #[Route('/confirmation', name: 'confirmation')]
    public function confirmation(): Response
    {
        return $this->render('paiement/confirmation.html.twig');
    }

    #[Route('/historique-paiement', name: 'historique_paiement')]
    public function historiquePaiement(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('rechercher_paiement', [
                'error' => 'Utilisateur non authentifié'
            ]);
        }

        $paiements = $entityManager->getRepository(Paiement::class)->findBy(['user' => $user]);

        return $this->render('paiement/historique_par_user.html.twig', [
            'user' => $user,
            'paiements' => $paiements
        ]);
    }
}
