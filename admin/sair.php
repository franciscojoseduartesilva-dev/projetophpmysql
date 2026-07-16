<?php

require_once __DIR__ . '/componentes/config.php';
require_once __DIR__ . '/componentes/rotas.php';
require_once __DIR__ . '/componentes/conexao.php';

/*
|--------------------------------------------------------------------------
| Processamento do logout
|--------------------------------------------------------------------------
| O logout somente será realizado quando o usuário clicar em "OK, sair".
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_logout'])) {

    // Remove todas as variáveis armazenadas na sessão
    $_SESSION = [];

    // Remove o cookie da sessão, quando estiver sendo utilizado
    if (ini_get('session.use_cookies')) {
        $parametrosCookie = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $parametrosCookie['path'],
            $parametrosCookie['domain'],
            $parametrosCookie['secure'],
            $parametrosCookie['httponly']
        );
    }

    // Encerra definitivamente a sessão
    session_destroy();

    // Redireciona para a página de login
    header('Location: ../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sair - Sistema de Controle de Estoque</title>

    <meta
        name="description"
        content="Confirmação para sair do Sistema de Controle de Estoque."
    >

    <link
        rel="shortcut icon"
        href="https://cdn-icons-png.flaticon.com/512/2875/2875878.png"
        type="image/x-icon"
    >

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    >

    <!-- CSS do projeto -->
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <?php require_once APP_COMPONENTES . '/sibebar.php'; ?>

    <section class="dashboard-wrapper" id="mainWrapper">

        <?php require_once APP_COMPONENTES . '/header.php'; ?>

        <main class="p-4 flex-grow-1">

            <!-- Cabeçalho da página -->
            <div class="mb-4">

                <h2 class="fw-bold mb-1">
                    Sair do sistema
                </h2>

                <p class="text-muted mb-2">
                    Confirme se deseja encerrar sua sessão.
                </p>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">

                        <li class="breadcrumb-item">
                            <a
                                href="index.php"
                                class="text-decoration-none"
                            >
                                Home
                            </a>
                        </li>

                        <li
                            class="breadcrumb-item active"
                            aria-current="page"
                        >
                            Sair
                        </li>

                    </ol>
                </nav>

            </div>

            <!-- Confirmação do logout -->
            <div class="row justify-content-center">

                <div class="col-12 col-md-8 col-lg-6">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body p-4 p-md-5 text-center">

                            <div class="mb-4">

                                <i
                                    class="bi bi-box-arrow-right text-danger"
                                    style="font-size: 4rem;"
                                ></i>

                            </div>

                            <h3 class="fw-bold mb-3">
                                Deseja realmente sair?
                            </h3>

                            <p class="text-muted mb-4">
                                Ao confirmar, sua sessão será encerrada e você
                                será redirecionado para a página de login.
                            </p>

                            <form method="POST" action="">

                                <div
                                    class="d-flex flex-column flex-sm-row justify-content-center gap-3"
                                >

                                    <!-- Confirmar logout -->
                                    <button
                                        type="submit"
                                        name="confirmar_logout"
                                        value="1"
                                        class="btn btn-danger px-4"
                                    >
                                        <i class="bi bi-check-lg me-1"></i>
                                        OK, sair
                                    </button>

                                    <!-- Cancelar logout -->
                                    <a
                                        href="index.php"
                                        class="btn btn-outline-secondary px-4"
                                    >
                                        <i class="bi bi-x-lg me-1"></i>
                                        Cancelar
                                    </a>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </main>

        <?php require_once APP_COMPONENTES . '/footer.php'; ?>

    </section>

    <!-- Bootstrap JavaScript -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    ></script>

    <!-- JavaScript do projeto -->
    <script src="assets/script.js"></script>

</body>

</html>