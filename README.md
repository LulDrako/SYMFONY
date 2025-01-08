# Symfony Project

Ce projet est une application web développée avec le framework Symfony.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants :

- **PHP** version 7.4 ou supérieure
- **Composer**
- **Symfony CLI**
- **Base de données** (par exemple, MySQL)

## Installation

1. Clonez le dépôt :

   ```bash
   git clone https://github.com/LulDrako/Symfony.git
   ```

2. Accédez au répertoire du projet :

   ```bash
   cd Symfony
   ```

3. Installez les dépendances avec Composer :

   ```bash
   composer install
   ```

4. Configurez les variables d'environnement en dupliquant le fichier `.env` :

   ```bash
   cp .env .env.local
   ```

   Modifiez le fichier `.env.local` pour définir les paramètres de connexion à votre base de données.

5. Créez la base de données :

   ```bash
   php bin/console doctrine:database:create
   ```

6. Appliquez les migrations pour créer les tables nécessaires :

   ```bash
   php bin/console doctrine:migrations:migrate
   ```

7. Chargez les données initiales (fixtures) si disponibles :

   ```bash
   php bin/console doctrine:fixtures:load
   ```

## Utilisation

1. Démarrez le serveur de développement Symfony :

   ```bash
   symfony server:start
   ```

2. Accédez à l'application via votre navigateur à l'adresse `http://localhost:8000`.

## Tests

Pour exécuter les tests, utilisez la commande suivante :

```bash
php bin/phpunit
```

## Contribuer

Les contributions sont les bienvenues. Veuillez suivre les étapes suivantes :

1. Forkez le dépôt.
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/ma-fonctionnalite`).
3. Commitez vos modifications (`git commit -m 'Ajout de ma fonctionnalité'`).
4. Poussez vers la branche (`git push origin feature/ma-fonctionnalite`).
5. Ouvrez une Pull Request.

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
