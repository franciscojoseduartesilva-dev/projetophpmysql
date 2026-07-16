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
    <?php $numaula = "Aula 6"; ?>
    <?php require_once APP_COMPONENTES . '/nav.php'; ?>
    <?php require_once APP_COMPONENTES . '/header.php'; ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Arrays</h3>
                    <?php
                    $produtos = ["Mouse", "Teclado", "Monitor"];
                    echo $produtos[0];
                    echo "<br>";
                    echo $produtos[1];
                    echo "<br>";
                    echo $produtos[2];
                    ?>
                    <h4>Array + foreach</h4>
                    <?php
                    $pessoas = [
                        "Paula Lins",
                        "Antônio Carlos",
                        "Paulo Roberto",
                        "Maria do Carmo",
                        "José Lima",
                        "Eduardo Mello"
                    ];
                    foreach ($pessoas as $key => $mickey) {

                        echo $key + 1  . " Nome: " . $mickey . "<br>";
                    }
                    ?>


                    <h3>Array Associativa</h3>

                    <?php

                    $pessoas = [
                        "Nome" => "Paula Lins",
                        "Idade" => 54,
                        "Naturalidade" => "Quixeramobim"
                    ];

                    ?>

                    <p>Dados do Usuário</p>
                    Nome: <?php echo $pessoas["Nome"]; ?> <br>
                    Idade: <?= $pessoas["Idade"]; ?> <br>
                    Naturalidade: <?= $pessoas["Naturalidade"]; ?> <br>

                    <h4>Array Multidimensional</h4>

                    <?php

                    $pessoas = [
                        [
                            "Nome" => "Paula Lins",
                            "Idade" => 54,
                            "Naturalidade" => "Baturité"
                        ],
                        [
                            "Nome" => "Carlos Lima",
                            "Idade" => 34,
                            "Naturalidade" => "Camocim"
                        ],
                        [
                            "Nome" => "Mariana Sousa",
                            "Idade" => 28,
                            "Naturalidade" => "Pacatuba"
                        ],


                    ];


                    echo $pessoas[2]["Nome"] . "<br>";

                    ?>

                    <?php

                    foreach($pessoas as $key => $dados) {
                        
                    echo $dados["Nome"] . "<br>";
                    }

                    ?>

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