<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>
<?php
$con = config::connect(); 
// Instancia a conexão (ajuste para a sua variável real definida em conexao.php, ex: $pdo ou $conn)
$conexao = isset($pdo) ? $pdo : $con;

$mensagem = "";

// Lógica para Inserir Usuário (Ação do Formulário)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    try {
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        $nivel = $_POST['nivel'] ?? 'operador';

        if (!empty($nome) && !empty($email) && !empty($senha)) {
            // Criptografa a senha com segurança antes de salvar no banco
            $senhaCripto = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, nivel) VALUES (:nome, :email, :senha, :nivel)");
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senhaCripto,
                ':nivel' => $nivel
            ]);
            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <i class='bi bi-check-circle-fill me-2'></i> Usuário cadastrado com sucesso!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        }
    } catch (PDOException $e) {
        // Verifica se o erro é de duplicidade de chave (e-mail já existente)
        if ($e->getCode() == 23000) {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <i class='bi bi-exclamation-triangle-fill me-2'></i> Erro: Este endereço de e-mail já está em uso por outro usuário.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <i class='bi bi-x-circle-fill me-2'></i> Erro ao cadastrar: " . $e->getMessage() . "
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        }
    }
}

// Lógica para buscar os usuários cadastrados
try {
    $stmtLista = $conexao->query("SELECT id, nome, email, nivel, criado_em FROM usuarios ORDER BY id DESC");
    $usuarios = $stmtLista->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $usuarios = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Controle de Estoque</title>
    <meta name="description" content="Dashboard administrativo moderno para controle e gestão de estoque.">
    <meta name="keywords" content="estoque, gestão, dashboard, admin, produtos">
    <meta name="author" content="Seu Nome">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/2875/2875878.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

     <?php require_once APP_COMPONENTES.'/sibebar.php';?>

    <section class="dashboard-wrapper" id="mainWrapper">
        
        <?php require_once APP_COMPONENTES.'/header.php';?>

        <main class="p-4 flex-grow-1">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Usuários</h2>
                    <p class="text-muted mb-2">Controle o acesso e níveis de permissão da equipe.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Usuários</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y'); ?></span>
                    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovoUsuario">
                        <i class="bi bi-person-plus me-1"></i> Novo Usuário
                    </button>
                </div>
            </div>

            <!-- Alertas de Feedback -->
            <?= $mensagem; ?>

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <!-- Tabela de Usuários -->
                    <div class="card rounded-4 shadow-sm border-0">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="fw-bold mb-0">Equipe Cadastrada</h5>
                            <input type="text" id="inputBusca" class="form-control form-control-sm rounded-3" placeholder="Buscar usuário..." style="max-width: 250px;">
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tabelaUsuarios">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">ID</th>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Nível de Acesso</th>
                                            <th>Criado Em</th>
                                            <th class="pe-4 text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($usuarios)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">Nenhum integrante cadastrado.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($usuarios as $user): ?>
                                                <tr>
                                                    <td class="ps-4 text-muted">#<?= $user['id']; ?></td>
                                                    <td><strong class="text-dark"><?= htmlspecialchars($user['nome']); ?></strong></td>
                                                    <td><?= htmlspecialchars($user['email']); ?></td>
                                                    <td>
                                                        <?php if ($user['nivel'] === 'admin' || $user['nivel'] === 'administrador'): ?>
                                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5">Administrador</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2.5"><?= htmlspecialchars($user['nivel']); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="small text-muted"><?= date('d/m/Y H:i', strtotime($user['criado_em'])); ?></td>
                                                    <td class="pe-4 text-end text-nowrap">
                                                        <button class="btn btn-sm btn-outline-secondary me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                                        <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>

        </main>

         <?php require_once APP_COMPONENTES.'/footer.php';?>
    </section>

    <!-- Modal para Cadastro de Novo Usuário -->
    <div class="modal fade" id="modalNovoUsuario" tabindex="-1" aria-labelledby="modalNovoUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalNovoUsuarioLabel">Cadastrar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    <input type="hidden" name="acao" value="cadastrar">
                    <div class="modal-body py-3">
                        <div class="mb-3">
                            <label for="nome" class="form-label small fw-semibold text-muted mb-1">Nome Completo *</label>
                            <input type="text" class="form-control rounded-3" id="nome" name="nome" required placeholder="Ex: Lucas Mendes">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-muted mb-1">E-mail Corporativo *</label>
                            <input type="email" class="form-control rounded-3" id="email" name="email" required placeholder="Ex: lucas@empresa.com">
                        </div>
                        <div class="row g-3 mb-1">
                            <div class="col-6">
                                <label for="senha" class="form-label small fw-semibold text-muted mb-1">Senha de Acesso *</label>
                                <input type="password" class="form-control rounded-3" id="senha" name="senha" required placeholder="Digite a senha">
                            </div>
                            <div class="col-6">
                                <label for="nivel" class="form-label small fw-semibold text-muted mb-1">Nível de Permissão</label>
                                <select class="form-select rounded-3" id="nivel" name="nivel">
                                    <option value="operador" selected>Operador</option>
                                    <option value="gerente">Gerente</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">Salvar Usuário</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/script.js"></script>

    <script>
        // Busca local inteligente por texto digitado
        document.getElementById('inputBusca').addEventListener('keyup', function() {
            let busca = this.value.toLowerCase();
            let linhas = document.querySelectorAll('#tabelaUsuarios tbody tr');
            
            linhas.forEach(linha => {
                let texto = linha.textContent.toLowerCase();
                if(texto.indexOf(busca) > -1 || linha.cells.length === 1) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>