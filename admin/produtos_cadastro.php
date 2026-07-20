<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>
<?php
$con = config::connect(); 
// Instancia a conexão (ajuste para a sua variável real definida em conexao.php, ex: $pdo ou $conn)
$conexao = isset($pdo) ? $pdo : $con;

$mensagem = "";

// Processamento do Formulário via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    try {
        $nome = trim($_POST['nome']);
        $categoria = trim($_POST['categoria']);
        // Limpa a formatação visual de moeda (ex: 1.250,50 vira 1250.50)
        $preco = str_replace(',', '.', str_replace('.', '', $_POST['preco']));
        $estoque = intval($_POST['estoque']);
        $status = $_POST['status'] ?? 'ativo';

        if (!empty($nome) && !empty($categoria) && !empty($preco)) {
            $stmt = $conexao->prepare("INSERT INTO produtos (nome, categoria, preco, estoque, status) VALUES (:nome, :categoria, :preco, :estoque, :status)");
            $stmt->execute([
                ':nome' => $nome,
                ':categoria' => $categoria,
                ':preco' => $preco,
                ':estoque' => $estoque,
                ':status' => $status
            ]);
            $mensagem = "<div class='alert alert-success alert-dismissible fade show rounded-3 mb-4' role='alert'>
                            <i class='bi bi-check-circle-fill me-2'></i> Produto cadastrado com sucesso!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        } else {
            $mensagem = "<div class='alert alert-warning alert-dismissible fade show rounded-3 mb-4' role='alert'>
                            <i class='bi bi-exclamation-triangle-fill me-2'></i> Por favor, preencha todos os campos obrigatórios (*).
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        }
    } catch (PDOException $e) {
        $mensagem = "<div class='alert alert-danger alert-dismissible fade show rounded-3 mb-4' role='alert'>
                        <i class='bi bi-x-circle-fill me-2'></i> Erro ao cadastrar o produto: " . $e->getMessage() . "
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
    <title>Cadastro de Produto - Sistema de Controle de Estoque</title>
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
                    <h2 class="fw-bold mb-1">Novo Produto</h2>
                    <p class="text-muted mb-2">Adicionar produto novo ao catálogo do estoque.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item"><a href="produtos.php" class="text-decoration-none">Produtos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Novo Produto</li>
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
                    <!-- Formulário de Cadastro Principal -->
                    <div class="card rounded-4 shadow-sm border-0">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="fw-bold mb-0">Informações Básicas</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="" method="POST">
                                <input type="hidden" name="acao" value="cadastrar">
                                
                                <div class="mb-4">
                                    <label for="nome" class="form-label small fw-semibold text-muted mb-1">Nome do Produto *</label>
                                    <input type="text" class="form-control rounded-3" id="nome" name="nome" required placeholder="Ex: Mouse Sem Fio Ergonômico">
                                </div>

                                <div class="mb-4">
                                    <label for="categoria" class="form-label small fw-semibold text-muted mb-1">Categoria *</label>
                                    <input type="text" class="form-control rounded-3" id="categoria" name="categoria" required placeholder="Ex: Periféricos, Eletrônicos">
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label for="preco" class="form-label small fw-semibold text-muted mb-1">Preço Unitário de Venda (R$) *</label>
                                        <input type="text" class="form-control rounded-3" id="preco" name="preco" required placeholder="0,00" onkeyup="formatarMoeda(this)">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="estoque" class="form-label small fw-semibold text-muted mb-1">Quantidade em Estoque Inicial *</label>
                                        <input type="number" class="form-control rounded-3" id="estoque" name="estoque" required min="0" value="0">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="form-label small fw-semibold text-muted mb-1">Status de Disponibilidade</label>
                                    <select class="form-select rounded-3" id="status" name="status">
                                        <option value="ativo" selected>Ativo (Visível e disponível para venda/movimentação)</option>
                                        <option value="inativo">Inativo (Indisponível para movimentação temporariamente)</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                    <a href="produtos.php" class="btn btn-light rounded-3 px-4">Cancelar</a>
                                    <button type="submit" class="btn btn-primary rounded-3 px-4">Salvar Registro</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
                
                <div class="col-12 col-xl-4">
                    <!-- Painel Lateral Auxiliar -->
                    <div class="card rounded-4 shadow-sm border-0 bg-light-subtle">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Dicas de Cadastro</h6>
                            <p class="small text-muted mb-2"><strong>Campos Obrigatórios:</strong> Certifique-se de preencher todos os dados marcados com um asterisco (*).</p>
                            <p class="small text-muted mb-2"><strong>Preço:</strong> O valor digitado será automaticamente formatado como moeda. Não utilize pontos para os milhares manualmente.</p>
                            <p class="small text-muted mb-0"><strong>Estoque Inicial:</strong> Caso não tenha unidades físicas deste item em mãos neste momento, você pode deixar o valor como 0 e registrar um ajuste de entrada posterior.</p>
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

    <script>
        // Formata dinamicamente o campo preço em formato monetário nacional à medida que o usuário digita
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