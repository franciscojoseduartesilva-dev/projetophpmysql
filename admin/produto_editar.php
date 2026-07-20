<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>
<?php
$con = config::connect(); 
// Instancia a conexão com o banco
$conexao = isset($pdo) ? $pdo : $con;

$mensagem = "";
$produto = null;

// 1. Verifica se o ID do produto foi enviado via URL (GET)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = encrypt_secure($_GET['id'],'d'); 
    
    
    try {
        // Busca os dados atuais do produto para preencher o formulário
        $stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$produto) {
            $mensagem = "<div class='alert alert-warning rounded-3 mb-4' role='alert'>
                            <i class='bi bi-exclamation-triangle-fill me-2'></i> Produto não localizado no sistema.
                         </div>";
        }
    } catch (PDOException $e) {
        $mensagem = "<div class='alert alert-danger rounded-3 mb-4' role='alert'>
                        <i class='bi bi-x-circle-fill me-2'></i> Erro ao buscar produto: " . $e->getMessage() . "
                     </div>";
    }
} else {
    $mensagem = "<div class='alert alert-danger rounded-3 mb-4' role='alert'>
                    <i class='bi bi-exclamation-octagon-fill me-2'></i> ID do produto inválido ou não fornecido.
                 </div>";
}

// 2. Processamento da Atualização (Quando o formulário for enviado via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'editar' && $produto) {
    try {
        $nome = trim($_POST['nome']);
        $categoria = trim($_POST['categoria']);
        // Trata o preço vindo formatado da máscara em JS (ex: 1.250,90 para 1250.90)
        $preco = str_replace(',', '.', str_replace('.', '', $_POST['preco']));
        $estoque = intval($_POST['estoque']);
        $status = $_POST['status'];

        if (!empty($nome) && !empty($categoria) && !empty($preco)) {
            $stmtUpdate = $conexao->prepare("UPDATE produtos SET nome = :nome, categoria = :categoria, preco = :preco, estoque = :estoque, status = :status WHERE id = :id");
            $stmtUpdate->execute([
                ':nome' => $nome,
                ':categoria' => $categoria,
                ':preco' => $preco,
                ':estoque' => $estoque,
                ':status' => $status,
                ':id' => $id
            ]);
            
            $mensagem = "<div class='alert alert-success alert-dismissible fade show rounded-3 mb-4' role='alert'>
                            <i class='bi bi-check-circle-fill me-2'></i> Produto atualizado com sucesso!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
            
            // Recarrega os dados atualizados para atualizar a tela
            $stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $mensagem = "<div class='alert alert-warning alert-dismissible fade show rounded-3 mb-4' role='alert'>
                            <i class='bi bi-exclamation-triangle-fill me-2'></i> Por favor, preencha todos os campos obrigatórios (*).
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        }
    } catch (PDOException $e) {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show rounded-3 mb-4' role='alert'>
                        <i class='bi bi-x-circle-fill me-2'></i> Erro ao atualizar o produto: " . $e->getMessage() . "
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
    <title>Editar Produto - Sistema de Controle de Estoque</title>
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
                    <h2 class="fw-bold mb-1">Editar Produto</h2>
                    <p class="text-muted mb-2">Alterar informações do produto existente</p>[cite: 9]
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>[cite: 9]
                            <li class="breadcrumb-item"><a href="produtos.php" class="text-decoration-none">Produtos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y'); ?></span>
                    <a href="produtos.php" class="btn btn-outline-secondary shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Voltar para Lista
                    </a>
                </div>
            </div>

            <!-- Exibição de Alertas -->
            <?= $mensagem; ?>

            <div class="row g-4 mb-4">
                <div class="col-12 col-xl-8">
                    <?php if ($produto): ?>
                        <!-- Formulário de Edição -->
                        <div class="card rounded-4 shadow-sm border-0">
                            <div class="card-header bg-transparent border-0 pt-4 px-4">
                                <h5 class="fw-bold mb-0">Modificar Dados Técnicos</h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="" method="POST">
                                    <input type="hidden" name="acao" value="editar">
                                    
                                    <div class="mb-4">
                                        <label for="nome" class="form-label small fw-semibold text-muted mb-1">Nome do Produto *</label>
                                        <input type="text" class="form-control rounded-3" id="nome" name="nome" required value="<?= htmlspecialchars($produto['nome']); ?>" placeholder="Ex: Teclado Mecânico Pro">
                                    </div>

                                    <div class="mb-4">
                                        <label for="categoria" class="form-label small fw-semibold text-muted mb-1">Categoria *</label>
                                        <input type="text" class="form-control rounded-3" id="categoria" name="categoria" required value="<?= htmlspecialchars($produto['categoria']); ?>" placeholder="Ex: Periféricos">
                                    </div>

                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label for="preco" class="form-label small fw-semibold text-muted mb-1">Preço de Venda (R$) *</label>
                                            <input type="text" class="form-control rounded-3" id="preco" name="preco" required value="<?= number_format($produto['preco'], 2, ',', '.'); ?>" placeholder="0,00" onkeyup="formatarMoeda(this)">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="estoque" class="form-label small fw-semibold text-muted mb-1">Quantidade em Estoque *</label>
                                            <input type="number" class="form-control rounded-3" id="estoque" name="estoque" required min="0" value="<?= $produto['estoque']; ?>">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="status" class="form-label small fw-semibold text-muted mb-1">Status do Registro</label>
                                        <select class="form-select rounded-3" id="status" name="status">
                                            <option value="ativo" <?= $produto['status'] === 'ativo' ? 'selected' : ''; ?>>Ativo</option>
                                            <option value="inativo" <?= $produto['status'] === 'inativo' ? 'selected' : ''; ?>>Inativo</option>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                        <a href="produtos.php" class="btn btn-light rounded-3 px-4">Cancelar</a>
                                        <button type="submit" class="btn btn-primary rounded-3 px-4">Salvar Alterações</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </main>

        <?php require_once APP_COMPONENTES . '/footer.php'; ?>[cite: 9]
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>[cite: 9]
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>[cite: 9]
    <script src="assets/script.js"></script>[cite: 9]

    <script>
        // Formata dinamicamente o campo preço em formato monetário nacional ao digitar
        function formatarMoeda(elemento) {
            let valor = elemento.value.replace(/\D/g, "");
            valor = (valor / 100).toFixed(2) + "";
            valor = valor.replace(".", ",");
            valor = valor.replace(/(\d)(\d{3})(?=\d)/g, "$1.$2");
            elemento.value = valor;
        }
    </script>
</body>

</html>