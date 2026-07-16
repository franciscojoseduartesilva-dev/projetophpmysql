<?php require_once dirname(__DIR__) . '/componentes/config.php'; ?>
<?php

if (!empty($_GET['logout']) && $_GET['logout'] == "ok") {

    $_SESSION = [];
    session_destroy();  
    header('Location:paineladmin.php');
    exit();
    
}

if (empty($_SESSION['userstatus'])) {
    header('Location:index.php');
    exit();
}
?>


<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #212529;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 5px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .sidebar .logo {
            color: #fff;
            font-size: 22px;
            font-weight: bold;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #343a40;
        }

        .content {
            padding: 25px;
        }

        .card-dashboard {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .icon-card {
            font-size: 38px;
            opacity: 0.8;
        }

        .table-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }

            .content {
                padding: 15px;
            }
        }
    </style>
</head>

<body>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Deseja realmente encerrar a sessão?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="?logout=ok" class="btn btn-primary">Confirmar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">

            <!-- MENU LATERAL -->
            <nav class="col-md-3 col-lg-2 sidebar p-0">

                <div class="logo">
                    <i class="bi bi-speedometer2"></i>
                    Admin
                </div>

                <div class="p-3">
                    <ul class="nav flex-column">

                        <li class="nav-item">
                            <a href="paineladmin.html" class="nav-link active">
                                <i class="bi bi-house-door"></i>
                                Painel
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="produtos.html" class="nav-link">
                                <i class="bi bi-box-seam"></i>
                                Produtos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="clientes.html" class="nav-link">
                                <i class="bi bi-people"></i>
                                Clientes
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="usuarios.html" class="nav-link">
                                <i class="bi bi-person-gear"></i>
                                Usuários
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="relatorios.html" class="nav-link">
                                <i class="bi bi-bar-chart-line"></i>
                                Relatórios
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="configuracoes.html" class="nav-link">
                                <i class="bi bi-gear"></i>
                                Configurações
                            </a>
                        </li>

                        <li class="nav-item mt-4">
                            <a href="#" class="nav-link text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="bi bi-box-arrow-right"></i>
                                Sair
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>

            <!-- CONTEÚDO PRINCIPAL -->
            <main class="col-md-9 col-lg-10 content">

                <!-- TOPO -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

                    <div>
                        <h2 class="mb-0">Painel Administrativo</h2>
                        <p class="text-muted mb-0">Bem-vindo ao sistema de gerenciamento.</p>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-bell"></i>
                        </button>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPerfil">
                            <i class="bi bi-person-circle"></i>
                            Administrador
                        </button>
                    </div>

                </div>

                <!-- CARDS -->
                <div class="row g-4 mb-4">

                    <div class="col-md-6 col-xl-3">
                        <div class="card card-dashboard">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Produtos</h6>
                                    <h3>120</h3>
                                </div>
                                <i class="bi bi-box-seam text-primary icon-card"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card card-dashboard">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Clientes</h6>
                                    <h3>85</h3>
                                </div>
                                <i class="bi bi-people text-success icon-card"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card card-dashboard">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Vendas</h6>
                                    <h3>R$ 7.500</h3>
                                </div>
                                <i class="bi bi-cash-coin text-warning icon-card"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card card-dashboard">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Usuários</h6>
                                    <h3>12</h3>
                                </div>
                                <i class="bi bi-person-check text-danger icon-card"></i>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- AÇÕES RÁPIDAS -->
                <div class="card table-card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Ações Rápidas</h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <div class="col-md-3">
                                <a href="novoproduto.html" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle"></i>
                                    Novo Produto
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="novocliente.html" class="btn btn-success w-100">
                                    <i class="bi bi-person-plus"></i>
                                    Novo Cliente
                                </a>
                            </div>

                            <div class="col-md-3">
                                <a href="relatorios.html" class="btn btn-warning w-100">
                                    <i class="bi bi-file-earmark-text"></i>
                                    Relatórios
                                </a>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modalSair">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Sair do Sistema
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- TABELA -->
                <div class="card table-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="mb-0">Registros Recentes</h5>

                        <input type="text" class="form-control w-auto" placeholder="Pesquisar...">
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Categoria</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Mouse Gamer</td>
                                        <td>Produto</td>
                                        <td>
                                            <span class="badge bg-success">Ativo</span>
                                        </td>
                                        <td>07/07/2026</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalExcluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>Maria Oliveira</td>
                                        <td>Cliente</td>
                                        <td>
                                            <span class="badge bg-success">Ativo</span>
                                        </td>
                                        <td>07/07/2026</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalExcluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>João Admin</td>
                                        <td>Usuário</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">Pendente</span>
                                        </td>
                                        <td>07/07/2026</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#modalExcluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- MODAL PERFIL -->
    <div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="modalPerfilLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalPerfilLabel">
                        <i class="bi bi-person-circle"></i>
                        Perfil do Administrador
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <p><strong>Nome:</strong> Administrador</p>
                    <p><strong>E-mail:</strong> admin@sistema.com</p>
                    <p><strong>Nível:</strong> Acesso total</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Fechar
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL EXCLUIR -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalExcluirLabel">
                        Confirmar Exclusão
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    Tem certeza que deseja excluir este registro?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="button" class="btn btn-danger">
                        Excluir
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL SAIR -->
    <div class="modal fade" id="modalSair" tabindex="-1" aria-labelledby="modalSairLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="modalSairLabel">
                        Sair do Sistema
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    Deseja realmente sair do painel administrativo?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <a href="login.html" class="btn btn-danger">
                        Sair
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>