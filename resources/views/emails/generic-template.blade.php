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
        .content {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo-Mediweb.png') }}" alt="Logo Mediweb">
        </div>

        <div class="content">
            {!! nl2br(e($contentHtml)) !!}
        </div>

        <div class="footer">
            © {{ date('Y') }} Mediweb. Tous droits réservés.
        </div>
    </div>
</body>
</html>