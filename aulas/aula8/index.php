<?php require_once dirname(__DIR__) . '/componentes/config.php'; ?>
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
    <?php $numaula = "Aula 8" ?>
    <?php require_once  APP_COMPONENTES . '/nav.php'; ?>

    <?php require_once APP_COMPONENTES . '/header.php' ?>

    <main>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Uso de $_SESSION</h3>
                    <a class="btn btn-success btn-sm" href="action.php?nomeUser=jose silva">
                        Nme Usuario : jose silva
                    </a>
                    <a class="btn btn-success btn-sm" href="action.php?senhaUser=123456">
                        senha de usuario :123456

                    </a>

                    <p>

                     <?php
                     if(!empty($_SESSION['nomeuser'])) {
                        echo $_SESSION['nomeuser'];

                     } ?>
<br>
                     <?php

                     if(!empty($_SESSION['senhauser'])) {
                        echo $_SESSION['senhauser'];

                     }
                        


                     ?>
                    </p>

                    <h3>login e senha com botão</h3>
                    <a href="paineladmin.php">painel Admin</a>
                    <form method="post" action="action.php" class="card card-body shadow-sm mb-4">
                        <h4>Login e senha</h4>

                        <div class="mb-3">
                            <label for="email_login" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email_login" name="email_login" placeholder="Digite seu e-mail">
                        </div>

                        <div class="mb-3">
                            <label for="senha_login" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha_login" name="senha_login" placeholder="Digite sua senha">
                        </div>

                        <button type="submit" class="btn btn-success">Entrar</button>
                    </form>
                        
                    



                    
                     

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