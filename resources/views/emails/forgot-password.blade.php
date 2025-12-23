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

        <h2 style="color: #2563eb; margin-bottom: 20px;">Réinitialisation de votre mot de passe</h2>

        <p>Bonjour,</p>

        <p>Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
		
        <p style="text-align:center;">
<<<<<<< HEAD
    		<a href={{ $lien_reinitialisation ?? $url ?? '#' }} class=\"btn\">Réinitialiser mon mot de passe</a>
=======
            //<a href="{{ $url ?? '#' }}" class="btn">Réinitialiser mon mot de passe</a>
    		<a href=\"{{ $lien_reinitialisation ?? $url ?? '#' }}\" class=\"btn\">Réinitialiser mon mot de passe</a>
>>>>>>> bdc02d30d3cfb6b94e9d652cae4111923b435f04
        </p>

        <p>Ce lien de réinitialisation expirera dans 60 minutes.</p>

        <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune action n'est requise de votre part.</p>

        <div class="footer">
            © {{ date('Y') }} Mediweb. Tous droits réservés.
        </div>
    </div>
</body>
</html>
