<?php require_once dirname(__DIR__) . '/componentes/config.php'; ?>

<?php
if (!empty($_GET['nomeUser'])) {
    $nomeuser = filter_input(INPUT_GET, 'nomeUser', FILTER_SANITIZE_SPECIAL_CHARS);

    $_SESSION['nomeuser'] = $nomeuser;
}

if (!empty($_GET['senhaUser'])) {
    $senhauser = filter_input(INPUT_GET, 'senhaUser', FILTER_SANITIZE_SPECIAL_CHARS);
    $_SESSION['senhauser'] = encrypt_secure($senhauser, 'e');
}


?>

 
<?php
if (!empty($_POST['email_login']) && !empty($_POST['senha_login'])) {

    $emailuser = "franciscojoseduartesilva@gmail.com";
    $senha = "tLm2i835N6/AbGbUHoi00EH0XURVJ7U0vOBrVr0Dlf5QO4k+Sl9MjDxmx8OKaOgEZU+A/4JAxouDIu/7uk+mdA==";
    $nome = "josesilva";

    $decsenha = encrypt_secure($senha, 'd');

    echo $emaillogin = filter_input(INPUT_POST, 'email_login', FILTER_SANITIZE_SPECIAL_CHARS);
    echo $senhalogin = $_POST['senha_login'];

    if ($emaillogin == $emailuser && $senhalogin == $decsenha) {

        $_SESSION['userstatus'] = true;
        $_SESSION['nomeadmin'] = $nome;
        $_SESSION['tempodeacesso'] = time();
        $_SESSION['dataacesso'] = $data;

        header('Location:paineladmin.php');
        exit();
    } else {

        echo "e-mail:"
            . $emaillogin .
            " e senha:"
            . $senhalogin .
            " nao conferem.";
    }
};
?>
 
 
  

 <?php
    // codigo para retorno automatico limpando o cache
    // o header esta expulsando da pagina
    // exit(); esta limpando o cache da pagona
    // header("location: index.php");
    // exit();

    ?>
