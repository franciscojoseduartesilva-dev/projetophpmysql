<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: #212529;
            color: white;
            text-align: center;
            padding: 1rem;
        }

        header,
        section,
        main {
            padding: 2rem 0;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <!-- Logo / Nome do Projeto -->
            <a class="navbar-brand fw-bold" href="#">
                Controle de Estoque
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <!-- Menus alinhados à direita -->
                <ul class="navbar-nav ms-auto">

                    <!-- Dropdown 1 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            Produtos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Cadastrar</a></li>
                            <li><a class="dropdown-item" href="#">Listar</a></li>
                            <li><a class="dropdown-item" href="#">Categorias</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown 2 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            Movimentações
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Entradas</a></li>
                            <li><a class="dropdown-item" href="#">Saídas</a></li>
                            <li><a class="dropdown-item" href="#">Relatórios</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown 3 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            Configurações
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Usuários</a></li>
                            <li><a class="dropdown-item" href="#">Permissões</a></li>
                            <li><a class="dropdown-item" href="#">Preferências</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <header class="bg-light border-bottom">
        <div class="container">
            <h1>Controle de Estoque</h1>
            <p class="lead">
                Sistema para gerenciamento de produtos e movimentações.
            </p>
        </div>
    </header>

    <!-- SECTION -->
    <section>
        <div class="container">
            <h2>Resumo</h2>
            <p>
                Visualize informações gerais sobre o estoque,
                produtos cadastrados e movimentações recentes.
            </p>
        </div>
    </section>

    <!-- MAIN -->
    <main>
        <div class="container">
            <h2>Painel Principal</h2>

            <div class="row g-4 mt-2">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Produtos</h5>
                            <p class="card-text">
                                Total de produtos cadastrados.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Entradas</h5>
                            <p class="card-text">
                                Controle de entrada de mercadorias.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Saídas</h5>
                            <p class="card-text">
                                Acompanhamento das saídas do estoque.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p class="mb-0">
                &copy; 2026 - Controle de Estoque. Todos os direitos reservados.
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>