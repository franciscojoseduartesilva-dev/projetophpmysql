<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>
<?php require_once __DIR__ . '/query/query_produtos.php' ?>
<?php
$con = config::connect(); 
// Centraliza e instância a conexão correta com o banco de dados

$conexao = isset($pdo) ? $pdo : $con;

$mensagem = "";

// LÓGICA DE EXCLUSÃO INTEGRADA
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    try {
        // Descriptografa o ID recebido via URL
        $idDecodificado = encrypt_secure(urldecode($_GET['id']), 'd');

        if ($idDecodificado) {
            $stmtExcluir = $conexao->prepare("DELETE FROM produtos WHERE id = :id");
            $stmtExcluir->execute([':id' => $idDecodificado]);
            
            // Mensagem de sucesso estilizada do Bootstrap
            $mensagem = "<div class='alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm' role='alert'>
                            <div class='d-flex align-items-center'>
                                <i class='bi bi-check-circle-fill me-2 fs-5'></i>
                                <span>Produto removido permanentemente com sucesso!</span>
                            </div>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
            
            // Recarrega os dados para atualizar a listagem após a remoção
            if (function_exists('atualizarDadosProdutos')) {
                $dados = atualizarDadosProdutos();
            } else {
                $dados = $conexao->query("SELECT * FROM produtos ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm' role='alert'>
                            <i class='bi bi-x-circle-fill me-2'></i> Erro: Assinatura de segurança de ID inválida.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        }
    } catch (PDOException $e) {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm' role='alert'>
                        <i class='bi bi-exclamation-octagon-fill me-2'></i> Não foi possível excluir o produto. Erro: " . $e->getMessage() . "
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                     </div>";
    }
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

    <?php require_once APP_COMPONENTES . '/sibebar.php'; ?>

    <section class="dashboard-wrapper" id="mainWrapper">

        <?php require_once APP_COMPONENTES . '/header.php'; ?>

        <main class="p-4 flex-grow-1">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Produtos</h2>
                    <p class="text-muted mb-2">Lista de produtos</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y'); ?></span>
                    <button class="btn btn-primary shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalNovoProduto">
                        <i class="bi bi-plus-lg me-1"></i> Novo Produto
                    </button>
                    <button class="btn btn-success shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalEntrada">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Registrar Entrada
                    </button>
                    <button class="btn btn-danger shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#modalSaida">
                        <i class="bi bi-box-arrow-left me-1"></i> Registrar Saída
                    </button>
                </div>
            </div>

            <!-- Exibição de Alertas dinâmicos -->
            <?= $mensagem; ?>

            <div class="row g-4 mb-4">
                <div class="col-12">

                    <!-- Painel/Card Moderno para Tabela -->
                    <div class="card rounded-4 shadow-sm border-0 mb-4">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-box-seam text-primary me-2"></i>Itens em Estoque</h5>
                            <input type="text" id="inputBusca" class="form-control form-control-sm rounded-3" placeholder="Buscar produto..." style="max-width: 250px;">
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tabelaProdutos">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th class="ps-4" style="width: 80px;">Ref.</th>
                                            <th>Produto</th>
                                            <th>Categoria</th>
                                            <th>Preço Unitário</th>
                                            <th>Qtd. Estoque</th>
                                            <th class="pe-4 text-center" style="width: 160px;">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                        $contador = 1;
                                        foreach($dados as $produtos){
                                            $encId = encrypt_secure($produtos['id'],'e');
                                        ?>
                                        <tr>
                                            <td class="ps-4 text-muted small">#<?= $contador++; ?></td>
                                            <td>
                                                <div class="fw-semibold text-dark"><?php echo htmlspecialchars($produtos['nome'])?></div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-secondary border rounded-pill px-2.5 py-1.5">
                                                    <?php echo htmlspecialchars($produtos['categoria'])?>
                                                </span>
                                            </td>
                                            <td class="fw-medium text-dark">
                                                R$ <?php echo number_format($produtos['preco'], 2, ',', '.')?>
                                            </td>
                                            <td>
                                                <?php
                                                $estoque = $produtos['estoque']??0;
                                                ?>
                                                <?php if( $estoque <= 0): ?>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2.5">Sem Estoque</span>
                                                <?php else: ?>
                                                    <span class="fw-semibold text-success"><?= $produtos['estoque']; ?> un.</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="pe-4 text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="produto_editar.php?id=<?= urlencode($encId); ?>" class="btn btn-outline-secondary rounded-2 me-1" title="Editar"><i class="bi bi-pencil"></i></a>
                                                    <a href="?action=delete&id=<?= urlencode($encId); ?>" 
                                                       class="btn btn-outline-danger rounded-2" 
                                                       title="Excluir"
                                                       onclick="return confirm('Tem certeza que deseja remover permanentemente o produto: <?php echo addslashes($produtos['nome']); ?>?');">
                                                       <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </main>

        <?php require_once APP_COMPONENTES . '/footer.php'; ?>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/script.js"></script>

    <script>
        // Filtro em tempo real no Frontend para a barra de busca
        document.getElementById('inputBusca').addEventListener('keyup', function() {
            let busca = this.value.toLowerCase();
            let linhas = document.querySelectorAll('#tabelaProdutos tbody tr');
            
            linhas.forEach(linha => {
                let texto = inline.textContent.toLowerCase();
                if(texto.indexOf(busca) > -1) {
                    linha.style.display = '';
                } else {
                    linha.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>