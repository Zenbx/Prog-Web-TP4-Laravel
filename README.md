# 🛍️ Projet TP4 – Application E-Commerce avec Laravel

## 🎯 Objectif du TP
Développer une **application e-commerce complète** avec le framework **Laravel**.  
Ce projet constitue le **TP4 de Programmation Web 2025** et fait suite aux TP1-TP3 (site statique → site dynamique → CMS e-commerce).  

L’objectif est de créer **notre propre backend Laravel** avec :
- Authentification basique (inscription / connexion)
- Gestion des produits (CRUD complet)
- Système de panier et validation de commande
- Tableau de bord administrateur
- Base de données relationnelle complète

---

## ⚙️ Technologies utilisées
- **Langage :** PHP 8.1+
- **Framework :** Laravel 10+
- **Base de données :** MySQL / MariaDB
- **Frontend :** Blade Templates (HTML/CSS/Bootstrap)
- **Serveur local :** Laravel Sail ou XAMPP / WAMP
- **Outil de versioning :** Git / GitHub

---

## 🧩 Structure du projet

```bash
ecommerce-laravel/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Authentification (login, register, logout)
│   │   │   ├── ProductController.php       # CRUD Produits
│   │   │   ├── CartController.php          # Gestion du panier (session)
│   │   │   ├── OrderController.php         # Gestion des commandes
│   │   │   └── DashboardController.php     # Tableau de bord Admin
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php                        # Modèle utilisateur
│   │   ├── Product.php                     # Modèle produit
│   │   ├── Order.php                       # Modèle commande
│   │   └── OrderItem.php                   # Modèle article de commande
│   └── Policies/
│
├── database/
│   ├── migrations/                         # Scripts de création de tables
│   │   ├── create_users_table.php
│   │   ├── create_products_table.php
│   │   ├── create_orders_table.php
│   │   └── create_order_items_table.php
│   └── seeders/                            # Données initiales (produits, admin)
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php              # Template principal
│       ├── products/
│       │   ├── index.blade.php            # Liste produits
│       │   ├── create.blade.php           # Ajout produit
│       │   ├── edit.blade.php             # Édition produit
│       │   └── show.blade.php             # Détails produit
│       ├── cart/index.blade.php           # Panier utilisateur
│       ├── orders/
│       │   ├── checkout.blade.php         # Validation commande
│       │   └── my.blade.php               # Historique utilisateur
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       └── admin/dashboard.blade.php      # Tableau de bord admin
│
├── routes/
│   └── web.php                            # Toutes les routes du site
│
├── .env.example                           # Exemple de configuration BD
├── composer.json                          # Dépendances Laravel
└── README.md                              # (ce fichier)
```

---

## 🧠 Description des fonctionnalités

| Module | Description | Responsable |
|---------|-------------|--------------|
| **1. Authentification** | Inscription, connexion, déconnexion, vérification des sessions, protection des routes. | 🧑‍💻 *Développeur Auth* |
| **2. CRUD Produits** | Ajout, édition, suppression, affichage de produits (nom, description, prix, stock, image). | 🧑‍💻 *Développeur CRUD* |
| **3. Panier** | Panier stocké en session : ajouter / retirer un produit, calcul automatique du total, vider panier. | 🧑‍💻 *Développeur Panier* |
| **4. Commandes** | Validation du panier → enregistrement commande (user_id, total, date, statut), affichage historique. | 🧑‍💻 *Développeur Commandes* |
| **5. Tableau de bord Admin** | Vue globale des commandes, utilisateurs, revenus, statistiques de ventes. | 🧑‍💻 *Développeur Dashboard* |
| **6. Base de données / Migrations** | Création des tables `users`, `products`, `orders`, `order_items` + relations. | 🧑‍💻 *Développeur Base de données* |
| **7. Design / Blade Templates** | Mise en page du frontend avec Blade, intégration du CSS, cohérence visuelle. | 🧑‍💻 *Intégrateur Frontend* |

---

## 🧰 Installation locale (pour tous les membres)

```bash
git clone https://github.com/votre-utilisateur/ecommerce-laravel.git
cd ecommerce-laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## 🧭 Organisation Git / Équipe

| Branche | Responsable | Contenu |
|----------|-------------|----------|
| `main` | Chef de projet | Version stable |
| `auth` | Dev Auth | Authentification |
| `crud-products` | Dev CRUD | Gestion des produits |
| `cart-orders` | Dev Panier + Commandes | Panier et validation |
| `dashboard` | Dev Admin | Tableau de bord |
| `frontend` | Intégrateur | Vues Blade et design |

**Règles :**
- Ne pas coder directement sur `main`
- Créer une branche personnelle à partir de `main`
- Faire des commits clairs et fréquents
- Créer des Pull Requests pour valider les ajouts

---

## ✅ Livrables attendus
- Application Laravel fonctionnelle (backend + vues)
- Gestion complète des produits, panier, commandes et utilisateurs
- Authentification opérationnelle
- Tableau de bord administrateur
- Code propre et documenté
- Dépôt Git bien organisé

---

## 💡 Bonus (facultatif mais valorisé)
- Upload d’image pour les produits
- Pagination des produits
- Filtrage / recherche dans la boutique
- Statistiques visuelles (Chart.js dans le dashboard)
- Envoi d’email de confirmation de commande

---

## 👨‍💻 Auteurs / Rôles
| Nom | Rôle | Partie principale |
|------|------|------------------|
| Jeff Belekotan | Chef de projet | Organisation, intégration |
| Membre 1 | Développeur CRUD | Gestion produits |
| Membre 2 | Développeur Panier & Commandes | Gestion panier et commandes |
| Membre 3 | Développeur Auth | Authentification |
| Membre 4 | Développeur Admin | Tableau de bord |
| Membre 5 | Dev BD / Seeder | Structure et data |

---

### 🚀 En résumé

> Ce projet représente le **TP4 – Développement complet avec Laravel**.  
> Il doit permettre à chaque membre du groupe de travailler indépendamment, tout en maintenant une cohérence dans le code et la structure du projet.
