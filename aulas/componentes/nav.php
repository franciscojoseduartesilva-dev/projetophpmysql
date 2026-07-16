<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <!-- Nome do projeto à esquerda -->
            <a class="navbar-brand fw-bold" href="../../">
                Controle de Estoque*
            </a>

            <!-- Botão do menu mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
                aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links à direita -->
            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <!-- Dropdown Produtos -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="produtosDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Aulas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="produtosDropdown">
                            <li><a class="dropdown-item" href="../aula01_variaveis/">Aula 1 - Variáveis</a></li>
                            <li><a class="dropdown-item" href="../aula02/">Aula 2 - Operadores</a></li>
                            <li><a class="dropdown-item" href="../aula03/">Aula 3 - Rotas</a></li>
                            <li><a class="dropdown-item" href="../aula04/">Aula 4 - Condicional if</a></li>
                            <li><a class="dropdown-item" href="../aula05/">Aula 5 - For While </a></li>
                            <li><a class="dropdown-item" href="../aula06/">Aula 6 - Array</a></li>
                            <li><a class="dropdown-item" href="../aula07/">Aula 7 - Config</a></li>
                            <li><a class="dropdown-item" href="../aula08/">Aula 8 - $_SESSION</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Clientes -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="clientesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Clientes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="clientesDropdown">
                            <li><a class="dropdown-item" href="#">Listar Clientes</a></li>
                            <li><a class="dropdown-item" href="#">Cadastrar Cliente</a></li>
                            <li><a class="dropdown-item" href="#">Histórico de Compras</a></li>
                        </ul>
                    </li>

                    <!-- Dropdown Relatórios -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="relatoriosDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Relatórios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="relatoriosDropdown">
                            <li><a class="dropdown-item" href="#">Estoque Atual</a></li>
                            <li><a class="dropdown-item" href="#">Produtos em Falta</a></li>
                            <li><a class="dropdown-item" href="#">Movimentações</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>