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
    <?php $numaula = "AULA 1" ?>
    <?php require_once '../componentes/nav.php' ?>

    <?php require_once '../componentes/header.php' ?>

    <main>

        <div class="container">
            <div class="row">

                <div class="col-12"></div>
                <h1>Cadastro aluno</h1>

                <?php

                $nome = "jose silva";

                $idade = "41";

                $proficao = "Estudante";

                $salario = "1618";

                $Estado = "Ceara";

                $email = "franciscojoseduartesilva@gmail.com";

                $celular = "85 92773936";

                $dataNacimento = "21/04/1985";


                ?>
                <table>
                    <tr>
                        <td class="label" width="250">👤 Nome</td>
                        <td class="value"><?= $nome ?></td>
                    </tr>
                    <tr>
                        <td class="label">🎂 Idade</td>
                        <td class="value"><?= $idade ?></td>
                    </tr>
                    <tr>
                        <td class="label">💼 Profissão</td>
                        <td class="value"><?= $proficao ?></td>
                    </tr>
                    <tr>
                        <td class="label">💰 Salário</td>
                        <td class="value"><?= $salario ?></td>
                    </tr>
                    <tr>
                        <td class="label">📍 Estado</td>
                        <td class="value"><?= $Estado ?></td>
                    </tr>
                    <tr>
                        <td class="label">📧 E-mail</td>
                        <td class="value"><?= $email ?></td>
                    </tr>
                    <tr>
                        <td class="label">📱 Celular</td>
                        <td class="value"><?= $celular ?></td>
                    </tr>
                    <tr>
                        <td class="label">🗓️ Data de Nascimento</td>
                        <td class="value"><?= $dataNacimento ?></td>
                    </tr>
                </table>

                <h1>Desafio2</h1>

                <?php
                    $produto = "Notebook Dell Inspiron 15";

                    $categoria = "Informática";

                    $preco = "3499.90";

                    $estoque ="300";

                    
                ?>
                <h2>Cadastro de produto</h2>
                <table>
                    <tr>
                        <td class="label" width="250">👤 produto</td>
                        <td class="value"><?= $produto??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">🎂 categoria</td>
                        <td class="value"><?= $categoria??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">💼 preco</td>
                        <td class="value"><?= $preco??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">💰 estoque</td>
                        <td class="value"><?= $estoque??'nao definido' ?></td>
                    </tr>
                    
                </table>


                <h1>Desafio3</h1>

                <?php
                    $produto = "Fone de Ouvido Bluetoot";

                    $precoUnitario = "199.99";

                    $quantidade = "100";

                ?>
                <h2>produto</h2>
                <table>
                    <tr>
                        <td class="label" width="250">👤 produto</td>
                        <td class="value"><?= $produto ??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">🎂 precoUnitario</td>
                        <td class="value"><?= $precoUnitario??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">💼 quantidade</td>
                        <td class="value"><?= $quantidade??'nao definido' ?></td>
                    </tr>
                    
                    
                </table>

                <h1>Desafio4</h1>

                <?php
                    $vendedor = "joao silva";

                    $totalVendido = "16000.00";

                    $percentualComissao = "10";

                ?>
                <h2>Comissao de vendedor</h2>
                <table>
                    <tr>
                        <td class="label" width="250">👤 vendedor</td>
                        <td class="value"><?= $vendedor??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">🎂 Total vendas</td>
                        <td class="value"><?= $totalVendido??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">💼 $percentualComissao</td>
                        <td class="value"><?= $quantidade??'nao definido' ?></td>
                    </tr>
                    
                    
                </table>

                <h1>Desafio5</h1>

                <?php
                    $aluno = "carlos";

                    $nota1 = "8.7";

                    $nota2 = "9.6";

                    $nota3 = "7.8";

                ?>
                <h2>media de notas</h2>
                <table>
                    <tr>
                        <td class="label" width="250">👤 aluno</td>
                        <td class="value"><?= $aluno??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">🎂 nota1</td>
                        <td class="value"><?= $nota1??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">💼 $nota2</td>
                        <td class="value"><?= $nota2??'nao definido' ?></td>
                    </tr>
                    <tr>
                        <td class="label">💼 $nota3</td>
                        <td class="value"><?= $nota3??'nao definido' ?></td>
                    </tr>
                    
                </table>

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