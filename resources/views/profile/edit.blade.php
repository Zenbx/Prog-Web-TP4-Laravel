<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mon Profil - TechStorm</title>
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
            background: radial-gradient(circle at 85% 20%, rgba(0, 255, 255, 1) 0%, rgba(0, 255, 255, 1) 0%, rgba(2, 0, 36, 1) 20%),
                        radial-gradient(circle at 70% 70%, rgba(0, 255, 255, 1) 0%, rgba(0, 255, 255, 1) 0%, rgba(2, 0, 36, 1) 30%);
            background-blend-mode: soft-light;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #00ffff;
            text-decoration: none;
            margin-bottom: 30px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .back-btn:hover {
            text-shadow: 0 0 10px #00ffff;
            transform: translateX(-5px);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-title {
            font-size: 2.5rem;
            background: linear-gradient(90deg, #00D4FF, #AE00FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .profile-subtitle {
            color: #fff;
            font-size: 1.1rem;
        }

        .profile-grid {
            display: grid;
            gap: 30px;
        }

        .profile-card {
            background: #020024;
            border: 2px solid #00ffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }

        .card-title {
            font-size: 1.5rem;
            color: #00ffff;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #00ffff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #00ffff;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            background: #121024;
            color: white;
            padding: 12px 16px;
            border-radius: 10px;
            border: 2px solid #00ffff;
            transition: box-shadow 0.3s;
            font-size: 0.95rem;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-input:focus {
            outline: none;
            box-shadow: 0 0 10px #00ffff;
        }

        .form-input:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .error-message {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.5);
            color: #ff6b6b;
            padding: 10px;
            border-radius: 8px;
            margin-top: 8px;
            font-size: 14px;
        }

        .success-message {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid rgba(0, 255, 0, 0.5);
            color: #51cf66;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-primary {
            flex: 1;
            padding: 12px 20px;
            background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(174, 0, 255, 1) 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.6);
            transform: translateY(-2px);
        }

        .btn-danger {
            padding: 12px 20px;
            background: linear-gradient(90deg, #ff4757, #ff6348);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            box-shadow: 0 0 20px rgba(255, 71, 87, 0.6);
            transform: translateY(-2px);
        }

        .danger-zone {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #ff4757;
        }

        .danger-title {
            color: #ff4757;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .danger-text {
            color: #ccc;
            margin-bottom: 20px;
        }

        /* RESPONSIVE */
        @media screen and (max-width: 768px) {
            body {
                padding: 20px 15px;
            }

            .profile-title {
                font-size: 2rem;
            }

            .profile-card {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-btn">
            ← Retour au dashboard
        </a>

        <div class="profile-header">
            <h1 class="profile-title">Mon Profil</h1>
            <p class="profile-subtitle">Gérez vos informations personnelles</p>
        </div>

        <div class="profile-grid">
            <!-- INFORMATIONS PERSONNELLES -->
            <div class="profile-card">
                <h2 class="card-title">📝 Informations personnelles</h2>

                @if (session('status') === 'profile-updated')
                    <div class="success-message">
                        ✅ Profil mis à jour avec succès !
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label class="form-label" for="name">Nom complet</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-input" 
                               value="{{ old('name', $user->name) }}" 
                               required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Adresse e-mail</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input" 
                               value="{{ old('email', $user->email) }}" 
                               required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">💾 Enregistrer les modifications</button>
                    </div>
                </form>
            </div>

            <!-- CHANGER LE MOT DE PASSE -->
            <div class="profile-card">
                <h2 class="card-title">🔒 Changer le mot de passe</h2>

                @if (session('status') === 'password-updated')
                    <div class="success-message">
                        ✅ Mot de passe mis à jour avec succès !
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label" for="current_password">Mot de passe actuel</label>
                        <input type="password" 
                               id="current_password" 
                               name="current_password" 
                               class="form-input" 
                               required>
                        @error('current_password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Nouveau mot de passe</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-input" 
                               required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-input" 
                               required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">🔑 Mettre à jour le mot de passe</button>
                    </div>
                </form>
            </div>

            <!-- SUPPRIMER LE COMPTE -->
            <div class="profile-card">
                <h2 class="card-title">⚠️ Zone dangereuse</h2>
                
                <div class="danger-zone">
                    <h3 class="danger-title">Supprimer mon compte</h3>
                    <p class="danger-text">
                        Une fois votre compte supprimé, toutes vos données seront définitivement effacées. 
                        Cette action est irréversible.
                    </p>

                    <form method="POST" action="{{ route('profile.destroy') }}" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')

                        <div class="form-group">
                            <label class="form-label" for="password_delete">Confirmez avec votre mot de passe</label>
                            <input type="password" 
                                   id="password_delete" 
                                   name="password" 
                                   class="form-input" 
                                   placeholder="Entrez votre mot de passe"
                                   required>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-danger">🗑️ Supprimer définitivement mon compte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>