<?php
require_once 'config.php';
require_once 'conexao.php';

header('Content-Type: application/json; charset=utf-8');

if (
    empty($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest'
) {
    http_response_code(403);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Acesso não permitido.'
    ]);
    exit;
}

$login = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = $_POST['senha'] ?? '';

$login = trim((string) $login);
$senha = trim((string) $senha);

if ($login === '' || $senha === '') {
    http_response_code(400);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Preencha login e senha.'
    ]);
    exit;
} else if ($senha === '') {
    http_response_code(400);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Preencha a senha.'
    ]);
    exit;
} else if ($login === '') {
http_response_code(400);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Preencha o e-mail correto.'
    ]);
    exit;
}

$con = config::connect(); 
$dados = [];

$sql = "SELECT email, senha, id, nivel, nome
        FROM usuarios WHERE email ='$login' ";
        

$stmt = $con->query($sql);

$dados = $stmt->fetch(PDO::FETCH_ASSOC);

$loginCorreto = $dados['email']??'0';
$senhaCorreta = $dados['senha']??'0';

$dec = encrypt_secure($senhaCorreta,'d');


if ($login !== $loginCorreto || $senha !==$dec) {
    http_response_code(401);

    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Login ou senha inválidos.'.$login.$senha
    ]);
    exit;
}

session_regenerate_id(true);

$_SESSION['adminstatus'] = true;
$_SESSION['admin_nome'] = $dados['nome'];
$_SESSION['admin_nivel'] = $dados['nivel'];
$_SESSION['admin_email'] = $login;
$_SESSION['id_admin'] = encrypt_secure($dados['id'],'e');


echo json_encode([
    'sucesso' => true,
    'mensagem' => 'Login realizado com sucesso.',
    'redirecionar' => 'admin/index.php'
]);
exit;

?>