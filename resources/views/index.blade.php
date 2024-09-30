<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickMatch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand {
            font-weight: 600;
        }

        .hero {
            background-position: center;
            color: #000;
            padding: 80px 0;
            text-align: center;
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">QuickMatch</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Campos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Jogos</a></li>
                    @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Painel de Controlo</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Sair</a></li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ url('login') }}">Iniciar Sessão</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary" href="{{ url('register') }}">Começar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1>Comunique. Colabore. Jogue.</h1>
            <p>Organize as suas partidas de futebol com facilidade e agilidade. Encontre os melhores campos perto de si!</p>
            <a href="{{ url('/campos') }}" class="btn btn-primary btn-lg mt-4">Começar Agora</a>
        </div>
    </div>

    <!-- Info Section -->
    <div class="container py-5 text-center">
        <h2 class="display-5 mb-5">Como Funciona?</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card p-4 bg-light rounded">
                    <div class="card-body">
                        <i class="bi bi-map-fill display-4 text-primary"></i>
                        <h5 class="card-title">Encontre Campos</h5>
                        <p class="card-text">Navegue pela nossa lista de campos disponíveis e encontre o campo ideal perto de si.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 bg-light rounded">
                    <div class="card-body">
                        <i class="bi bi-calendar-check-fill display-4 text-success"></i>
                        <h5 class="card-title">Organize Jogos</h5>
                        <p class="card-text">Crie e organize partidas com os seus amigos de maneira simples e eficiente.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 bg-light rounded">
                    <div class="card-body">
                        <i class="bi bi-people-fill display-4 text-warning"></i>
                        <h5 class="card-title">Encontre Outros Jogadores</h5>
                        <p class="card-text">Conecte-se com jogadores da sua área que partilham a sua paixão pelo desporto.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-4 bg-light rounded">
                    <div class="card-body">
                        <i class="bi bi-person-plus-fill display-4 text-danger"></i>
                        <h5 class="card-title">Registe-se Agora</h5>
                        <p class="card-text">Crie a sua conta gratuitamente e tenha acesso a todos os recursos para gerir as suas partidas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <h2>Pronto para jogar?</h2>
        <p>Junte-se agora e reserve o seu campo preferido!</p>
        <a href="{{ url('/register') }}" class="btn btn-dark btn-lg">Registe-se Agora</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>