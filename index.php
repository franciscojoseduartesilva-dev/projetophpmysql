 <?php require_once __DIR__ . '/componentes/config.php'; ?>
 <?php require_once __DIR__ . '/componentes/rotas.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body{
            min-height:100vh;
            display:flex;
            flex-direction:column;
            background:#f8f9fa;
        }

        main{
            flex:1;
        }

        section{
            padding:40px 0;
        }

        .card-dashboard{
            border:none;
            border-radius:15px;
            transition:.3s;
            box-shadow:0 5px 15px rgba(0,0,0,.08);
        }

        .card-dashboard:hover{
            transform:translateY(-6px);
            box-shadow:0 10px 25px rgba(0,0,0,.15);
        }

        .card-dashboard i{
            font-size:3rem;
            margin-bottom:15px;
        }

        .welcome-box{
            background:white;
            border-radius:15px;
            padding:30px;
            box-shadow:0 5px 15px rgba(0,0,0,.08);
        }

        .btn-action{
            min-width:180px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php require_once APP_COMPONENTES.'/nav.php'; ?>

<!-- Header -->
<?php require_once APP_COMPONENTES.'/header.php'; ?>

<main>

    <!-- Boas-vindas -->
    <section>
        <div class="container">

            <div class="welcome-box mb-5">

                <div class="row align-items-center">

                    <div class="col-lg-8">
                        <h2 class="fw-bold">
                            Bem-vindo ao Sistema de Controle de Estoque
                        </h2>

                        <p class="text-muted mb-0">
                            Gerencie produtos, acompanhe entradas e saídas
                            e mantenha seu estoque sempre atualizado.
                        </p>
                    </div>

                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                        <a href="#" class="btn btn-primary btn-action">
                            <i class="bi bi-plus-circle"></i>
                            Novo Produto
                        </a>

                    </div>

                </div>

            </div>

            <!-- Cards -->

            <div class="row g-4">

                <div class="col-md-4">

                    <div class="card card-dashboard text-center h-100">

                        <div class="card-body">

                            <i class="bi bi-box-seam text-primary"></i>

                            <h5>Produtos</h5>

                            <h2 class="fw-bold">125</h2>

                            <p class="text-muted">
                                Produtos cadastrados.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card card-dashboard text-center h-100">

                        <div class="card-body">

                            <i class="bi bi-arrow-down-circle text-success"></i>

                            <h5>Entradas</h5>

                            <h2 class="fw-bold">38</h2>

                            <p class="text-muted">
                                Entradas registradas.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card card-dashboard text-center h-100">

                        <div class="card-body">

                            <i class="bi bi-arrow-up-circle text-danger"></i>

                            <h5>Saídas</h5>

                            <h2 class="fw-bold">17</h2>

                            <p class="text-muted">
                                Saídas registradas.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Ações rápidas -->

            <div class="mt-5">

                <h3 class="mb-4">
                    Ações rápidas
                </h3>

                <div class="d-flex flex-wrap gap-3">

                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-box"></i>
                        Produtos
                    </a>

                    <a href="#" class="btn btn-outline-success">
                        <i class="bi bi-arrow-down-circle"></i>
                        Registrar Entrada
                    </a>

                    <a href="#" class="btn btn-outline-danger">
                        <i class="bi bi-arrow-up-circle"></i>
                        Registrar Saída
                    </a>

                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-graph-up"></i>
                        Relatórios
                    </a>

                </div>

            </div>

        </div>
    </section>

</main>

<!-- Footer -->
<?php require_once APP_COMPONENTES.'/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>