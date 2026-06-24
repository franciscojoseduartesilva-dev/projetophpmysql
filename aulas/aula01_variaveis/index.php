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