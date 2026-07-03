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
                    <h3>desafio1</h3>

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
                     <h3>desafio2</h3>

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

                        ];
                        for ($i = 0; $i < count($produtos); $i++) {
                            echo "<p>";
                            echo "Produto: " . $produtos[$i]["nome"] . "<br>";
                            echo "Preço: R$ " . number_format($produtos[$i]["preco"], 2, ',', '.') . "<br>";
                            echo "Estoque: " . $produtos[$i]["estoque"];
                            echo "</p>";
                        };
                       ?>

                       <h3>DESAFIO 4 — Card de produto com array associativo</h3>
                       <?php
                       $produto = [
                        "nome" => "Teclado Mecanico",
                        "categoria" => "Informatica",
                        "preco" => 250.00,
                        "estoque" => 8
                       ]; 
                        ?>
                        <div class="row justify-content-center">
                            <div class="col-md5">
                                <div class="card shadow-sm text-center">
                                    <div class="card-body">
                                       <h5 class="card-title"><?= $produto["nome"]; ?></h5> 
                                        <p class="card-text">categoria: <strong><?=  $produto["categoria"]; ?></strong>
                                        </p>
                                        <p class="card-text">
                                            preco: <R$>
                                            <!-- formate o preco usando number_format -->
                                        </p>

                                        <p class="card-text">
                                            estoque:
                                            <!-- exiba o estoque aqui -->

                                        </p>

                                        <a href="#" class="btn btn-primary">ver produto</a>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <h3>DESAFIO 5 — Array multidimensional de produtos</h3>
                        <?php
                        $produtos = [
                            [
                            "nome" => "mouse",
                            "categoria" => "informatica",
                            "preco" => 80.00,
                            "estoque" => 10
                        ],

                        [
                            "nome" => "caderno",
                            "categoria" => "escritorio",
                            "preco" => 25.00,
                            "estoque" => 30

                        ] 
                        // adicione mais 3 produtos
                        ];
                        [
                            "nome" => "teclado",
                            "categoria" => "informatica",
                            "preco" => 25.00,
                            "estoque" => 15
                        ];

                        [
                            "nome" => "caneta",
                            "categoria" => "escritorio",
                            "preco" => 5.00,
                            "estoque" => 90
                        ];
                        [
                            "nome" => "monitor",
                            "categoria" => "informatica",
                            "preco" => 980.00,
                            "estoque" => 10
                        ];

                         ?>
                        <?php foreach ($produtos as $produto) { ?>
                            <p>
                                <strong><?= $produto["nome"]; ?></strong>
                                -
                                <?= $produto["categoria"]; ?>
                            </p>
                        <?php } ?>









                    </div>                                


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