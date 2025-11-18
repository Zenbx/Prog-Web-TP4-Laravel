<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - TechStorm</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #0a0a0b;
            color: #ffffff;
            min-height: 100vh;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1C1C1E;
            color: #FFFFFF;
            padding: 16px 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0066FF;
            text-decoration: none;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 40px;
        }

        .nav-links li a {
            color: #FFF;
            text-decoration: none;
            font-weight: 400;
            transition: color 0.3s;
        }

        .nav-links li a:hover {
            color: #00ffff;
        }

        .header-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .user-name {
            color: #00ffff;
            font-weight: 500;
        }

        .logout-btn {
            padding: 8px 20px;
            color: #fff;
            background: linear-gradient(90deg, #ff4757, #ff6348);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(255, 71, 87, 0.5);
        }

        /* SIDEBAR */
        .container {
            display: flex;
            min-height: calc(100vh - 72px);
        }

        .sidebar {
            width: 280px;
            background: #1C1C1E;
            padding: 30px 0;
            border-right: 1px solid #2a2a2c;
        }

        .profile-section {
            text-align: center;
            padding: 0 20px 30px;
            border-bottom: 1px solid #2a2a2c;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #00ffff;
            margin-bottom: 15px;
            object-fit: cover;
        }

        .profile-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 5px;
        }

        .profile-email {
            font-size: 0.9rem;
            color: #888;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: block;
            padding: 15px 30px;
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(0, 255, 255, 0.1);
            color: #00ffff;
            border-left-color: #00ffff;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            padding: 40px;
        }

        .welcome-section {
            margin-bottom: 40px;
        }

        .welcome-title {
            font-size: 2rem;
            background: linear-gradient(90deg, #00D4FF, #AE00FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .welcome-text {
            color: #888;
            font-size: 1.1rem;
        }

        /* STATS CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #1C1C1E;
            padding: 25px;
            border-radius: 15px;
            border: 2px solid #00ffff;
            box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #00ffff;
        }

        /* QUICK ACTIONS */
        .quick-actions {
            background: #1C1C1E;
            padding: 30px;
            border-radius: 15px;
            border: 2px solid #00ffff;
        }

        .section-title {
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 20px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            display: block;
            padding: 15px 20px;
            background: linear-gradient(90deg, #0066FF, #8A2BE2);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 20px rgba(0, 102, 255, 0.6);
        }

        /* RESPONSIVE */
        @media screen and (max-width: 1024px) {
            .nav-links {
                gap: 20px;
            }
            
            .sidebar {
                width: 240px;
            }
        }

        @media screen and (max-width: 768px) {
            .header {
                padding: 12px 20px;
            }

            .nav-links {
                display: none;
            }

            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #2a2a2c;
            }

            .main-content {
                padding: 20px;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <a href="{{ route('dashboard') }}" class="logo">TechStorm</a>
        <nav>
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}">Accueil</a></li>
                <li><a href="#">À propos</a></li>
                <li><a href="#">Catalogue</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <div class="header-buttons">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>
    </header>

    <!-- CONTAINER -->
    <div class="container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="profile-section">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=00ffff&color=020024&size=200" 
                     alt="Avatar" 
                     class="profile-avatar">
                <div class="profile-name">{{ Auth::user()->name }}</div>
                <div class="profile-email">{{ Auth::user()->email }}</div>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="{{ route('dashboard') }}" class="active">📊 Tableau de bord</a></li>
                <li><a href="{{ route('profile.edit') }}">👤 Mon profil</a></li>
                <li><a href="#">📦 Mes commandes</a></li>
                <li><a href="#">❤️ Mes favoris</a></li>
                <li><a href="#">⚙️ Paramètres</a></li>
            </ul>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="welcome-section">
                <h1 class="welcome-title">Bienvenue, {{ Auth::user()->name }} !</h1>
                <p class="welcome-text">Vous êtes connecté avec succès à votre compte TechStorm.</p>
            </div>

            <!-- STATS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-label">Commandes</div>
                    <div class="stat-value">0</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">❤️</div>
                    <div class="stat-label">Favoris</div>
                    <div class="stat-value">0</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🛒</div>
                    <div class="stat-label">Panier</div>
                    <div class="stat-value">0</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-label">Total dépensé</div>
                    <div class="stat-value">0 FCFA</div>
                </div>
            </div>

            <!-- QUICK ACTIONS -->
            <div class="quick-actions">
                <h2 class="section-title">Actions rapides</h2>
                <div class="actions-grid">
                    <a href="{{ route('profile.edit') }}" class="action-btn">✏️ Modifier mon profil</a>
                    <a href="#" class="action-btn">🛍️ Voir le catalogue</a>
                    <a href="#" class="action-btn">📦 Mes commandes</a>
                    <a href="#" class="action-btn">💬 Support client</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>