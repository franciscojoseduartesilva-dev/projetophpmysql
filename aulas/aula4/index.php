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

                    <h4>desafio da maior idade</h4>

                    <?php
                        $nome = "";

                        $idade = 18;
                        
                        
                        if ($idade>= 18) {
                                echo "<div class='alert alert-success'>";
                                echo "Acesso permitido para " .$idade;
                                echo "</div>";
                            } else {
                                echo "<div class='alert alert-danger'>";
                                echo "Acesso negado para " .$idade;
                                echo "</div>";
                            }


                    ?>
                    <h4>aprovacao por media</h4>

                    <?php
                    $aluno = "joao";

                    $media = 9;

                    echo "<p>aluno: ".$aluno. "</p>";

                    echo "<P>media: " .$media ."</P>";


                    if ($media>= 7) {
                        echo "<div class='alert alert-success'>
                        aluno aprovado.</div>";

                    } else {
                        echo "<div class='alert alert-danger'>aluno reprovado.</div>";
                    }

                    ?>

                    <h4>classificação escolar com elseif</h4>

                    <?php
                    
                    $aluno = "paulo";

                    $media = 7;


                    if ($media>= 7) {
                        echo "<div class='alert alert-success'>aprovado</div>";

                    } elseif ($media>= 5) {
                        echo "<div class='alert alert-warning'>recuperação</div>";

                    } else {
                        echo "<div class='alert alert-danger'>reprovado</div>";
                    }

                     ?>


                    <h4>verificação de estoque</h4>

                    <?php
                    
                    $produto = "";
                    $estoque = 10;

                    echo "<p>produto: " .$produto. "</p>";

                    echo "<p>estoque atual: ".$estoque ."</p>";

                    if ($estoque>= 10) {
                        echo "<div class='alert alert-warning'>estoque baixo.
                        atenção para reposição</div>";

                    } else {
                        echo "<div class='alert alert-danger'>produto sem estoque.</div>";
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