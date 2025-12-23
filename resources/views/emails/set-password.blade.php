<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6f8;
            color: #333;
            line-height: 1.6;
            padding: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            width: 140px;
        }
        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: #fff;
            padding: 12px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo-Mediweb.png') }}" alt="Logo Mediweb">
        </div>

        <p>Bonjour <strong>{{ $prenom }} {{ $nom }}</strong>,</p>

        <p>Votre compte a été créé avec succès sur le <strong>Dashboard Mediweb</strong>.</p>

        <p>Pour accéder à votre espace, veuillez définir votre mot de passe en cliquant sur le bouton ci-dessous :</p>

        <p style="text-align:center;">
            <a href="{{ $url }}" class="btn">Définir mon mot de passe</a>
        </p>

        <p>Ce lien est valide pendant 24 heures. Si vous n’avez pas demandé la création de ce compte, ignorez cet email.</p>

        <div class="footer">
            © {{ date('Y') }} Mediweb. Tous droits réservés.
        </div>
    </div>
</body>
</html>
