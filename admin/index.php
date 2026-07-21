<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>

<?php
$con = config::connect(); 
$conexao = isset($pdo) ? $pdo : $con;

try {
    // 1. Total de Produtos Cadastrados
    $totalProdutos = $conexao->query("SELECT COUNT(*) FROM produtos")->fetchColumn();

    // 2. Soma de Itens Totais em Estoque
    $itensEstoque = $conexao->query("SELECT SUM(estoque) FROM produtos WHERE status = 'ativo'")->fetchColumn() ?? 0;

    // 3. Estoque Baixo (Produtos ativos com até 10 unidades)
    $estoqueBaixo = $conexao->query("SELECT COUNT(*) FROM produtos WHERE estoque <= 10 AND estoque > 0 AND status = 'ativo'")->fetchColumn();

    // 4. Sem Estoque (Produtos zerados)
    $semEstoque = $conexao->query("SELECT COUNT(*) FROM produtos WHERE estoque <= 0 AND status = 'ativo'")->fetchColumn();

    // 5. Entradas (Mês Atual)
    $entradasMes = $conexao->query("
        SELECT SUM(quantidade) FROM movimentacoes_estoque 
        WHERE tipo = 'entrada' 
        AND MONTH(criado_em) = MONTH(CURRENT_DATE()) 
        AND YEAR(criado_em) = YEAR(CURRENT_DATE())
    ")->fetchColumn() ?? 0;

    // 6. Saídas (Mês Atual)
    $saidasMes = $conexao->query("
        SELECT SUM(quantidade) FROM movimentacoes_estoque 
        WHERE tipo = 'saida' 
        AND MONTH(criado_em) = MONTH(CURRENT_DATE()) 
        AND YEAR(criado_em) = YEAR(CURRENT_DATE())
    ")->fetchColumn() ?? 0;

    // 7. Valor Total do Estoque (Preço * Estoque)
    $valorTotalEstoque = $conexao->query("SELECT SUM(preco * estoque) FROM produtos WHERE status = 'ativo'")->fetchColumn() ?? 0;

    // 8. Total de Clientes Cadastrados
    $totalClientes = $conexao->query("SELECT COUNT(*) FROM clientes")->fetchColumn();

    // 9. Total de Fornecedores Ativos
    $totalFornecedores = $conexao->query("SELECT COUNT(*) FROM fornecedores WHERE status = 'ativo'")->fetchColumn();

    // 10. Consulta de Produtos em Alerta de Estoque (Baixo ou Zerado)
    $stmtProdutosAlerta = $conexao->query("
        SELECT id, nome, categoria, preco, estoque 
        FROM produtos 
        WHERE estoque <= 10 AND status = 'ativo' 
        ORDER BY estoque ASC 
        LIMIT 5
    ");
    $produtosAlerta = $stmtProdutosAlerta->fetchAll(PDO::FETCH_ASSOC);

    // 11. Consulta das Últimas Movimentações de Estoque
    $stmtUltimasMov = $conexao->query("
        SELECT m.id, m.tipo, m.quantidade, m.criado_em, p.nome AS produto_nome 
        FROM movimentacoes_estoque m
        INNER JOIN produtos p ON m.produto_id = p.id
        ORDER BY m.criado_em DESC 
        LIMIT 5
    ");
    $ultimasMovimentacoes = $stmtUltimasMov->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $totalProdutos = $itensEstoque = $estoqueBaixo = $semEstoque = 0;
    $entradasMes = $saidasMes = $valorTotalEstoque = $totalClientes = $totalFornecedores = 0;
    $produtosAlerta = [];
    $ultimasMovimentacoes = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Controle de Estoque</title>
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
            
            <!-- Cabeçalho do Dashboard -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Dashboard General</h2>
                    <p class="text-muted mb-2">Visão geral do estoque, produtos, fornecedores e movimentações.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y'); ?></span>
                    <a href="produtos_cadastro.php" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Novo Produto
                    </a>
                    <a href="estoque_entrada.php" class="btn btn-success shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Registrar Entrada
                    </a>
                    <a href="estoque_saida.php" class="btn btn-danger shadow-sm">
                        <i class="bi bi-box-arrow-left me-1"></i> Registrar Saída
                    </a>
                </div>
            </div>

            <!-- Cards Indicadores Gerais -->
            <div class="row g-4 mb-4">
                <!-- Total de Produtos -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Total de Produtos</p>
                                <h3 class="fw-bold mb-0"><?= number_format($totalProdutos, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3">
                                <i class="bi bi-box-seam fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Itens em Estoque -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Total em Unidades</p>
                                <h3 class="fw-bold mb-0"><?= number_format($itensEstoque, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="p-3 bg-success bg-opacity-10 text-success rounded-3">
                                <i class="bi bi-layers fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valor Financeiro do Estoque -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Valor do Estoque</p>
                                <h3 class="fw-bold mb-0">R$ <?= number_format($valorTotalEstoque, 2, ',', '.'); ?></h3>
                            </div>
                            <div class="p-3 bg-success bg-opacity-25 text-success rounded-3">
                                <i class="bi bi-currency-dollar fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estoque Baixo / Esgotado -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-4 border-start border-4 border-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Estoque Crítico / Zerado</p>
                                <h3 class="fw-bold mb-0 text-warning"><?= $estoqueBaixo + $semEstoque; ?></h3>
                            </div>
                            <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-3">
                                <i class="bi bi-exclamation-triangle fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Entradas do Mês -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Entradas (Mês)</p>
                                <h3 class="fw-bold text-success mb-0">+<?= number_format($entradasMes, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="p-3 bg-success bg-opacity-10 text-success rounded-3">
                                <i class="bi bi-box-arrow-in-right fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Saídas do Mês -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Saídas (Mês)</p>
                                <h3 class="fw-bold text-danger mb-0">-<?= number_format($saidasMes, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3">
                                <i class="bi bi-box-arrow-left fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Clientes -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Clientes Cadastrados</p>
                                <h3 class="fw-bold mb-0"><?= number_format($totalClientes, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="p-3 bg-info bg-opacity-10 text-info rounded-3">
                                <i class="bi bi-people fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fornecedores -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 small">Fornecedores Ativos</p>
                                <h3 class="fw-bold mb-0"><?= number_format($totalFornecedores, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="p-3 bg-dark bg-opacity-10 text-dark rounded-3">
                                <i class="bi bi-truck fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabelas Informativas -->
            <div class="row g-4">
                <!-- Alerta de Produtos com Estoque Baixo -->
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-exclamation-circle me-2"></i>Atenção: Estoque Baixo</h5>
                            <a href="produtos.php" class="btn btn-sm btn-link text-decoration-none">Ver todos</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produto</th>
                                            <th>Categoria</th>
                                            <th>Estoque</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($produtosAlerta)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">Nenhum produto com estoque crítico no momento!</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($produtosAlerta as $item): ?>
                                                <tr>
                                                    <td class="fw-semibold"><?= htmlspecialchars($item['nome']) ?></td>
                                                    <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($item['categoria']) ?></span></td>
                                                    <td>
                                                        <?php if ($item['estoque'] <= 0): ?>
                                                            <span class="badge bg-danger">Esgotado (0)</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark"><?= $item['estoque'] ?> un.</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="estoque_entrada.php?produto_id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-success" title="Repor Estoque">
                                                            <i class="bi bi-plus-circle"></i> Repor
                                                        </a>
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

                <!-- Últimas Movimentações -->
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-transparent border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2"></i>Últimas Movimentações</h5>
                            <a href="estoque.php" class="btn btn-sm btn-link text-decoration-none">Ver histórico</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produto</th>
                                            <th>Tipo</th>
                                            <th>Qtd</th>
                                            <th>Data/Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($ultimasMovimentacoes)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">Nenhuma movimentação recente.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($ultimasMovimentacoes as $mov): ?>
                                                <tr>
                                                    <td class="fw-semibold"><?= htmlspecialchars($mov['produto_nome']) ?></td>
                                                    <td>
                                                        <?php if (strtolower($mov['tipo']) === 'entrada'): ?>
                                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Entrada</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Saída</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="fw-bold"><?= $mov['quantidade'] ?></td>
                                                    <td class="text-muted small"><?= date('d/m/Y H:i', strtotime($mov['criado_em'])) ?></td>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>