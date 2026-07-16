<header>
            <div class="d-flex align-items-center">
                <button class="btn btn-light me-3" id="toggleSidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <form class="d-none d-md-flex position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control rounded-pill ps-5 bg-body-tertiary border-0" placeholder="Pesquisar...">
                </form>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link text-body position-relative">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">3</span>
                </button>
                <button class="btn btn-link text-body">
                    <i class="bi bi-envelope fs-5"></i>
                </button>
                <button class="btn btn-link text-body" id="themeSwitcher">
                    <i class="bi bi-moon fs-5"></i>
                </button>

                <div class="dropdown ms-2">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-body" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Admin" width="32" height="32" class="rounded-circle me-2">
                        <span class="d-none d-md-inline fw-medium">João Silva</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Meu perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Configurações</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </header>