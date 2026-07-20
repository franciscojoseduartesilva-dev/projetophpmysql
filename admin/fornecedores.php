<?php require_once __DIR__ . '/componentes/config.php' ?>
<?php require_once __DIR__ . '/componentes/rotas.php' ?>
<?php require_once __DIR__ . '/componentes/conexao.php' ?>
<?php
$con = config::connect(); 
// Instancia a conexão (ajuste para a sua variável real definida em conexao.php, ex: $pdo ou $conn)
$conexao = isset($pdo) ? $pdo : $con;

$mensagem = "";

// Lógica para Inserir Fornecedor (Ação do Formulário)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    try {
        $nome = trim($_POST['nome']);
        $razao_social = !empty($_POST['razao_social']) ? trim($_POST['razao_social']) : null;
        $cnpj = !empty($_POST['cnpj']) ? trim($_POST['cnpj']) : null;
        $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $telefone = !empty($_POST['telefone']) ? trim($_POST['telefone']) : null;
        $contato = !empty($_POST['contato']) ? trim($_POST['contato']) : null;
        $endereco = !empty($_POST['endereco']) ? trim($_POST['endereco']) : null;
        $cidade = !empty($_POST['cidade']) ? trim($_POST['cidade']) : null;
        $estado = !empty($_POST['estado']) ? strtoupper(trim($_POST['estado'])) : null;
        $cep = !empty($_POST['cep']) ? trim($_POST['cep']) : null;
        $status = $_POST['status'] ?? 'ativo';

        if (!empty($nome)) {
            $stmt = $conexao->prepare("INSERT INTO fornecedores (nome, razao_social, cnpj, email, telefone, contato, endereco, cidade, estado, cep, status) VALUES (:nome, :razao_social, :cnpj, :email, :telefone, :contato, :endereco, :cidade, :estado, :cep, :status)");
            $stmt->execute([
                ':nome' => $nome,
                ':razao_social' => $razao_social,
                ':cnpj' => $cnpj,
                ':email' => $email,
                ':telefone' => $telefone,
                ':contato' => $contato,
                ':endereco' => $endereco,
                ':cidade' => $cidade,
                ':estado' => $estado,
                ':cep' => $cep,
                ':status' => $status
            ]);
            $mensagem = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <i class='bi bi-check-circle-fill me-2'></i> Fornecedor cadastrado com sucesso!
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        }
    } catch (PDOException $e) {
        // Trata erro de CNPJ duplicado (UNIQUE KEY)
        if ($e->getCode() == 23000) {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <i class='bi bi-exclamation-triangle-fill me-2'></i> Erro: Este CNPJ já está cadastrado no sistema.
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        } else {
            $mensagem = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            <i class='bi bi-x-circle-fill me-2'></i> Erro ao cadastrar: " . $e->getMessage() . "
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                         </div>";
        }
    }
}

