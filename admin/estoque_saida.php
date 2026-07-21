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
            // Verifica o estoque atual do produto
            $stmtEstoque = $con->prepare("SELECT estoque, nome FROM produtos WHERE id = :id");
            $stmtEstoque->execute([':id' => $produto_id]);
            $produto = $stmtEstoque->fetch(PDO::FETCH_ASSOC);

            if (!$produto) {
                $mensagem = 'Produto não encontrado!';
                $tipoAlerta = 'danger';
            } elseif ($produto['estoque'] < $quantidade) {
                $mensagem = "Estoque insuficiente! Estoque atual de '{$produto['nome']}': {$produto['estoque']} un.";
                $tipoAlerta = 'warning';
            } else {
                // Inicia a transação
                $con->beginTransaction();

                // 1. Registra a saída na tabela movimentacoes_estoque
                $stmtMov = $con->prepare("
                    INSERT INTO movimentacoes_estoque (produto_id, tipo, quantidade, observacao) 
                    VALUES (:produto_id, 'saida', :quantidade, :observacao)
                ");
                $stmtMov->execute([
                    ':produto_id' => $produto_id,
                    ':quantidade' => $quantidade,
                    ':observacao' => $observacao ? trim($observacao) : null
                ]);

                // 2. Atualiza a quantidade no estoque da tabela produtos
                $stmtUpdate = $con->prepare("
                    UPDATE produtos 
                    SET estoque = estoque - :quantidade 
                    WHERE id = :produto_id
                ");
                $stmtUpdate->execute([
                    ':quantidade' => $quantidade,
                    ':produto_id' => $produto_id
                ]);

                // Confirma as alterações
                $con->commit();

                $mensagem = 'Saída de estoque registrada e saldo atualizado com sucesso!';
                $tipoAlerta = 'success';
            }
        } catch (Exception $e) {
            // Desfaz as alterações em caso de erro
            if ($con->inTransaction()) {
                $con->rollBack();
            }
            $mensagem = 'Erro ao processar a saída: ' . $e->getMessage();
            $tipoAlerta = 'danger';
        }
    }
}

// Busca a lista atualizada de produtos para o select (com estoque atual)
$stmtProdutos = $con->query("SELECT id, nome, estoque FROM produtos WHERE status = 'ativo' ORDER BY nome ASC");
$produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Saída - Sistema de Controle de Estoque</title>
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
                    <h2 class="fw-bold mb-1 text-danger"><i class="bi bi-box-arrow-left me-2"></i>Estoque Saída</h2>
                    <p class="text-muted mb-2">Registre a saída de produtos e atualize o saldo automaticamente.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="estoque.php" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Registrar Saída</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i>--/--/----</span>
                    <a href="produtos_cadastro.php" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Novo Produto
                    </a>
                    <a href="estoque_entrada.php" class="btn btn-success shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Registrar Entrada
                    </a>
                </div>
            </div>

            <!-- Exibição de Alertas -->
            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-<?= $tipoAlerta ?> alert-dismissible fade show border-0 shadow-sm col-12 col-lg-8 mx-auto mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i><?= htmlspecialchars($mensagem) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Formulário de Saída -->
            <div class="card border-0 shadow-sm col-12 col-lg-8 mx-auto">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">Dados da Saída</h5>
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
                            <label for="quantidade" class="form-label fw-semibold">Quantidade a Retirar <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control" id="quantidade" name="quantidade" placeholder="Ex: 5" required>
                        </div>

                        <div class="mb-4">
                            <label for="observacao" class="form-label fw-semibold">Observação / Motivo</label>
                            <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Ex: Venda Pedido #102, Produto Avariado, uso interno..."></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="estoque.php" class="btn btn-light border">Cancelar</a>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-check-lg me-1"></i> Confirmar Saída
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </main>

        <?php require_once APP_COMPONENTES.'/footer.php';?>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>