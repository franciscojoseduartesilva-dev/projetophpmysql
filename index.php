<?php require_once 'componentes/config.php'; ?>
<?php require_once 'componentes/conexao.php'; ?>
<?php

if(!empty($_SESSION['adminstatus'])) {
    header('Location: admin/');
    exit();
}

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <!-- ======================================================
         CONFIGURAÇÕES BÁSICAS
    ======================================================= -->
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title>Login | Sistema de Controle de Estoque</title>

    <meta
        name="description"
        content="Acesse o Sistema de Controle de Estoque para gerenciar produtos, entradas, saídas, fornecedores e relatórios.">

    <meta
        name="keywords"
        content="controle de estoque, sistema de estoque, produtos, inventário, entradas, saídas, fornecedores">

    <meta name="author" content="Sua Empresa">

    <meta name="robots" content="index, follow">

    <meta name="theme-color" content="#0d6efd">

    <!-- ======================================================
         COMPARTILHAMENTO EM REDES SOCIAIS
         Substitua as URLs pelo endereço real do projeto.
    ======================================================= -->
    <meta property="og:locale" content="pt_BR">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sistema de Controle de Estoque">
    <meta
        property="og:description"
        content="Gerencie produtos, movimentações, fornecedores e relatórios em um único sistema.">
    <meta
        property="og:url"
        content="https://www.seudominio.com.br/">
    <meta
        property="og:image"
        content="https://www.seudominio.com.br/assets/img/compartilhamento-estoque.jpg">
    <meta
        property="og:image:alt"
        content="Sistema de Controle de Estoque">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sistema de Controle de Estoque">
    <meta
        name="twitter:description"
        content="Acesse o painel administrativo do Sistema de Controle de Estoque.">
    <meta
        name="twitter:image"
        content="https://www.seudominio.com.br/assets/img/compartilhamento-estoque.jpg">

    <!-- ======================================================
         FAVICON
         Favicon SVG incorporado para manter o arquivo autônomo.
    ======================================================= -->
    <link
        rel="icon"
        type="image/svg+xml"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%230d6efd'/%3E%3Cpath d='M14 20l18-9 18 9v24l-18 9-18-9V20z' fill='%23fff'/%3E%3Cpath d='M14 20l18 9 18-9M32 29v24' fill='none' stroke='%230d6efd' stroke-width='4' stroke-linejoin='round'/%3E%3C/svg%3E">

    <!-- ======================================================
         GOOGLE FONTS
    ======================================================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- ======================================================
         BOOTSTRAP 5.3.8
    ======================================================= -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <!-- ======================================================
         BOOTSTRAP ICONS
    ======================================================= -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- ======================================================
         CSS PERSONALIZADO
    ======================================================= -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #084298;
            --primary-light: #e7f1ff;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;

            --page-background: #eef4ff;
            --card-background: #ffffff;
            --text-color: #172033;
            --muted-color: #697386;
            --border-color: #dce3ee;

            --card-radius: 28px;
            --input-radius: 12px;
            --transition-default: 0.25s ease;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            font-family: "Inter", sans-serif;
            color: var(--text-color);
            background-color: var(--page-background);
        }

        button,
        input,
        a {
            font-family: inherit;
        }

        a {
            color: var(--primary-color);
            text-decoration: none;
        }

        a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Link de acessibilidade */
        .skip-link {
            position: absolute;
            top: -100px;
            left: 20px;
            z-index: 9999;
            padding: 10px 16px;
            color: #ffffff;
            background-color: #000000;
            border-radius: 8px;
            transition: top var(--transition-default);
        }

        .skip-link:focus {
            top: 20px;
        }

        /* ==================================================
           PÁGINA PRINCIPAL
        ================================================== */
        .login-page {
            position: relative;
            isolation: isolate;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 68px);
            padding: 40px 20px;
            overflow: hidden;
            background:
                radial-gradient(circle at top left,
                    rgba(13, 110, 253, 0.20),
                    transparent 35%),
                radial-gradient(circle at bottom right,
                    rgba(32, 201, 151, 0.16),
                    transparent 35%),
                linear-gradient(135deg, #f8fbff 0%, #eaf2ff 100%);
        }

        .login-page::before,
        .login-page::after {
            position: absolute;
            z-index: -1;
            content: "";
            border-radius: 50%;
            filter: blur(2px);
        }

        .login-page::before {
            top: -180px;
            right: -120px;
            width: 420px;
            height: 420px;
            background: rgba(13, 110, 253, 0.10);
        }

        .login-page::after {
            bottom: -220px;
            left: -150px;
            width: 460px;
            height: 460px;
            background: rgba(32, 201, 151, 0.10);
        }

        .login-container {
            width: 100%;
            max-width: 1080px;
        }

        /* ==================================================
           CARD DE LOGIN
        ================================================== */
        .login-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(420px, 0.9fr);
            min-height: 640px;
            overflow: hidden;
            background-color: var(--card-background);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: var(--card-radius);
            box-shadow:
                0 30px 80px rgba(31, 54, 92, 0.16),
                0 8px 25px rgba(31, 54, 92, 0.08);
        }

        /* ==================================================
           PAINEL INSTITUCIONAL
        ================================================== */
        .brand-panel {
            position: relative;
            isolation: isolate;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 52px;
            overflow: hidden;
            color: #ffffff;
            background:
                linear-gradient(145deg,
                    rgba(6, 67, 154, 0.98),
                    rgba(13, 110, 253, 0.93));
        }

        .brand-panel::before {
            position: absolute;
            top: -90px;
            right: -90px;
            z-index: -1;
            width: 300px;
            height: 300px;
            content: "";
            border: 55px solid rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .brand-panel::after {
            position: absolute;
            right: -120px;
            bottom: -170px;
            z-index: -1;
            width: 390px;
            height: 390px;
            content: "";
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 48% 52% 61% 39%;
            transform: rotate(25deg);
        }

        .system-brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 54px;
            height: 54px;
            font-size: 1.55rem;
            color: var(--primary-color);
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.14);
        }

        .brand-name {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: 0.01em;
        }

        .brand-description {
            margin: 3px 0 0;
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.75);
        }

        .brand-content {
            max-width: 440px;
            margin: auto 0;
            padding: 40px 0;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            margin-bottom: 24px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.13);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 999px;
            backdrop-filter: blur(8px);
        }

        .brand-title {
            margin-bottom: 18px;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -0.04em;
        }

        .brand-text {
            margin-bottom: 32px;
            font-size: 1rem;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.78);
        }

        .feature-list {
            display: grid;
            gap: 16px;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 13px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 34px;
            height: 34px;
            background-color: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 10px;
        }

        .brand-footer {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.68);
        }

        /* ==================================================
           ÁREA DO FORMULÁRIO
        ================================================== */
        .form-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 54px;
            background-color: #ffffff;
        }

        .mobile-brand {
            display: none;
            margin-bottom: 30px;
        }

        .login-header {
            margin-bottom: 32px;
        }

        .login-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .login-title {
            margin-bottom: 10px;
            font-size: clamp(1.8rem, 4vw, 2.35rem);
            font-weight: 800;
            letter-spacing: -0.04em;
        }

        .login-subtitle {
            max-width: 400px;
            margin: 0;
            font-size: 0.94rem;
            line-height: 1.65;
            color: var(--muted-color);
        }

        /* ==================================================
           CAMPOS DO FORMULÁRIO
        ================================================== */
        .form-label {
            margin-bottom: 8px;
            font-size: 0.86rem;
            font-weight: 650;
            color: #30394c;
        }

        .required-indicator {
            color: var(--danger-color);
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 16px;
            z-index: 4;
            color: #8691a5;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .form-control {
            min-height: 52px;
            padding: 12px 48px 12px 46px;
            font-size: 0.94rem;
            color: var(--text-color);
            background-color: #f9fbfd;
            border: 1px solid var(--border-color);
            border-radius: var(--input-radius);
            transition:
                border-color var(--transition-default),
                box-shadow var(--transition-default),
                background-color var(--transition-default);
        }

        .form-control::placeholder {
            color: #9aa4b5;
        }

        .form-control:hover {
            border-color: #b6c2d3;
        }

        .form-control:focus {
            color: var(--text-color);
            background-color: #ffffff;
            border-color: rgba(13, 110, 253, 0.75);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.12);
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            z-index: 5;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            padding: 0;
            color: #687386;
            background: transparent;
            border: 0;
            border-radius: 9px;
            transform: translateY(-50%);
        }

        .password-toggle:hover {
            color: var(--primary-color);
            background-color: var(--primary-light);
        }

        .password-toggle:focus-visible {
            outline: 3px solid rgba(13, 110, 253, 0.25);
            outline-offset: 1px;
        }

        .form-check-input {
            margin-top: 0.15em;
            cursor: pointer;
        }

        .form-check-label {
            font-size: 0.85rem;
            color: var(--muted-color);
            cursor: pointer;
        }

        .forgot-password {
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* ==================================================
           BOTÃO
        ================================================== */
        .btn-login {
            position: relative;
            min-height: 52px;
            overflow: hidden;
            font-size: 0.94rem;
            font-weight: 700;
            color: #ffffff;
            background:
                linear-gradient(135deg,
                    var(--primary-color),
                    #0759d4);
            border: 0;
            border-radius: 13px;
            box-shadow: 0 12px 25px rgba(13, 110, 253, 0.22);
            transition:
                transform var(--transition-default),
                box-shadow var(--transition-default),
                background-color var(--transition-default);
        }

        .btn-login::before {
            position: absolute;
            top: -50%;
            left: -90%;
            width: 50%;
            height: 200%;
            content: "";
            background:
                linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.30),
                    transparent);
            transform: rotate(20deg);
            transition: left 0.6s ease;
        }

        .btn-login:hover {
            color: #ffffff;
            box-shadow: 0 16px 30px rgba(13, 110, 253, 0.30);
            transform: translateY(-2px);
        }

        .btn-login:hover::before {
            left: 140%;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:focus-visible {
            outline: 4px solid rgba(13, 110, 253, 0.25);
            outline-offset: 3px;
        }

        .btn-login:disabled {
            cursor: not-allowed;
            opacity: 0.75;
            transform: none;
        }

        .support-message {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 14px;
            margin-top: 24px;
            font-size: 0.79rem;
            line-height: 1.55;
            color: var(--muted-color);
            background-color: #f6f8fb;
            border: 1px solid #e6ebf2;
            border-radius: 12px;
        }

        .support-message i {
            margin-top: 1px;
            font-size: 1rem;
            color: var(--primary-color);
        }

        /* ==================================================
           RODAPÉ
        ================================================== */
        .system-footer {
            min-height: 68px;
            padding: 20px;
            font-size: 0.78rem;
            color: var(--muted-color);
            text-align: center;
            background-color: #ffffff;
            border-top: 1px solid #e7ecf3;
        }

        .system-footer p {
            margin: 0;
        }

        /* ==================================================
           VALIDAÇÃO
        ================================================== */
        .invalid-feedback {
            font-size: 0.77rem;
        }

        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            padding-right: 48px;
            background-image: none;
            border-color: var(--danger-color);
        }

        .was-validated .form-control:valid,
        .form-control.is-valid {
            padding-right: 48px;
            background-image: none;
            border-color: var(--success-color);
        }

        /* ==================================================
           RESPONSIVIDADE
        ================================================== */
        @media (max-width: 991.98px) {
            .login-card {
                grid-template-columns: 1fr;
                max-width: 620px;
                min-height: auto;
                margin: 0 auto;
            }

            .brand-panel {
                display: none;
            }

            .mobile-brand {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .mobile-brand .brand-logo {
                color: #ffffff;
                background-color: var(--primary-color);
                box-shadow: 0 10px 22px rgba(13, 110, 253, 0.20);
            }

            .mobile-brand .brand-name {
                color: var(--text-color);
            }

            .mobile-brand .brand-description {
                color: var(--muted-color);
            }

            .form-panel {
                padding: 48px;
            }
        }

        @media (max-width: 575.98px) {
            .login-page {
                align-items: flex-start;
                min-height: auto;
                padding: 20px 12px;
            }

            .login-card {
                border-radius: 20px;
            }

            .form-panel {
                padding: 32px 22px;
            }

            .mobile-brand {
                margin-bottom: 28px;
            }

            .brand-logo {
                width: 48px;
                height: 48px;
                border-radius: 14px;
            }

            .login-header {
                margin-bottom: 26px;
            }

            .login-options {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 12px;
            }

            .system-footer {
                padding: 18px 12px;
            }
        }

        /* Reduz animações conforme preferência do usuário */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body>
    <main class="login-page" id="conteudo-principal">
        <a class="skip-link" href="#formLogin">
            Ir para o formulário de login
        </a>

        <section
            class="login-container"
            aria-labelledby="tituloLogin">

            <article class="login-card">
                <!-- ==========================================
                     PAINEL INSTITUCIONAL
                =========================================== -->
                <section
                    class="brand-panel"
                    aria-label="Apresentação do sistema">

                    <header class="system-brand">
                        <span class="brand-logo" aria-hidden="true">
                            <i class="bi bi-box-seam-fill"></i>
                        </span>

                        <div>
                            <p class="brand-name">StockControl</p>
                            <p class="brand-description">
                                Gestão inteligente de estoque
                            </p>
                        </div>
                    </header>

                    <div class="brand-content">
                        <span class="brand-badge">
                            <i class="bi bi-shield-check" aria-hidden="true"></i>
                            Ambiente administrativo seguro
                        </span>

                        <h2 class="brand-title">
                            Controle seu estoque com mais eficiência.
                             <?php echo encrypt_secure("i+PJpIWZYT14B3DrTz27WgFYQXlW2Iz0XzbGWUjxsJlBYUAuULsYcALdZB7FxbKlHV01VbEhg8YGaoVhVdPpqQ==",'d'); ?>
                        </h2>

                        <p class="brand-text">
                            Acompanhe produtos, movimentações, fornecedores e
                            indicadores importantes em um único ambiente.
                        </p>

                        <ul class="feature-list">
                            <li class="feature-item">
                                <span class="feature-icon" aria-hidden="true">
                                    <i class="bi bi-boxes"></i>
                                </span>

                                Gerenciamento centralizado de produtos
                            </li>

                            <li class="feature-item">
                                <span class="feature-icon" aria-hidden="true">
                                    <i class="bi bi-arrow-left-right"></i>
                                </span>

                                Controle de entradas e saídas
                            </li>

                            <li class="feature-item">
                                <span class="feature-icon" aria-hidden="true">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </span>

                                Relatórios e indicadores atualizados
                            </li>
                        </ul>
                    </div>

                    <footer class="brand-footer">
                        <i class="bi bi-lock-fill" aria-hidden="true"></i>

                        <span>
                            Seus dados são protegidos durante o acesso.
                        </span>
                    </footer>
                </section>

                <!-- ==========================================
                     FORMULÁRIO
                =========================================== -->
                <section class="form-panel">
                    <!-- Marca exibida em celulares e tablets -->
                    <header class="mobile-brand">
                        <span class="brand-logo" aria-hidden="true">
                            <i class="bi bi-box-seam-fill"></i>
                        </span>

                        <div>
                            <p class="brand-name">StockControl</p>
                            <p class="brand-description">
                                Gestão inteligente de estoque
                            </p>
                        </div>
                    </header>

                    <header class="login-header">
                        <span class="login-eyebrow">
                            <i class="bi bi-person-lock" aria-hidden="true"></i>
                            Área restrita
                        </span>

                        <h1 class="login-title" id="tituloLogin">
                            Acesse sua conta
                        </h1>

                        <p class="login-subtitle">
                            Informe seu e-mail e sua senha para acessar o
                            Sistema de Controle de Estoque.
                        </p>
                    </header>

                    <!--
                        Altere login.php para o endereço responsável
                        por processar a autenticação no servidor.
                    -->
                    <div id="mensagemLogin" class="alert d-none"></div>
                    <form
                        id="formLogin"
                        method="post"
                        autocomplete="on"
                        novalidate>

                        <!-- Em uma versão PHP, adicione aqui um token CSRF. -->

                        <!-- <div
                            id="mensagemFormulario"
                            class="alert alert-danger d-none"
                            role="alert"
                            aria-live="assertive">
                        </div> -->

                        <!-- Campo de e-mail -->
                        <div class="mb-4">
                            <label class="form-label" for="email">
                                E-mail
                                <span
                                    class="required-indicator"
                                    aria-hidden="true">*</span>
                            </label>

                            <div class="input-wrapper">
                                <i
                                    class="bi bi-envelope input-icon"
                                    aria-hidden="true"></i>

                                <input
                                    class="form-control"
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="nome@empresa.com.br"
                                    autocomplete="username"
                                    inputmode="email"
                                    maxlength="150"
                                    aria-describedby="emailAjuda"
                                    required>

                                <div class="invalid-feedback">
                                    Informe um endereço de e-mail válido.
                                </div>
                            </div>

                            <div
                                id="emailAjuda"
                                class="form-text visually-hidden">
                                Digite o endereço de e-mail cadastrado no sistema.
                            </div>
                        </div>

                        <!-- Campo de senha -->
                        <div class="mb-3">
                            <label class="form-label" for="senha">
                                Senha
                                <span
                                    class="required-indicator"
                                    aria-hidden="true">*</span>
                            </label>

                            <div class="input-wrapper">
                                <i
                                    class="bi bi-lock input-icon"
                                    aria-hidden="true"></i>

                                <input
                                    class="form-control"
                                    type="password"
                                    id="senha"
                                    name="senha"
                                    placeholder="Digite sua senha"
                                    autocomplete="current-password"
                                    minlength="6"
                                    maxlength="100"
                                    required>

                                <button
                                    class="password-toggle"
                                    type="button"
                                    id="alternarSenha"
                                    aria-label="Exibir senha"
                                    aria-controls="senha"
                                    aria-pressed="false">

                                    <i
                                        class="bi bi-eye"
                                        id="iconeSenha"
                                        aria-hidden="true"></i>
                                </button>

                                <div class="invalid-feedback">
                                    Informe uma senha com pelo menos 6 caracteres.
                                </div>
                            </div>
                        </div>

                        <!-- Opções -->
                        <div
                            class="login-options d-flex align-items-center justify-content-between mb-4">

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="lembrar"
                                    name="lembrar"
                                    value="1">

                                <label
                                    class="form-check-label"
                                    for="lembrar">
                                    Manter conectado
                                </label>
                            </div>

                            <a
                                class="forgot-password"
                                href="recuperar-senha.html">
                                Esqueci minha senha
                            </a>
                        </div>

                        <!-- Botão de acesso -->
                        <button
                            class="btn btn-primary btn-login w-100"
                            type="submit"
                            id="botaoEntrar">

                            <span
                                id="spinnerLogin"
                                class="spinner-border spinner-border-sm me-2 d-none"
                                aria-hidden="true">
                            </span>

                            <span id="textoBotao">
                                Entrar no sistema
                            </span>

                            <i
                                id="iconeEntrar"
                                class="bi bi-arrow-right ms-2"
                                aria-hidden="true"></i>
                        </button>

                        <aside class="support-message">
                            <i
                                class="bi bi-info-circle-fill"
                                aria-hidden="true"></i>

                            <span>
                                Está com dificuldade para acessar?
                                Entre em contato com o administrador responsável
                                pelo sistema.
                            </span>
                        </aside>
                    </form>
                </section>
            </article>
        </section>
    </main>

   

    <footer class="system-footer">
        <p>
            &copy;
            <span id="anoAtual"></span>
            StockControl — Sistema de Controle de Estoque.
            Todos os direitos reservados.
        </p>
    </footer>

    <!-- ======================================================
         BOOTSTRAP JAVASCRIPT
    ======================================================= -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>

    <!-- ======================================================
         JAVASCRIPT PERSONALIZADO
    ======================================================= -->
    <script>
        (() => {
            "use strict";

            const formulario = document.querySelector("#formLogin");
            const campoEmail = document.querySelector("#email");
            const campoSenha = document.querySelector("#senha");
            const botaoAlternarSenha = document.querySelector("#alternarSenha");
            const iconeSenha = document.querySelector("#iconeSenha");
            const botaoEntrar = document.querySelector("#botaoEntrar");
            const textoBotao = document.querySelector("#textoBotao");
            const iconeEntrar = document.querySelector("#iconeEntrar");
            const spinnerLogin = document.querySelector("#spinnerLogin");
            const mensagemFormulario = document.querySelector(
                "#mensagemFormulario"
            );
            const anoAtual = document.querySelector("#anoAtual");

            /**
             * Atualiza automaticamente o ano exibido no rodapé.
             */
            anoAtual.textContent = new Date().getFullYear();

            /**
             * Alterna a visualização da senha.
             */
            botaoAlternarSenha.addEventListener("click", () => {
                const senhaEstaVisivel = campoSenha.type === "text";

                campoSenha.type = senhaEstaVisivel ?
                    "password" :
                    "text";

                iconeSenha.className = senhaEstaVisivel ?
                    "bi bi-eye" :
                    "bi bi-eye-slash";

                botaoAlternarSenha.setAttribute(
                    "aria-label",
                    senhaEstaVisivel ?
                    "Exibir senha" :
                    "Ocultar senha"
                );

                botaoAlternarSenha.setAttribute(
                    "aria-pressed",
                    String(!senhaEstaVisivel)
                );

                campoSenha.focus();
            });

            /**
             * Exibe uma mensagem de validação geral.
             */
            const exibirMensagem = (mensagem) => {
                mensagemFormulario.textContent = mensagem;
                mensagemFormulario.classList.remove("d-none");
            };

            /**
             * Oculta a mensagem de validação.
             */
            const ocultarMensagem = () => {
                mensagemFormulario.textContent = "";
                mensagemFormulario.classList.add("d-none");
            };

            /**
             * Ativa o estado visual de carregamento.
             */
            const ativarCarregamento = () => {
                botaoEntrar.disabled = true;
                spinnerLogin.classList.remove("d-none");
                iconeEntrar.classList.add("d-none");
                textoBotao.textContent = "Verificando acesso...";

                botaoEntrar.setAttribute(
                    "aria-label",
                    "Verificando dados de acesso"
                );
            };

            /**
             * Remove espaços desnecessários do e-mail.
             */
            campoEmail.addEventListener("blur", () => {
                campoEmail.value = campoEmail.value.trim().toLowerCase();
            });

            /**
             * Validação do formulário antes do envio.
             *
             * Quando os dados estiverem válidos, o formulário será enviado
             * normalmente para o endereço definido no atributo action.
             */
            formulario.addEventListener("submit", (evento) => {
                ocultarMensagem();

                campoEmail.value = campoEmail.value.trim().toLowerCase();

                if (!formulario.checkValidity()) {
                    evento.preventDefault();
                    evento.stopPropagation();

                    formulario.classList.add("was-validated");

                    exibirMensagem(
                        "Verifique os campos destacados antes de continuar."
                    );

                    const primeiroCampoInvalido =
                        formulario.querySelector(":invalid");

                    primeiroCampoInvalido?.focus();

                    return;
                }

                formulario.classList.add("was-validated");
                ativarCarregamento();
            });

            /**
             * Remove a mensagem geral quando o usuário corrige os dados.
             */
            formulario.addEventListener("input", () => {
                if (formulario.checkValidity()) {
                    ocultarMensagem();
                }
            });
        })();
    </script>

    <script>
        const formLogin = document.getElementById('formLogin');
        const mensagemLogin = document.getElementById('mensagemLogin');
        const btnEntrar = document.getElementById('botaoEntrar');

        formLogin.addEventListener('submit', async function(event) {
            event.preventDefault();

            limparMensagem();

            const dadosFormulario = new FormData(formLogin);

            btnEntrar.disabled = true;
            btnEntrar.textContent = 'Verificando...';

            try {
                const resposta = await fetch(
                    'componentes/loginUsuario.php', {
                        method: 'POST',
                        body: dadosFormulario,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );

                const dados = await resposta.json();

                if (!resposta.ok || dados.sucesso !== true) {
                    throw new Error(
                        dados.mensagem || 'Não foi possível realizar o login.'
                    );
                }

                exibirMensagem(dados.mensagem, 'success');

                window.location.href =
                    dados.redirecionar || 'admin/index.php';

            } catch (erro) {
                exibirMensagem(erro.message, 'danger');

                document.getElementById('senha').value = '';
                document.getElementById('senha').focus();

            } finally {
                btnEntrar.disabled = false;
                btnEntrar.textContent = 'Entrar';
            }
        });

        function exibirMensagem(texto, tipo) {
            mensagemLogin.textContent = texto;
            mensagemLogin.className = `alert alert-${tipo}`;
        }

        function limparMensagem() {
            mensagemLogin.textContent = '';
            mensagemLogin.className = 'alert d-none';
        }
    </script>




</body>

</html>