 
 <?php require_once __DIR__.'/componentes/rotas.php' ?>
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
    <?php require_once APP_COMPONENTES.'/nav.php'; ?>

    <!-- HEADER -->
    
    <?php require_once APP_COMPONENTES.'/HEADER.PHP'; ?>
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
    

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>