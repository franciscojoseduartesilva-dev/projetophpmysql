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
    <?php $numaula = "Aula 7" ?>
    <?php require_once  APP_COMPONENTES . '/nav.php'; ?>

    <?php require_once APP_COMPONENTES . '/header.php' ?>

    <main>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Título estudo</h3>
                    <h1>padrões confg </h1>
                    <h3>1.Data BR</h3>
                    Data: <?php echo $data; ?> <br>
                    Hora: <?php echo $hora; ?> <br>
                    Data br <?php echo databr();?> <br>
                    Hora br <?php echo Horabr();?> <br>

                    <h3>2.Encryptar dados</h3>
                    <?php $codigo ="123456"; ?><br>
                    codigo: <?php echo $codigo;?><br>
                    <?php $enc = encrypt_secure($codigo, 'e'); ?>
                    codigo encryptado: <?php echo $enc; ?> <br>
                    codigo decryptado <?php echo encrypt_secure($enc,'d');?> <br>

                    <h3>Encrypt no link</h3>
                    <a href="?enc=<?php echo urlencode($enc);?>">chave encrypttada</a><br> 

                    codigo decryptado do link:
                    <?php
                    if(!empty($_GET['enc'])){
                    echo encrypt_secure($_GET['enc'], 'd');

                    } 
                     ?>

                     
                     <h3>2.Encryptar dados</h3>
                    <?php $codigo ="123456"; ?><br>
                    codigo: <?php echo $codigo;?><br>
                    <?php $enc = encrypt_secure($codigo, 'e'); ?>
                    codigo encryptado: <?php echo $enc; ?> <br>
                    codigo decryptado <?php echo encrypt_secure($enc,'d');?> <br>

                    <h3>Encrypt no link</h3>
                    <a href="?enc=<?php echo urlencode($enc);?>">chave encrypttada</a><br>
                    
                    codigo decryptado do link:
                    <?php
                    if(!empty($_GET['enc'])){
                        echo encrypt_secure($_GET['enc'], 'd');
                    } 
                     ?>

                     <h3>2.Encryptar dados</h3>
                     <?php $codigo ="123456"; ?><br>
                    codigo: <?php echo $codigo;?><br>
                    <?php $enc = encrypt_secure($codigo, 'e'); ?>
                    codigo encryptado: <?php echo $enc; ?> <br>
                    codigo decryptado <?php echo encrypt_secure($enc,'d');?> <br>

                    <h3>Encrypt no link</h3>
                    <a href="?enc=<?php echo urlencode($enc);?>">chave encryptada</a><br>
                    
                    codigo decryptado do link:
                    <?php
                    if(!empty($_GET['enc'])){
                        echo encrypt_secure($_GET['enc'], 'd');
                    } 
                     ?>
                     

                    <h3>3. Grupo com input text e botão</h3>
                    
                     <form method="post" class="card card-body shadow-sm mb-4">
                        <h4>Input text + botão</h4>

                        <label for="produto_busca" class="form-label">Nome do produto</label>

                        <div class="input-group">
                        <input type="text" class="form-control" id="busca" name="busca" placeholder="Digite o nome do produto">
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                        </div>
                    </form>
                    <?php
                    if(!empty($_POST['busca'])){
                        $encpost = encrypt_secure($_POST['busca'], 'e');
                        $decpost = encrypt_secure($encpost, 'd');
                    } 
                     ?>
                    post encryptado : <?php echo $encpost;$variavel??'nao definida' ?>  <br>
                    post decryptado : <?php echo $decpost;$variavel??'nao definida'  ?>  <br>
                    

                    <h3>5.login e senha</h3>

                    <form method="post" class="card card-body shadow-sm mb-4">
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
                    <?php
                    if(!empty($_POST['email_login'])){
                        $encpost = encrypt_secure($_POST['email_login'], 'e');
                        $decpost = encrypt_secure($encpost, 'd');
                    } 
                     ?>
                    post encryptado : <?php echo $encpost; ?>  <br>
                    post decryptado : <?php echo $decpost;?>  <br>
                    

                    
                    
                     

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