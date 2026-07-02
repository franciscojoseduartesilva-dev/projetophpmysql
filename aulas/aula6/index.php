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
    <?php $numaula = "Aula 6" ?>
    <?php require_once  APP_COMPONENTES . '/nav.php'; ?>

    <?php require_once APP_COMPONENTES . '/header.php' ?>

    <main>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Título estudo</h3>

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
                        "paula lins",
                        "Antonio carlos",
                        "paulo roberto",
                        "Maria do carmo",
                        "jose lima",
                        "Eduardo Melo"

                    ];
                    
                    foreach($pessoas as $key=> $mickey) {
                        
                        echo $key+1 ."nome:" .$mickey. "<br>";
                    }
                     ?>

                     <h3>Array Associativa</h3>

                     <?php
                     $pessoas = [
                        "nome" => "paula lin",
                        "idade" => 54,
                        "Naturalidade" => "quixeramobim"
                     ]; 

                      ?>

                      <p>Dados do usuario</p>
                      Nome: <?php echo $pessoas["nome"]; ?> <br>
                      idade: <?=$pessoas["idade"]; ?> <br>
                      Naturalidade: <?= $pessoas["Naturalidade"]; ?> <br>

                      <h4>Array mutidimensonal</h4>

                      <?php
                      $produtos = [
                        [
                        "nome" => "Teclado",
                        "preco" => 120.00,
                        "estoque" => 5
                      ],
                      
                      [
                        "nome" => "Mouse",
                        "preco" => 80.00,
                        "estoque" => 10
                      ],

                      [
                        "nome" => "Monitor",
                        "preco" => 750.00,
                        "estoque" => 3
                        ]

                        ]
                       ?>



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