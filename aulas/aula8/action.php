<?php require_once dirname(__DIR__) . '/componentes/config.php'; ?>

<?php
if(!empty($_GET['nomeUser'])) {
$nomeuser = filter_input(INPUT_GET,'nomeUser',FILTER_SANITIZE_SPECIAL_CHARS);

$_SESSION['nomeuser'] = $nomeuser ;

}

if(!empty($_GET['senhaUser'])) {
$senhauser = filter_input(INPUT_GET,'senhaUser',FILTER_SANITIZE_SPECIAL_CHARS);
$_SESSION['senhauser'] = encrypt_secure($senhauser,'e');


}


 ?>

 
<?php
if(!empty($_POST['email_login'])&&!empty($_POST['senha_login']))  
    $user="franciscojoseduartesilva@gmail.com";
    $senha = "tLm2i835N6/AbGbUHoi00EH0XURVJ7U0vOBrVr0Dlf5QO4k+Sl9MjDxmx8OKaOgEZU+A/4JAxouDIu/7uk+mdA==";

   echo $emaillogin=filter_input(INPUT_POST,'email_login',FILTER_SANITIZE_SPECIAL_CHARS);
   echo $senhalogin=filter_input(INPUT_POST,'senha_login',FILTER_SANITIZE_SPECIAL_CHARS); 
                    
                   
?>
 
 
  

 <?php
 // codigo para retorno automatico limpando o cache
 // o header esta expulsando da pagina
 // exit(); esta limpando o cache da pagona
 // header("location: index.php");
 // exit();

 ?>
