<?php require_once dirname(__DIR__) . '/componentes/config.php'; ?>
<?php
if (!empty($_GET['nomeUser'])) {
    $nomeuser = filter_input(INPUT_GET, 'nomeUser', FILTER_SANITIZE_SPECIAL_CHARS);
    $_SESSION['nomeUser'] = $nomeuser;
}
if (!empty($_GET['senhaUser'])) {
    $senhauser = filter_input(INPUT_GET, 'senhaUser', FILTER_SANITIZE_SPECIAL_CHARS);
    $_SESSION['senhaUser'] = encrypt_secure($senhauser, 'e');
}
?>

<?php


?>

<?php

if (!empty($_POST['email_login']) && !empty($_POST['senha_login'])) {

    $emailuser = "admin@admin.com";
    $senha = "ImAZoCfY7+d1B/WrMFlcrvUy6QZ0HV2VlV79T45pPogidtOlRX8e5+K0PCAOMlzZT3227MaTvIJbZ2lVvjQ4OQ==";
    $nome = "Professor Eugênio";

   echo $senhadec = encrypt_secure($senha, 'd')??'vazio';

     $emaillogin = filter_input(INPUT_POST, 'email_login', FILTER_SANITIZE_SPECIAL_CHARS);
     $senhalogin = $_POST['senha_login'];

    if($emaillogin == $emailuser && $senhalogin ==$senhadec)  {

        $_SESSION['userstatus'] = true;
        $_SESSION['nomeadmin'] = $nome;
        $_SESSION['tempodeacesso'] = time();
        $_SESSION['dataacesso'] = $data;

        header('Location:paineladmin.php');
        exit();

    } else {

        echo "e-mail: "
        .$emaillogin. 
        " e senha: "
        .$senhalogin. 
        " não conferem.";
        exit();


    }

}


?>


<?php
// código para retorno automático limpando o cache 
// o header está expulsando da página
// exit(); está limpando o cahe da página
// header("Location: index.php");
// exit();
?>