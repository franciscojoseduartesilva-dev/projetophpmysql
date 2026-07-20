<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>

<?php
$con = config::connect(); 

// Instancia a conexão (ajuste para a sua variável real definida em conexao.php, ex: $pdo ou $conn)
$conexao = isset($pdo) ? $pdo : $con;

try {
    // 1. Total de Produtos Cadastrados
    $totalProdutos = $conexao->query("SELECT COUNT(*) FROM produtos")->fetchColumn();

    // 2. Soma de Itens Totais em Estoque
    $itensEstoque = $conexao->query("SELECT SUM(estoque) FROM produtos WHERE status = 'ativo'")->fetchColumn() ?? 0;

    // 3. Estoque Baixo (Exemplo: produtos ativos com menos de 10 unidades no estoque)
    $estoqueBaixo = $conexao->query("SELECT COUNT(*) FROM produtos WHERE estoque < 10 AND estoque > 0 AND status = 'ativo'")->fetchColumn();

    // 4. Sem Estoque
    $semEstoque = $conexao->query("SELECT COUNT(*) FROM produtos WHERE estoque <= 0 AND status = 'ativo'")->fetchColumn();

    // 5. Entradas (Mês Atual)
    $entradasMes = $conexao->query("SELECT COUNT(*) FROM movimentacoes_estoque WHERE tipo = 'entrada' AND MONTH(criado_em) = MONTH(CURRENT_DATE()) AND YEAR(criado_em) = YEAR(CURRENT_DATE())")->fetchColumn();

    // 6. Saídas (Mês Atual)
    $saidasMes = $conexao->query("SELECT COUNT(*) FROM movimentacoes_estoque WHERE tipo = 'saida' AND MONTH(criado_em) = MONTH(CURRENT_DATE()) AND YEAR(criado_em) = YEAR(CURRENT_DATE())")->fetchColumn();

    // 7. Valor Total do Estoque (Preço * Estoque de itens ativos)
    $valorTotalEstoque = $conexao->query("SELECT SUM(preco * estoque) FROM produtos WHERE status = 'ativo'")->fetchColumn() ?? 0;

    // 8. Total de Fornecedores Ativos
    $totalFornecedores = $conexao->query("SELECT COUNT(*) FROM fornecedores WHERE status = 'ativo'")->fetchColumn();

} catch (PDOException $e) {
    // Fallback amigável caso ocorra erro no banco de dados durante o desenvolvimento
    $totalProdutos = $itensEstoque = $estoqueBaixo = $semEstoque = $entradasMes = $saidasMes = $valorTotalEstoque = $totalFornecedores = 0;
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
                    <h2 class="fw-bold mb-1">Dashboard de Estoque</h2>
                    <p class="text-muted mb-2">Bem-vindo de volta! Aqui está o resumo do seu estoque hoje.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y'); ?></span>
                    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovoProduto">
                        <i class="bi bi-plus-lg me-1"></i> Novo Produto
                    </button>
                    <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEntrada">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Registrar Entrada
                    </button>
                    <button class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#modalSaida">
                        <i class="bi bi-box-arrow-left me-1"></i> Registrar Saída
                    </button>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Total de Produtos -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fs-6">Total de Produtos</p>
                                <h3 class="fw-bold mb-1"><?= number_format($totalProdutos, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-success small">
                            <i class="bi bi-arrow-up-short"></i> <span>Dinamizado</span>
                        </div>
                    </div>
                </div>
                
                <!-- Itens em Estoque -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fs-6">Itens em Estoque</p>
                                <h3 class="fw-bold mb-1"><?= number_format($itensEstoque, 0, ',', '.'); ?></h3>
                            </div>
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-layers"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-success small">
                            <i class="bi bi-arrow-up-short"></i> <span>Dinamizado</span>
                        </div>
                    </div>
                </div>

                <!-- Estoque Baixo -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover h-100 p-3 rounded-4 border-start border-4 border-warning">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fs-6">Estoque Baixo (&lt; 10)</p>
                                <h3 class="fw-bold mb-1"><?= $estoqueBaixo; ?></h3>
                            </div>
                            <div class="icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-warning small">
                            <i class="bi bi-info-circle"></i> <span>Requer atenção</span>
                        </div>
                    </div>
                </div>

                <!-- Sem Estoque -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover h-100 p-3 rounded-4 border-start border-4 border-danger">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fs-6">Sem Estoque</p>
                                <h3 class="fw-bold mb-1"><?= $semEstoque; ?></h3>
                            </div>
                            <div class="icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-x-octagon"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-danger small">
                            <i class="bi bi-arrow-up-short"></i> <span>Crítico</span>
                        </div>
                    </div>
                </div>

                <!-- Entradas do Mês -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fs-6">Entradas (Mês)</p>
                                <h3 class="fw-bold mb-1"><?= $entradasMes; ?></h3>
                            </div>
                            <div class="icon-box bg-info bg-opacity-10 text-info">
                                <i class="bi bi-box-arrow-in-right"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-success small">
                            <span>Mês Corrente</span>
                        </div>
                    </div>
                </div>

                <!-- Saídas do Mês -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fs-6">Saídas (Mês)</p>
                                <h3 class="fw-bold mb-1"><?= $saidasMes; ?></h3>
                            </div>
                            <div class="icon-box bg-secondary bg-opacity-10 text-secondary">
                                <i class="bi bi-box-arrow-left"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-success small">
                            <span>Mês Corrente</span>
                        </div>
                    </div>
                </div>

                <!-- Valor Total -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fs-6">Valor Total</p>
                                <h3 class="fw-bold mb-1">R$ <?= number_format($valorTotalEstoque, 2, ',', '.'); ?></h3>
                            </div>
                            <div class="icon-box bg-success bg-opacity-25 text-success">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-success small">
                            <i class="bi bi-arrow-up-short"></i> <span>Financeiro</span>
                        </div>
                    </div>
                </div>

                <!-- Fornecedores -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card card-hover h-100 p-3 rounded-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-muted mb-1 fs-6">Fornecedores</p>
                                <h3 class="fw-bold mb-1"><?= $totalFornecedores; ?></h3>
                            </div>
                            <div class="icon-box bg-dark bg-opacity-10 text-dark">
                                <i class="bi bi-truck"></i>
                            </div>
                        </div>
                        <div class="mt-2 text-muted small">
                            <span>Parceiros Ativos</span>
                        </div>
                    </div>
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