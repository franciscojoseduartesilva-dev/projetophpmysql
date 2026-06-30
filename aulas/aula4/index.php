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
    <?php $numaula = "Aula 4" ?>
    <?php require_once  APP_COMPONENTES . '/nav.php'; ?>

    <?php require_once APP_COMPONENTES . '/header.php' ?>

    <main>

        <div class="container">
            <div class="row">
                <div class="col-12">

                    <h3>condicional if</h3>

                    <?php
                    $valor = 100;

                    ?>
                    <p>
                        <?php

                        if ($valor == 100) {

                            echo "valor " . $valor . " e igual a 100";
                        } else {
                            echo "valor" . $valor . " não e igual a 100";
                        }


                        ?>
                    </p>

                    <h4>2.Intervalo</h4>

                    <P>
                        <?php
                        if ($valor >= 100) {
                            echo "valo" . $valor . " e mair do que 100";
                        } else {

                            echo "valor" . $valor . "não e mair do que 100";
                        }

                        ?>

                    </P>


                    <h4>Recebendo valores de links</h4>
                    clique para ativar e clique para desativar
                    <a href="?acao=1" class="btn btn-success btn-sm">
                        Ativavar ação
                    </a>
                    <a href="?acao=2" class="btn btn-warning btn-sm">
                        Desativar ação
                    </a>

                    <a href="?acao=0" class="btn btn-defalt btn-sm">
                        Resetar
                    </a>

                    <?php

                        if (!empty($_GET['acao'])) {

                        if ($_GET['acao']==1) {

                            echo '<div class="alert alert-success" role="alert">
                                Cadastro realizado com sucesso!
                                </div>
                                ';
                        } else {

                            echo '<div class="alert alert-warning" role="alert">
                                    Atenção! Verifique os campos obrigatórios antes de continuar.
                                    </div>
                                    ';
                        }
                    }



                    ?>

                    <h4>if e else if</h4>

                    <?php 
                        $media="3";
                        if($media>=7){
                            echo "aprovado";

                        }  
                        
                        elseif($media>=4){
                            echo "Recuperacao";

                        } else {
                            echo "reprovado";
                        }



                     ?>

                </div>
            </div>
        </div>

    </main>
    <?php require_once APP_COMPONENTES . '/footer.php' ?>

    <!-- Bootstrap JavaScript Bundle (includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>