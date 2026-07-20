<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>
<?php
$con = config::connect(); 
// Instancia a conexão (ajuste para a sua variável real definida em conexao.php, ex: $pdo ou $conn)
$conexao = isset($pdo) ? $pdo : $con;

$mensagem = "";

// Consulta inteligente para extrair as categorias únicas e a quantidade de itens associados a cada uma
try {
    $stmtLista = $conexao->query("
        SELECT categoria, COUNT(*) as total_produtos 
        FROM produtos 
        GROUP BY categoria 
        ORDER BY categoria ASC
    ");
    $categorias = $stmtLista->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categorias = [];
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
                    <h2 class="fw-bold mb-1">Categorias</h2>
                    <p class="text-muted mb-2">Monitore a distribuição de departamentos do estoque.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categorias</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y'); ?></span>
                    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovaCategoria">
                        <i class="bi bi-tag me-1"></i> Nova Categoria
                    </button>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <!-- Painel de Listagem de Categorias -->
                    <div class="card rounded-4 shadow-sm border-0">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="fw-bold mb-0">Classificações do Inventário</h5>
                            <input type="text" id="inputBusca" class="form-control form-control-sm rounded-3" placeholder="Filtrar categorias..." style="max-width: 250px;">
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tabelaCategorias">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Identificação da Categoria</th>
                                            <th>Volumetria de Itens</th>
                                            <th>Status Padrão</th>
                                            <th class="pe-4 text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($categorias)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">Nenhuma categoria identificada nas listagens de produtos.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($categorias as $cat): ?>
                                                <tr>
                                                    <td class="ps-4">
                                                        <span class="fw-semibold text-dark"><i class="bi bi-folder2-open me-2 text-muted"></i><?= htmlspecialchars($cat['categoria']); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5">
                                                            <?= $cat['total_produtos']; ?> <?= $cat['total_produtos'] == 1 ? 'produto cadastrado' : 'produtos cadastrados'; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5">Ativo</span>
                                                    </td>
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

    <!-- Modal para Estruturação de Nova Categoria -->
    <div class="modal fade" id="modalNovaCategoria" tabindex="-1" aria-labelledby="modalNovaCategoriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalNovaCategoriaLabel">Criar Nova Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body py-3">
                        <div class="mb-3">
                            <label for="nome_categoria" class="form-label small fw-semibold text-muted mb-1">Título da Categoria *</label>
                            <input type="text" class="form-control rounded-3" id="nome_categoria" name="nome_categoria" required placeholder="Ex: Componentes, Acessórios, Escritório">
                        </div>
                        <div class="mb-1">
                            <label for="status_cat" class="form-label small fw-semibold text-muted mb-1">Visibilidade inicial</label>
                            <select class="form-select rounded-3" id="status_cat" name="status_cat">
                                <option value="ativo" selected>Disponível no Cadastro de Produtos</option>
                                <option value="inativo">Restrito / Suspenso</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">Salvar Registo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/script.js"></script>

    <script>
        // Filtro em tempo real de categorias com JavaScript puro
        document.getElementById('inputBusca').addEventListener('keyup', function() {
            let busca = this.value.toLowerCase();
            let linhas = document.querySelectorAll('#tabelaCategorias tbody tr');
            
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