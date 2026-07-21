<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>

<?php
// Conexão com o banco de dados
$con = config::connect();

$mensagem = '';
$tipoAlerta = '';

// Processamento do Formulário na mesma página
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome      = filter_input(INPUT_POST, 'nome', FILTER_DEFAULT);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_DEFAULT);
    $status    = filter_input(INPUT_POST, 'status', FILTER_DEFAULT) ?? 'ativo';

    if (!$nome) {
        $mensagem = 'O nome da categoria é obrigatório!';
        $tipoAlerta = 'danger';
    } else {
        try {
            // Verifica se a categoria já existe (Tratamento da chave UNIQUE)
            $stmtCheck = $con->prepare("SELECT id FROM categorias WHERE nome = :nome");
            $stmtCheck->execute([':nome' => trim($nome)]);

            if ($stmtCheck->fetch()) {
                $mensagem = "A categoria '" . htmlspecialchars($nome) . "' já está cadastrada!";
                $tipoAlerta = 'warning';
            } else {
                // Insere a nova categoria
                $stmtInsert = $con->prepare("
                    INSERT INTO categorias (nome, descricao, status) 
                    VALUES (:nome, :descricao, :status)
                ");

                $stmtInsert->execute([
                    ':nome'      => trim($nome),
                    ':descricao' => $descricao ? trim($descricao) : null,
                    ':status'    => $status
                ]);

                $mensagem = 'Categoria cadastrada com sucesso!';
                $tipoAlerta = 'success';
            }
        } catch (PDOException $e) {
            $mensagem = 'Erro ao salvar categoria: ' . $e->getMessage();
            $tipoAlerta = 'danger';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Categoria - Sistema de Controle de Estoque</title>
    <meta name="description" content="Cadastre novas categorias de produtos no sistema.">
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
                    <h2 class="fw-bold mb-1"><i class="bi bi-folder-plus me-2 text-primary"></i>Nova Categoria</h2>
                    <p class="text-muted mb-2">Cadastre uma nova categoria para organizar seus produtos.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="estoque.php" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nova Categoria</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i>--/--/----</span>
                    <a href="produtos_cadastro.php" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Novo Produto
                    </a>
                </div>
            </div>

            <!-- Exibição de Alertas -->
            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-<?= $tipoAlerta ?> alert-dismissible fade show border-0 shadow-sm col-12 col-lg-8 mx-auto mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i><?= $mensagem ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm col-12 col-lg-8 mx-auto">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Dados da Categoria</h5>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST">
                        
                        <div class="mb-3">
                            <label for="nome" class="form-label fw-semibold">Nome da Categoria <span class="text-danger">*</span></label>
                            <input type="text" maxlength="80" class="form-control" id="nome" name="nome" placeholder="Ex: Eletrônicos, Bebidas, Limpeza..." required>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label fw-semibold">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" maxlength="255" placeholder="Breve resumo sobre os itens desta categoria..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="ativo" selected>Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="estoque.php" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-1"></i> Salvar Categoria
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