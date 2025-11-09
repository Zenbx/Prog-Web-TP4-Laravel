# Laravel + React Starter Kit

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et npm
- SQLite

## Installation

1. **Cloner le projet**

```bash
git clone <url-du-projet>
cd crud
```

2. **Installer les dépendances**

```bash
composer install
npm install
```

3. **Configuration de l'environnement**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**

Le projet utilise SQLite par défaut. Dans `.env` :

```env
DB_CONNECTION=sqlite
```

Créer la base de données :

```bash
type nul > database/database.sqlite
php artisan migrate
```

## Démarrage

1. **Lancer le serveur Laravel**

```bash
php artisan serve
```

2. **Compiler les assets**

```bash
npm run dev
```

L'application sera accessible sur :

- Application : <http://localhost:8000>
- Serveur Vite : <http://localhost:5173> (développement uniquement)

## Structure du projet

- `app/` - Code backend (Controllers, Models)
- `resources/` - Code frontend (React, CSS)
- `database/` - Migrations et seeds
- `routes/` - Configuration des routes
- `public/` - Assets compilés

## Technologies

- Laravel 10
- React 19
- TypeScript
- Tailwind CSS
- Inertia.js
- shadcn/ui
- radix-ui

## Documentation officielle

Documentation pour tous les Laravel starter kits sur le [site Laravel](https://laravel.com/docs/starter-kits).

## Contribution

Merci de considérer une contribution à notre starter kit ! Le guide de contribution se trouve dans la [documentation Laravel](https://laravel.com/docs/contributions).

## Code de conduite

Pour assurer que la communauté Laravel soit accueillante pour tous, veuillez consulter et respecter le [Code de Conduite](https://laravel.com/docs/contributions#code-of-conduct).

## Licence

Le Laravel + React starter kit est un logiciel open-source sous licence MIT.
