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
            crossorigin="anonymous"
        />
    </head>

    <body>
        <!-- nav -->
         <?php $numaula="Aula 2"?>
         <?php require_once '../componentes/nav.php' ?>

         <?php require_once '../componentes/header.php' ?>

        <main>
             
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php
                          
                          $nome = "paula lins";
                          $valor = 100;
                          $moeda = 15.59;
                          $status = true;

                        ?>

                        <p>
                            nome <br>
                            <?php var_dump($nome); ?>
                        </p>
                        <p>
                            valo : <br>
                            <?php var_dump($valor); ?>
                        </p>
                        <p>
                            nome <br>
                            <?php var_dump($moeda); ?>
                        </p>
                        <p>
                            nome <br>
                            <?php var_dump($status); ?>
                        </p>

                        <h1>operadores</h1>
                        <?php
                        $valor1 = 1250;
                        $valor2 = 15;

                        ?>
                        <h3>soma</h3>
                        <?php $total = $valor1 + $valor2;  ?>
                        A soma de <?php echo $valor1;?> 
                        
                        + <?php echo $valor2;?> e igual a :
                        <?php echo $total;?>

                    </div>
                </div>
            </div>

        </main>
        <?php require_once '../componentes/footer.php' ?>

        <!-- Bootstrap JavaScript Bundle (includes Popper) -->
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
