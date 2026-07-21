<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>

<?php
// Conexão com o banco
$con = config::connect(); 

// Busca todos os produtos ordenados pelo nome
$stmtProdutos = $con->query("
    SELECT id, nome, categoria, preco, estoque, status, criado_em 
    FROM produtos 
    ORDER BY nome ASC
");
$produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

// Métricas rápidas
$totalProdutos = count($produtos);
$totalEmEstoque = array_sum(array_column($produtos, 'estoque'));
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos - Controle de Estoque</title>
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
            
            <!-- Cabeçalho -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1"><i class="bi bi-box-seam me-2 text-primary"></i>Lista de Produtos</h2>
                    <p class="text-muted mb-2">Gerencie seus produtos e acompanhe a quantidade atual em estoque.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="estoque.php" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Produtos</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex gap-2">
                    <a href="produtos_cadastro.php" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Novo Produto
                    </a>
                </div>
            </div>

            <!-- Cards Informativos -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small">Total de Produtos</span>
                                <h4 class="fw-bold mb-0 mt-1"><?= $totalProdutos ?></h4>
                            </div>
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded">
                                <i class="bi bi-tags fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card border-0 shadow-sm p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small">Itens em Estoque</span>
                                <h4 class="fw-bold text-success mb-0 mt-1"><?= $totalEmEstoque ?></h4>
                            </div>
                            <div class="bg-success bg-opacity-10 text-success p-3 rounded">
                                <i class="bi bi-boxes fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabela de Produtos -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Produtos Cadastrados</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Preço Un.</th>
                                    <th>Estoque Atual</th>
                                    <th>Status</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($produtos)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            Nenhum produto cadastrado até o momento.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($produtos as $p): ?>
                                        <tr>
                                            <td>#<?= $p['id'] ?></td>
                                            <td>
                                                <span class="fw-semibold text-dark"><?= htmlspecialchars($p['nome']) ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border"><?= htmlspecialchars($p['categoria']) ?></span>
                                            </td>
                                            <td class="fw-medium">R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                            <td>
                                                <?php if ($p['estoque'] <= 0): ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                        <i class="bi bi-exclamation-triangle me-1"></i> Esgotado (0)
                                                    </span>
                                                <?php elseif ($p['estoque'] < 5): ?>
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                                        <i class="bi bi-exclamation-circle me-1"></i> Baixo (<?= $p['estoque'] ?>)
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                        <i class="bi bi-check-circle me-1"></i> <?= $p['estoque'] ?> un.
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (strtolower($p['status']) === 'ativo'): ?>
                                                    <span class="badge bg-success rounded-pill">Ativo</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary rounded-pill">Inativo</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end">
                                                <a href="produtos_editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="estoque_entrada.php?produto_id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-success me-1" title="Adicionar Entrada">
                                                    <i class="bi bi-plus-circle"></i>
                                                </a>
                                                <a href="estoque_saida.php?produto_id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" title="Dar Saída">
                                                    <i class="bi bi-dash-circle"></i>
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

        </main>

        <?php require_once APP_COMPONENTES.'/footer.php';?>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>