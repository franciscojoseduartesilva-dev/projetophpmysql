<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>

<?php
// Conexão com o banco de dados
$con = config::connect();

$mensagem = '';
$tipoAlerta = '';

// Exemplo: ID do usuário logado na sessão (Ajuste a chave $_SESSION['usuario_id'] conforme seu sistema)
$usuario_id = $_SESSION['usuario_id'] ?? 1;

// Processamento do Formulário na mesma página
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha  = $_POST['nova_senha'] ?? '';

    if (!$nome || !$email) {
        $mensagem = 'Preencha o nome e um e-mail válido!';
        $tipoAlerta = 'danger';
    } else {
        try {
            // Busca dados atuais do usuário para validar senha, se necessário
            $stmtUser = $con->prepare("SELECT * FROM usuarios WHERE id = :id");
            $stmtUser->execute([':id' => $usuario_id]);
            $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                $mensagem = 'Usuário não encontrado!';
                $tipoAlerta = 'danger';
            } else {
                // Atualização com alteração de senha
                if (!empty($nova_senha)) {
                    // Se digitou nova senha, exige validação da senha atual
                    if (empty($senha_atual) || !password_verify($senha_atual, $usuario['senha'])) {
                        $mensagem = 'A senha atual informada está incorreta!';
                        $tipoAlerta = 'danger';
                    } else {
                        // Criptografa a nova senha
                        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

                        $stmtUpdate = $con->prepare("
                            UPDATE usuarios 
                            SET nome = :nome, email = :email, senha = :senha 
                            WHERE id = :id
                        ");
                        $stmtUpdate->execute([
                            ':nome'  => trim($nome),
                            ':email' => trim($email),
                            ':senha' => $nova_senha_hash,
                            ':id'    => $usuario_id
                        ]);

                        $mensagem = 'Perfil e senha atualizados com sucesso!';
                        $tipoAlerta = 'success';
                    }
                } else {
                    // Atualiza apenas dados cadastrais (Sem alterar senha)
                    $stmtUpdate = $con->prepare("
                        UPDATE usuarios 
                        SET nome = :nome, email = :email 
                        WHERE id = :id
                    ");
                    $stmtUpdate->execute([
                        ':nome'  => trim($nome),
                        ':email' => trim($email),
                        ':id'    => $usuario_id
                    ]);

                    $mensagem = 'Dados do perfil atualizados com sucesso!';
                    $tipoAlerta = 'success';
                }
            }
        } catch (Exception $e) {
            $mensagem = 'Erro ao atualizar o perfil: ' . $e->getMessage();
            $tipoAlerta = 'danger';
        }
    }
}

// Busca dados atualizados do usuário para preencher o formulário
$stmt = $con->prepare("SELECT nome, email FROM usuarios WHERE id = :id");
$stmt->execute([':id' => $usuario_id]);
$dadosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Sistema de Controle de Estoque</title>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/2875/2875878.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <?php require_once APP_COMPONENTES.'/sidebar.php';?>

    <section class="dashboard-wrapper" id="mainWrapper">
        
        <?php require_once APP_COMPONENTES.'/header.php';?>

        <main class="p-4 flex-grow-1">
            
            <!-- Cabeçalho -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1"><i class="bi bi-person-gear me-2 text-primary"></i>Editar Perfil</h2>
                    <p class="text-muted mb-2">Gerencie suas informações pessoais e credenciais de acesso.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="estoque.php" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar Perfil</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Exibição de Alertas -->
            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-<?= $tipoAlerta ?> alert-dismissible fade show border-0 shadow-sm col-12 col-lg-8 mx-auto mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i><?= htmlspecialchars($mensagem) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Formulário -->
            <div class="card border-0 shadow-sm col-12 col-lg-8 mx-auto">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Informações da Conta</h5>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST">
                        
                        <!-- Dados Pessoais -->
                        <div class="mb-3">
                            <label for="nome" class="form-label fw-semibold">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?= htmlspecialchars($dadosUsuario['nome'] ?? '') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($dadosUsuario['email'] ?? '') ?>" required>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3"><i class="bi bi-shield-lock me-2"></i>Alterar Senha <span class="text-muted fw-normal fs-7">(Opcional)</span></h6>

                        <div class="mb-3">
                            <label for="senha_atual" class="form-label fw-semibold">Senha Atual</label>
                            <input type="password" class="form-control" id="senha_atual" name="senha_atual" placeholder="Digite apenas se desejar trocar de senha">
                        </div>

                        <div class="mb-4">
                            <label for="nova_senha" class="form-label fw-semibold">Nova Senha</label>
                            <input type="password" class="form-control" id="nova_senha" name="nova_senha" placeholder="Digite a nova senha">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="estoque.php" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Salvar Alterações
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </main>

        <?php require_once APP_COMPONENTES.'/footer.php';?>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>