// Lógica para buscar os parceiros registrados
try {
    $stmtLista = $conexao->query("SELECT * FROM fornecedores ORDER BY id DESC");
    $fornecedores = $stmtLista->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $fornecedores = [];
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
                    <h2 class="fw-bold mb-1">Fornecedores</h2>
                    <p class="text-muted mb-2">Gerencie as empresas e parceiros logísticos.</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
                        </ol>
                    </nav>
                </div>
                <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted me-3 d-none d-lg-inline" id="currentDate"><i class="bi bi-calendar3 me-1"></i><?= date('d/m/Y'); ?></span>
                    <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNovoFornecedor">
                        <i class="bi bi-plus-lg me-1"></i> Novo Fornecedor
                    </button>
                </div>
            </div>

            <!-- Exibe os alertas de feedback para o usuário -->
            <?= $mensagem; ?>

            <div class="row g-4 mb-4">
                <div class="col-12">
                    <!-- Tabela de Fornecedores Cadastrados -->
                    <div class="card rounded-4 shadow-sm border-0">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Lista de Contatos</h5>
                            <input type="text" id="inputBusca" class="form-control form-control-sm rounded-3" placeholder="Buscar fornecedor..." style="max-width: 250px;">
                        </div>
                        <div class="card-body px-0 pb-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="tabelaFornecedores">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">ID</th>
                                            <th>Nome / Razão Social</th>
                                            <th>CNPJ</th>
                                            <th>Contato direto</th>
                                            <th>Localidade</th>
                                            <th>Status</th>
                                            <th class="pe-4 text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($fornecedores)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">Nenhum fornecedor localizado.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($fornecedores as $forn): ?>
                                                <tr>
                                                    <td class="ps-4 text-muted">#<?= $forn['id']; ?></td>
                                                    <td>
                                                        <strong class="text-dark d-block"><?= htmlspecialchars($forn['nome']); ?></strong>
                                                        <?php if(!empty($forn['razao_social'])): ?>
                                                            <small class="text-muted"><?= htmlspecialchars($forn['razao_social']); ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-nowrap"><?= htmlspecialchars($forn['cnpj'] ?? '---'); ?></td>
                                                    <td>
                                                        <span class="d-block small"><i class="bi bi-envelope me-1 text-muted"></i><?= htmlspecialchars($forn['email'] ?? '---'); ?></span>
                                                        <span class="d-block small"><i class="bi bi-telephone me-1 text-muted"></i><?= htmlspecialchars($forn['telefone'] ?? '---'); ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($forn['cidade'])): ?>
                                                            <span><?= htmlspecialchars($forn['cidade']); ?> - <?= htmlspecialchars($forn['estado']); ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">---</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($forn['status'] === 'ativo'): ?>
                                                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5">Ativo</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2.5">Inativo</span>
                                                        <?php endif; ?>
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

    <!-- Modal para Cadastro de Novo Fornecedor -->
    <div class="modal fade" id="modalNovoFornecedor" tabindex="-1" aria-labelledby="modalNovoFornecedorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalNovoFornecedorLabel">Cadastrar Fornecedor</h5>
                    <button type="button" class="btn-close" data-bs-modal="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="POST">
                    <input type="hidden" name="acao" value="cadastrar">
                    <div class="modal-body py-3">
                        
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label small fw-semibold text-muted mb-1">Nome Fantasia *</label>
                                <input type="text" class="form-control rounded-3" id="nome" name="nome" required placeholder="Ex: Distribuidora Alfa">
                            </div>
                            <div class="col-md-6">
                                <label for="razao_social" class="form-label small fw-semibold text-muted mb-1">Razão Social</label>
                                <input type="text" class="form-control rounded-3" id="razao_social" name="razao_social" placeholder="Ex: Alfa Transportes e Comércio LTDA">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="cnpj" class="form-label small fw-semibold text-muted mb-1">CNPJ</label>
                                <input type="text" class="form-control rounded-3" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00">
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label small fw-semibold text-muted mb-1">E-mail de Contato</label>
                                <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="comercial@alfa.com">
                            </div>
                            <div class="col-md-4">
                                <label for="telefone" class="form-label small fw-semibold text-muted mb-1">Telefone</label>
                                <input type="text" class="form-control rounded-3" id="telefone" name="telefone" placeholder="(00) 00000-0000">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="contato" class="form-label small fw-semibold text-muted mb-1">Pessoa de Contato / Vendedor</label>
                            <input type="text" class="form-control rounded-3" id="contato" name="contato" placeholder="Ex: Carlos Silva">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="endereco" class="form-label small fw-semibold text-muted mb-1">Endereço Completo</label>
                                <input type="text" class="form-control rounded-3" id="endereco" name="endereco" placeholder="Av. Principal, 123 - Centro">
                            </div>
                            <div class="col-md-3">
                                <label for="cidade" class="form-label small fw-semibold text-muted mb-1">Cidade</label>
                                <input type="text" class="form-control rounded-3" id="cidade" name="cidade" placeholder="Ex: São Paulo">
                            </div>
                            <div class="col-md-1.5 col-6">
                                <label for="estado" class="form-label small fw-semibold text-muted mb-1">UF</label>
                                <input type="text" class="form-control rounded-3" id="estado" name="estado" maxlength="2" placeholder="SP">
                            </div>
                            <div class="col-md-1.5 col-6">
                                <label for="cep" class="form-label small fw-semibold text-muted mb-1">CEP</label>
                                <input type="text" class="form-control rounded-3" id="cep" name="cep" placeholder="00000-000">
                            </div>
                        </div>

                        <div class="mb-1">
                            <label for="status" class="form-label small fw-semibold text-muted mb-1">Status do Fornecedor</label>
                            <select class="form-select rounded-3" id="status" name="status">
                                <option value="ativo" selected>Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">Salvar Fornecedor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/script.js"></script>

    <script>
        // Script simples para busca dinâmica em tempo real na listagem
        document.getElementById('inputBusca').addEventListener('keyup', function() {
            let busca = this.value.toLowerCase();
            let linhas = document.querySelectorAll('#tabelaFornecedores tbody tr');
            
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