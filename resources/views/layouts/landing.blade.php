<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabrux — Gestão de Produção Modular</title>
    <meta name="description" content="Sistema moderno para gestão de produção, orçamentos, relatórios e controle por funcionário. Modular, seguro e personalizável.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --landing-text: #0f2742;
            --landing-text-soft: #315475;
            --landing-border: #dce7f3;
            --landing-shadow: 0 18px 42px rgba(11, 31, 57, 0.16);
        }

        body {
            font-family: 'Manrope', 'Segoe UI', sans-serif;
            color: var(--landing-text);
        }

        .brand {
            font-family: 'Space Grotesk', 'Segoe UI', sans-serif;
            letter-spacing: 0.2px;
        }

        .landing-card {
            border: 1px solid var(--landing-border);
            box-shadow: var(--landing-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .landing-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 22px 44px rgba(11, 31, 57, 0.2);
        }

        .hero-highlight {
            background-image: linear-gradient(120deg, #0f4f87, #1d6ea7);
        }

        .reveal {
            opacity: 0;
            transform: translateY(16px);
            animation: reveal-up 0.7s ease forwards;
        }

        @keyframes reveal-up {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 767.98px) {
            .landing-card:hover {
                transform: none;
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
