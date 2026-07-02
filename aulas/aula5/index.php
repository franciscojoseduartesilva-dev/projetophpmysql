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
    <!-- nav -->
    <?php $numaula = "Aula 5" ?>
    <?php require_once  APP_COMPONENTES . '/nav.php'; ?>

    <?php require_once APP_COMPONENTES . '/header.php' ?>

    <main>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>uso do For</h3>

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
                        echo '<div class="card" style="width: 18rem;">
                        <div class="card-body">
                        <h5 class="card-title">Curso de PHP</h5>
                         <p class="card-text">Aprenda PHP do zero com exemplos práticos.</p>
                            <a href="#" class="btn btn-primary">Acessar</a>
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
                    $descricao=[
                        "linguahem de programação",
                        "Banco de dados",
                        "linguagem de programação",
                        "linguagem de programação",
                        "Estrutura de Formatação",
                        "Estrutura de sustentação de página"
                    ];
                    $quant = count($dados); 

                     ?>

                    <p>
                        <h2>desafio1</h2>

                        <?php 
                        for ($i = 0;$i<$quant;$i++) {
                            
                            echo $dados[$i]."".$descricao[$i]."<br>";
                        }

                         ?>
                         
                    </p>


                    <p>
                        <h2>desafio2</h2>
                       
                        <h4>Contagem Regressiva</h4>

                        <?php
                        for ($i = 10; $i >= 1; $i--) {
                             echo "<p class='badge bg-warning text-dark me-1'>" . $i . "</p>";

                        }

                        ?>

                    </p>

                    <p>
                        <h2>desafio3</h2>
                        <h4>tabuada com php</h4>
                        <?php
                        $numero = 5;

                        echo "<div class='card p-3 shadow-sm'";
                        echo "<h3>tabuada do " .$numero. "</h3>";
                        for ($i = 1; $i <= 10; $i++) {
                            $resultado = $numero * $i;
                            echo $numero . "x" . $i . "=" .$resultado. "<br>";
                        }
                        echo "</div>";

                        ?>
                    </p>




                </div>
            </div>
        </div>

    </main>
    <?php require_once '../componentes/footer.php' ?>

    <!-- Bootstrap JavaScript Bundle (includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>