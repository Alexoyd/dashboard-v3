"<!DOCTYPE html>
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
        .info-box {
            background-color: #f0f9ff;
            border-left: 4px solid #2563eb;
            padding: 15px;
            margin: 20px 0;
        }
        .info-box p {
            margin: 5px 0;
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

        <h2 style="color: #2563eb; margin-bottom: 20px;">Nouveau questionnaire médical reçu</h2>

        <p>Un nouveau questionnaire médical a été rempli sur le site.</p>

        <div class="info-box">
            <p><strong>Nom :</strong> {{ $nom }}</p>
            <p><strong>Prénom :</strong> {{ $prenom }}</p>
            <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($date)->format('d/m/Y à H:i') }}</p>
            @if(isset($type) && $type)
            <p><strong>Type :</strong> {{ $type === 'questionnaire_medical' ? 'Questionnaire médical' : ucfirst(str_replace('_', ' ', $type)) }}</p>
            @endif
        </div>

        <p>Connectez-vous au dashboard pour consulter ce nouveau questionnaire.</p>

        <p style="text-align:center;">
            <a href="{{ url('/clients') }}" class="btn">Accéder au dashboard</a>
        </p>

        <div class="footer">
            © {{ date('Y') }} Mediweb. Tous droits réservés.
        </div>
    </div>
</body>
</html>
"