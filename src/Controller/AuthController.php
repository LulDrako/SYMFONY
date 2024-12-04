<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\SecurityBundle\Security;

class AuthController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private Security $security
    ) {}

    #[Route('/dashboard', name: 'some_success_route')]
    public function dashboard(): Response
    {
        // Vérifier si l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        return $this->render('auth/dashboard.html.twig');
    }

    #[Route('/login', name: 'app_login', methods: ['GET'])]
    public function showLoginForm(AuthenticationUtils $authenticationUtils): Response
    {
        // Obtenir la dernière erreur d'authentification s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        
        return $this->render('auth/login.html.twig', [
            'error' => $error ? 'Invalid credentials' : null,
            'last_username' => $authenticationUtils->getLastUsername()
        ]);
    }

    #[Route('/login', name: 'app_login_post', methods: ['POST'])]
    public function login(Request $request): Response
    {
        $data = $request->request->all();
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        try {
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if (!$user) {
                throw new AuthenticationException('User not found');
            }

            if (!$this->passwordHasher->isPasswordValid($user, $password)) {
                throw new AuthenticationException('Invalid password');
            }

            // Créer le token d'authentification
            $token = new UsernamePasswordToken(
                $user,
                'main', // firewall name
                $user->getRoles()
            );

            // Définir le token dans le contexte de sécurité
            $this->container->get('security.token_storage')->setToken($token);

            // Créer la session
            $request->getSession()->set('_security_main', serialize($token));

            // Rediriger vers le dashboard
            return $this->redirectToRoute('some_success_route');

        } catch (AuthenticationException $e) {
            return $this->redirectToRoute('app_login', ['error' => true]);
        }
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode peut rester vide, 
        // Symfony gère la déconnexion automatiquement
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/register', name: 'app_register', methods: ['GET'])]
    public function showRegisterForm(): Response
    {
        return $this->render('auth/register.html.twig');
    }

    #[Route('/register', name: 'app_register_post', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $data = $request->request->all();
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            return $this->redirectToRoute('app_register', ['error' => 'User already exists']);
        }

        // Créer un nouvel utilisateur
        $user = new User();
        $user->setEmail($email);
        
        // Hasher le mot de passe avant de le stocker
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        // Sauvegarder dans la base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_login');
    }
}
