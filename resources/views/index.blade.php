<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickMatch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            border-bottom: 2px solid #f4f4f4;
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            font-size: 1rem;
            margin-right: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #FFF;
            font-weight: bold;
        }

        .hero {
            /*  background-image: url('{{ asset(' ') }}');  COLOCAR UMA IMAGEM PARA FICAR MAIS BONITO */
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            color: #000;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 20px;
        }

        .info-section {
            padding: 60px 0;
        }

        .info-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .info-card {
            background-color: #f4f4f4;
            border: none;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .info-card:hover {
            transform: translateY(-10px);
        }

        .footer {
            background-color: #007bff;
            color: #FFF;
            padding: 40px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">QuickMatch</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Campos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Jogos</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('dashboard') }}">Painel de Controlo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Sair</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('login') }}">Iniciar Sessão</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary" href="{{ url('register') }}">Começar</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="container">
            <h1>Comunique. Colabore. Jogue.</h1>
            <p>Organize as suas partidas de futebol com facilidade e agilidade. Encontre os melhores campos perto de si!</p>
            <a href="{{ url('/campos') }}" class="btn btn-primary btn-lg mt-4">Começar Agora</a>
        </div>
    </div>

    <div class="container info-section text-center">
        <h2>Como Funciona?</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card info-card">
                    <h5 class="card-title">Encontre Campos</h5>
                    <p class="card-text">Navegue pela nossa lista de campos disponíveis e encontre o campo ideal perto de si.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card info-card">
                    <h5 class="card-title">Organize Jogos</h5>
                    <p class="card-text">Crie e organize partidas com os seus amigos de maneira simples e eficiente.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card info-card">
                    <h5 class="card-title">Encontre Outros Jogadores</h5>
                    <p class="card-text">Conecte-se com jogadores da sua área que partilham a sua paixão pelo desporto.</p>


                </div>
            </div>
            <div class="col-md-3">
                <div class="card info-card">
                    <h5 class="card-title">Registe-se Agora</h5>
                    <p class="card-text">Crie a sua conta gratuitamente e tenha acesso a todos os recursos para gerir as suas partidas.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <h2>Pronto para jogar?</h2>
        <p>Junte-se agora e reserve o seu campo preferido!</p>
        <a href="{{ url('/register') }}" class="btn btn-dark btn-lg">Registe-se Agora</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>