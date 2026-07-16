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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- nav -->
    <?php $numaula = "Aula 1-Variáveis"; ?>
    <?php require_once '../componentes/nav.php'  ?>
    <?php require_once '../componentes/header.php' ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Cadastro aluno</h1>

                    <?php
                    $nome = "Eugênio Márcio";
                    $idade = 55;
                    $profissao = "Instrutor de Programação";
                    $salario = 51450;
                    $estado = "Ceará";
                    $email = "professoreugeniomls@gmail.com";
                    $celular = "85-99781.0324";
                    $datanascimento = "07-03-1971";
                    ?>


<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th style="width: 250px;">Campo</th>
            <th>Informação</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><i class="bi bi-person-fill"></i> Nome</td>
            <td><?= $nome??'Não definido';?></td>
        </tr>

        <tr>
            <td><i class="bi bi-calendar-check-fill"></i> Idade</td>
            <td><?= $idade??'Não definido' ?></td>
        </tr>

        <tr>
            <td><i class="bi bi-briefcase-fill"></i> Profissão</td>
            <td><?= $profissao??'Não definido' ?></td>
        </tr>

        <tr>
            <td><i class="bi bi-cash-coin"></i> Salário</td>
            <td>R$ <?= $salario??'Não definido' ?></td>
        </tr>

        <tr>
            <td><i class="bi bi-geo-alt-fill"></i> Estado</td>
            <td><?= $estado??'Não definido' ?></td>
        </tr>

        <tr>
            <td><i class="bi bi-envelope-fill"></i> E-mail</td>
            <td><?= $email??'Não definido' ?></td>
        </tr>

        <tr>
            <td><i class="bi bi-phone-fill"></i> Celular</td>
            <td><?= $celular??'Não definido' ?></td>
        </tr>

        <tr>
            <td><i class="bi bi-calendar-date-fill"></i> Data de nascimento</td>
            <td><?= $datanascimento??'Não definido' ?></td>
        </tr>
    </tbody>
</table>

<h1>Desafio 2 Cadastro simples de produto</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width:250px">Produto</th>
                <th>Categoria</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>dados</td>
                <td>dados</td>
               
            </tr>   
            <tr>
                <td>dados</td>
                <td>dados</td>
               
            </tr>  
            <tr>
                <td>dados</td>
                <td>dados</td>
               
            </tr> 
            <tr>
                <td>dados</td>
                <td>dados</td>
               
            </tr>  
        </tbody>
    </table>
</div>




                </div>
            </div>
        </div>
    </main>
    <!-- footer -->
    <?php require_once '../componentes/footer.php' ?>
    <!-- Bootstrap JavaScript Bundle (includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>