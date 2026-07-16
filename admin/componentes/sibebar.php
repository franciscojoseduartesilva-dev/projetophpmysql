<?php
$nav="0";
if(!empty($_GET['nav'])) {
    $nav = $_GET['nav'];
}
?>

<aside id="sidebar" class="d-flex flex-column">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <h4 class="m-0 fw-bold text-primary"><i class="bi bi-box-seam me-2"></i>EstoquePRO</h4>
            <button class="btn btn-sm btn-link d-md-none text-body" id="closeSidebar">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="user-profile p-3 text-center border-bottom">
            <img src="https://i.pravatar.cc/150?img=11" alt="Foto do Administrador" class="rounded-circle mb-2 border border-2 border-primary">
            <h6 class="mb-0 fw-bold">João Silva</h6>
            <span class="badge bg-secondary mt-1">Administrador</span>
        </div>

        <nav class="flex-grow-1 overflow-auto py-3">
            <ul class="nav flex-column gap-1">
                <li class="nav-item">
                    <a href="./?nav=0" class="nav-link <?= $nav==0?'active':''; ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $nav==1?'active':''; ?>" href="#submenuProdutos" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <i class="bi bi-box"></i> Produtos <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                    </a>
                    <div class="collapse submenu" id="submenuProdutos">
                        <ul class="nav flex-column">
                            <li><a href="produtos.php?nav=1" class="nav-link ">Listar produtos</a></li>
                            <li><a href="produtos_cadastro.php?nav=1" class="nav-link">Novo produto</a></li>
                            <li><a href="estoque.php?nav=1" class="nav-link">Estoque </a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $nav==2?'active':''; ?>" href="#submenuCategorias" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <i class="bi bi-box"></i> Categorias <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                    </a>
                    <div class="collapse submenu" id="submenuCategorias">
                        <ul class="nav flex-column">
                            <li><a href="categorias.php?nav=2" class="nav-link">Listar</a></li>
                            <li><a href="categorias_cadastro.php?nav=2" class="nav-link">Nova Categoria</a></li>                            
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $nav==3?'active':''; ?>" href="#submenuEstoque" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <i class="bi bi-layers"></i> Estoque <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                    </a>
                    <div class="collapse submenu" id="submenuEstoque">
                        <ul class="nav flex-column">
                            <li><a href="estoque.php?nav=3" class="nav-link">Movimentações</a></li>
                            <li><a href="estoque_entrada.php?nav=3" class="nav-link">Entrada de estoque</a></li>
                            <li><a href="estoque_saida.php?nav=3" class="nav-link">Saída de estoque</a></li>
                           
                        </ul>
                    </div>
                </li>

                
                <li class="nav-item "><a href="fornecedores.php?nav=4" class="nav-link <?= $nav==4?'active':''; ?>"><i class="bi bi-truck"></i> Fornecedores</a></li>
                <li class="nav-item" ><a href="clientes.php?nav=5" class="nav-link <?= $nav==5?'active':''; ?>"><i class="bi bi-people"></i> Clientes</a></li>
                

                <!-- <li class="nav-item">
                    <a class="nav-link" href="#submenuRelatorios" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <i class="bi bi-bar-chart"></i> Relatórios <i class="bi bi-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                    </a>
                    <div class="collapse submenu" id="submenuRelatorios">
                        <ul class="nav flex-column">
                            <li><a href="#" class="nav-link">Gerais</a></li>
                            <li><a href="#" class="nav-link">Financeiros</a></li>
                        </ul>
                    </div>
                </li> -->

                <li class="nav-item"><a href="admin.php" class="nav-link"><i class="bi bi-person-gear"></i> Usuários</a></li>
                <li class="nav-item"><a href="configuracoes.php" class="nav-link"><i class="bi bi-gear"></i> Configurações</a></li>
                <li class="nav-item mt-4"><a href="sair.php" class="nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Sair</a></li>
            </ul>
        </nav>
    </aside>