<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>

<?php
// Conexão com o banco de dados
$con = config::connect();

$mensagem = '';
$tipoAlerta = '';

// Processamento do formulário na mesma página
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT);
    $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
    $observacao = filter_input(INPUT_POST, 'observacao', FILTER_DEFAULT);

    if (!$produto_id || !$quantidade || $quantidade <= 0) {
        $mensagem = 'Preencha todos os campos obrigatórios corretamente!';
        $tipoAlerta = 'danger';
    } else {
        try {
            // Verifica se o produto existe
            $stmtProduto = $con->prepare("SELECT id, nome FROM produtos WHERE id = :id");
            $stmtProduto->execute([':id' => $produto_id]);
            $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

            if (!$produto) {
                $mensagem = 'Produto não encontrado!';
                $tipoAlerta = 'danger';
            } else {
                // Inicia a transação
                $con->beginTransaction();

                // 1. Registra a entrada na tabela movimentacoes_estoque
                $stmtMov = $con->prepare("
                    INSERT INTO movimentacoes_estoque (produto_id, tipo, quantidade, observacao) 
                    VALUES (:produto_id, 'entrada', :quantidade, :observacao)
                ");
                $stmtMov->execute([
                    ':produto_id' => $produto_id,
                    ':quantidade' => $quantidade,
                    ':observacao' => $observacao ? trim($observacao) : null
                ]);

                // 2. Atualiza (soma) a quantidade no estoque da tabela produtos
                $stmtUpdate = $con->prepare("
                    UPDATE produtos 
                    SET estoque = estoque + :quantidade 
                    WHERE id = :produto_id
                ");
                $stmtUpdate->execute([
                    ':quantidade' => $quantidade,
                    ':produto_id' => $produto_id
                ]);

                // Confirma as alterações no banco de dados
                $con->commit();

                $mensagem = "Entrada de {$quantidade} unidade(s) registrada com sucesso para o produto '{$produto['nome']}'!";
                $tipoAlerta = 'success';
            }
        } catch (Exception $e) {
            // Desfaz as alterações em caso de erro
            if ($con->inTransaction()) {
                $con->rollBack();
            }
            $mensagem = 'Erro ao registrar a entrada: ' . $e->getMessage();
            $tipoAlerta = 'danger';
        }
    }
}

// Busca a lista atualizada de produtos para o select
$stmtProdutos = $con->query("SELECT id, nome, estoque FROM produtos WHERE status = 'ativo' ORDER BY nome ASC");
$produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Entrada - Sistema de Controle de Estoque</title>
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
                    <h2 class="fw-bold mb-1 text-success"><i class="bi bi-box-arrow-in-right me-2"></i>Estoque Entrada</h2>
                    <p class="text-muted mb-2">Adicione novos itens ao estoque e atualize o saldo do produto.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="estoque.php" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Registrar Entrada</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i>--/--/----</span>
                    <a href="produtos_cadastro.php" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Novo Produto
                    </a>
                    <a href="estoque_saida.php" class="btn btn-danger shadow-sm">
                        <i class="bi bi-box-arrow-left me-1"></i> Registrar Saída
                    </a>
                </div>
            </div>

            <!-- Mensagens de Alerta (Sucesso ou Erro) -->
            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-<?= $tipoAlerta ?> alert-dismissible fade show border-0 shadow-sm col-12 col-lg-8 mx-auto mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i><?= htmlspecialchars($mensagem) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Formulário de Entrada -->
            <div class="card border-0 shadow-sm col-12 col-lg-8 mx-auto">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Dados da Entrada</h5>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST">
                        
                        <div class="mb-3">
                            <label for="produto_id" class="form-label fw-semibold">Selecione o Produto <span class="text-danger">*</span></label>
                            <select class="form-select" id="produto_id" name="produto_id" required>
                                <option value="" selected disabled>Escolha um produto...</option>
                                <?php foreach ($produtos as $p): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= htmlspecialchars($p['nome']) ?> (Estoque Atual: <?= $p['estoque'] ?> un.)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantidade" class="form-label fw-semibold">Quantidade a Adicionar <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control" id="quantidade" name="quantidade" placeholder="Ex: 10" required>
                        </div>

                        <div class="mb-4">
                            <label for="observacao" class="form-label fw-semibold">Observação / Nota Fiscal</label>
                            <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Ex: NF 12345, Compra do Fornecedor ABC..."></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="estoque.php" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg me-1"></i> Confirmar Entrada
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