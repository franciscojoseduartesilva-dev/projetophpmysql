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
    <?php $numaula = "Aula 2 - Tipagem automática"; ?>
    <?php require_once '../componentes/nav.php'; ?>
    <?php require_once '../componentes/header.php'; ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <?php
                    $nome = "Paula Lins";
                    $valor = 100;
                    $moeda = 15.59;
                    $status = true;
                    $nulo = null;

                    $dados = ["Antônio", 10, 15.25, true];
                    ?>

                    <p>
                        Nome: <br>
                        <?php var_dump($nome); ?>
                    </p>
                    <p>
                        Valor : <br>
                        <?php var_dump($valor); ?>
                    </p>

                    <p>
                        Moeda: <br>
                        <?php var_dump($moeda); ?>
                    </p>

                    <p>
                        Status: <br>
                        <?php var_dump($status); ?>
                    </p>
                    <p>
                        Nulo: <br>
                        <?php var_dump($nulo); ?>
                    </p>
                    <p>
                        Array: <br>
                        <?php var_dump($dados); ?>
                    </p>

                    <h1>Operadores</h1>
                    <?php
                    $valor1 = 1250;
                    $valor2 = 15;

                    //    number_format($valor1, 2, ',', '.');
                    ?>
                    <h3>Soma</h3>
                    <?php $total = $valor1 + $valor2;     ?>
                    A soma de <?php echo $valor1; ?>
                    + <?php echo $valor1; ?> é igual a :
                    <?php echo $total; ?>

                    <h3>Multiplicação</h3>
                    <?php
                    $produto ="GELADEIRA";
                    $precounitario = 2850;
                    $quantidade = 3;

                    $total = $precounitario * $quantidade;

                    ?>

                    <p>
                        O produto <?php echo $produto;?> <br>
                        Preço unitário : <?php echo $precounitario;?><br>
                        Quantidade: <?php echo $quantidade;?><br>
                        Total da Venda: R$ <?php echo $total;?>
                    </p>



                    <h3>Multiplicação</h3>
                    <p>Aqui as operações</p>


                    <h3>Divisão</h3>
                    <p>Aqui as operações</p>






                </div>
            </div>
        </div>
    </main>

    <?php require_once '../componentes/footer.php'; ?>
    <!-- Bootstrap JavaScript Bundle (includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>