<header class="bg-primary text-white py-5 shadow-sm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">
                    
                     Controle de Estoque
                    
                    

                </h1>
                <p class="lead mb-0">
                    Gerencie produtos, categorias e movimentações de estoque de forma
                    rápida, organizada e segura.
                    <?php echo $data; ?>
                    <?php echo $hora; ?>
                    <?php echo databr(); ?>
                    <?php echo horabr();?>
                    <br>
                    <?php
                    
                    echo $enc = encrypt_secure("123456",'e');
                    
                     ?>
                    
                </p>
            </div>

            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <a href="/Produtos" class="btn btn-light btn-lg me-2">
                    Produtos
                </a>
                <a href="/Movimentacoes" class="btn btn-outline-light btn-lg">
                    Movimentações
                </a>
            </div>
            <br>

            <?php
             echo $dec = encrypt_secure($enc,'d');
             ?>




        </div>
    </div>
</header>

<style>
    header {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    }

    header .btn {
        min-width: 160px;
    }

    header .btn:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
</style>