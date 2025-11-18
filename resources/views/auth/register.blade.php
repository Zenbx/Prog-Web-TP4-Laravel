<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - TechStorm</title>
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
            background-size: cover;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            padding: 20px;
            gap: 2rem;
        }

        .Author {
            color: White;
            font-size: 50px;
            font-weight: 700;
        }

        .login-card {
            background: #020024;
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
            justify-content: center;
            padding: 40px 30px;
            border-radius: 20px;
            border: 2px solid #00ffff;
            box-shadow: 0 0 10px #00ffff;
            width: 100%;
            max-width: 450px;
        }

        #CreerUnCompte {
            background: linear-gradient(90deg, #00D4FF, #AE00FF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        #google-btn {
            width: 100%;
            background: #121024;
            color: white;
            padding: 12px 16px;
            border-radius: 10px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 2px solid #00ffff;
            cursor: pointer;
            transition: box-shadow 0.3s;
            font-size: 0.95rem;
        }

        #google-btn:hover {
            box-shadow: 0 0 10px #00ffff;
        }

        .login-card #google-btn img {
            width: 20px;
            height: 20px;
        }

        #ou {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: white;
            margin: 20px 0;
            width: 100%;
        }

        .line {
            flex: 1;
            height: 1px;
            background-color: white;
        }

        .form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .form input {
            width: 100%;
            background: #121024;
            color: white;
            padding: 12px 16px;
            margin-top: 15px;
            border-radius: 10px;
            border: 2px solid #00ffff;
            transition: box-shadow 0.3s;
            font-size: 0.95rem;
        }

        .form input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form input:hover,
        .form input:focus {
            box-shadow: 0 0 10px #00ffff;
            outline: none;
        }

        #signUp-btn {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 15px;
            padding: 12px 16px;
            background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(174, 0, 255, 1) 100%);
            border-radius: 10px;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: box-shadow 0.3s;
            font-size: 1rem;
        }

        #signUp-btn:hover {
            box-shadow: 0 0 10px #00ffff;
        }

        .register {
            margin-top: 10px;
        }

        #DejaCompte {
            color: white;
            font-size: 14px;
        }

        #ConnectezVous {
            color: #00D4FF;
            font-size: 14px;
            text-decoration: none;
            transition: text-shadow 0.3s;
        }

        #ConnectezVous:hover {
            text-shadow: 0 0 10px #00ffff;
        }

        .error-message {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.5);
            color: #ff6b6b;
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 14px;
            width: 100%;
        }

        .error-input {
            border-color: #ff6b6b !important;
        }

        /* RESPONSIVE - TABLETTES */
        @media screen and (max-width: 1024px) {
            body {
                gap: 3rem;
            }

            .Author {
                font-size: 40px;
            }

            .login-card {
                max-width: 400px;
            }
        }

        /* RESPONSIVE - MOBILE */
        @media screen and (max-width: 768px) {
            body {
                flex-direction: column;
                gap: 2rem;
                padding: 30px 20px;
            }

            .Author {
                font-size: 36px;
                text-align: center;
            }

            .login-card {
                max-width: 100%;
                padding: 30px 25px;
            }

            #CreerUnCompte {
                font-size: 1.8rem;
            }

            #google-btn {
                font-size: 0.9rem;
                padding: 10px 14px;
            }

            .form input {
                padding: 10px 14px;
                font-size: 0.9rem;
            }

            #signUp-btn {
                font-size: 0.95rem;
                padding: 10px 14px;
            }
        }

        /* RESPONSIVE - PETIT MOBILE */
        @media screen and (max-width: 480px) {
            body {
                padding: 20px 15px;
            }

            .Author {
                font-size: 28px;
            }

            .login-card {
                padding: 25px 20px;
            }

            #CreerUnCompte {
                font-size: 1.5rem;
            }

            #google-btn {
                font-size: 0.85rem;
                padding: 8px 12px;
            }

            .form input {
                padding: 8px 12px;
                font-size: 0.85rem;
                margin-top: 12px;
            }

            #signUp-btn {
                font-size: 0.9rem;
                padding: 9px 12px;
            }

            #DejaCompte,
            #ConnectezVous {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="Author">TechStorm</div>
    <div class="login-card">
        <h1 id="CreerUnCompte">Créer un compte</h1>

        <button id="google-btn" type="button">
            <div><img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" /></div>
            <div>S'inscrire avec Google</div>
        </button>

        <div id="ou">
            <div class="line"></div>
            <div>OU</div>
            <div class="line"></div>
        </div>

        <form method="POST" action="{{ route('register') }}" class="form">
            @csrf

            <div>
                <input type="text" 
                       name="name" 
                       placeholder="Pseudo" 
                       value="{{ old('name') }}"
                       class="@error('name') error-input @enderror"
                       required 
                       autofocus />
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="email" 
                       name="email" 
                       placeholder="E-mail" 
                       value="{{ old('email') }}"
                       class="@error('email') error-input @enderror"
                       required />
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="password" 
                       name="password" 
                       placeholder="Mot de passe"
                       class="@error('password') error-input @enderror"
                       required />
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <input type="password" 
                       name="password_confirmation" 
                       placeholder="Confirmer le mot de passe"
                       required />
            </div>

            <button type="submit" id="signUp-btn">S'INSCRIRE</button>
        </form>

        <p class="register">
            <span id="DejaCompte">Déjà un compte?</span> 
            <a href="{{ route('login') }}" id="ConnectezVous">Connectez Vous</a>.
        </p>
    </div>
</body>
</html>