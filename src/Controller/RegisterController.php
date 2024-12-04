<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    // Afficher la page d'inscription (GET)
    #[Route('/register', name: 'app_register', methods: ['GET'])]
    public function showRegisterForm(Request $request): Response
    {
        // Vérifiez si un message d'erreur a été passé en paramètre de la requête
        $error = $request->query->get('error');

        return $this->render('auth/register.html.twig', [
            'error' => $error,  // Passez la variable error au template
        ]);
    }

    // Traiter l'inscription (POST)
    #[Route('/register', name: 'app_register_post', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        ValidatorInterface $validator
    ): RedirectResponse {
        // Récupération des données du formulaire
        $data = $request->request->all();

        // Vérification des champs requis
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
            return $this->redirectToRoute('app_register', [
                'error' => 'Tous les champs sont requis.'
            ]);
        }

        // Création d'un nouvel utilisateur
        $user = new User();
        $user->setName($data['name']); // Ajout du champ name
        $user->setEmail($data['email']);

        // Hashage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Validation de l'utilisateur
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorMessage = '';
            foreach ($errors as $error) {
                $errorMessage .= $error->getMessage() . '<br>';
            }
            return $this->redirectToRoute('app_register', [
                'error' => $errorMessage,  // Passez les erreurs de validation comme message d'erreur
            ]);
        }

        // Vérifier si l'email existe déjà
        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return $this->redirectToRoute('app_register', [
                'error' => 'Un utilisateur avec cet email existe déjà.'
            ]);
        }

        // Enregistrement de l'utilisateur dans la base de données
        try {
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (\Exception $e) {
            return $this->redirectToRoute('app_register', [
                'error' => 'Une erreur est survenue lors de l\'enregistrement de l\'utilisateur.'
            ]);
        }

        // Redirection après enregistrement réussi
        return $this->redirectToRoute('app_login', [
            'success' => 'Utilisateur enregistré avec succès. Veuillez vous connecter.'
        ]);
    }
}
