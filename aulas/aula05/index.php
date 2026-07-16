<?php require_once dirname(__DIR__) . '/componentes/rotas.php'; ?>
<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS v5.3.8 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
</head>

<body>
    <?php $numaula = "Aula 4"; ?>
    <?php require_once APP_COMPONENTES . '/nav.php'; ?>
    <?php require_once APP_COMPONENTES . '/header.php'; ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Uso do For</h3>

                    <form method="post" class="card card-body shadow-sm mb-4">
                        <h4>Input number + botão</h4>

                        <div class="input-group">
                            <input
                                type="number"
                                class="form-control"
                                id="quantidade"
                                name="quantidade"
                                min="0"
                                placeholder="Digite a quantidade">

                            <button type="submit" class="btn btn-success">
                                Atualizar estoque
                            </button>
                        </div>
                    </form>

                    <?php

                    $quant = "0";

                    if (!empty($_POST['quantidade'])) {
                        $quant = $_POST['quantidade'];
                    }

                    for ($i = 1; $i <= $quant; $i++) {
                        echo '<div class="card">
                            <div class="card-header">
                            Módulo 1
                            </div>
                            <div class="card-body">
                            <h5 class="card-title">Introdução ao Bootstrap</h5>
                            <p class="card-text">Aprenda a montar layouts responsivos.</p>
                            </div>
                            <div class="card-footer text-body-secondary">
                            Atualizado hoje
                            </div>
                            </div>
';
                    }



                    ?>



                    <h4>For com array</h4>
                    <?php
                    $dados = [
                        "PHP",
                        "MYSQL",
                        "JAVA",
                        "PYTHON",
                        "CSS",
                        "HTML"
                    ];
                    $descricao = [
                        "Linguahem de Programação",
                        "Banco de dados",
                        "Linguagem de Programação",
                        "Linguagem de Programação",
                        "Estrutura de Formatação",
                        "Estrutura de sustentação de página "
                    ];
                    $quant = count($dados);
                    ?>

                    <p>
                        <?php

                        for ($i = 0; $i < $quant; $i++) {

                            echo $dados[$i]." " .$descricao[$i]."<br>";

                        }

                        ?>
                    </p>


                </div>
            </div>
        </div>
    </main>

    <?php require_once APP_COMPONENTES . '/footer.php'; ?>

    <!-- Bootstrap JavaScript Bundle (includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>