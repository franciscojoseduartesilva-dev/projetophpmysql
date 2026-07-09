<?php require_once dirname(__DIR__) . '/componentes/config.php'; ?>
<?php

if(!empty($_GET['logout']) && $_GET['logout']=="ok") {
    $_SESSION = [];
    session_destroy();
    header('Location:paineladmin.php');
    exit();




}

if(empty($_SESSION['userstatus'])) {
    header('Location:index.php');
    exit();
}
 ?>
 


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            display:flex;
            background:#f4f6f9;
            color:#333;
        }

        /* Menu lateral */
        .sidebar{
            width:240px;
            background:#1f2937;
            color:#fff;
            height:100vh;
            position:fixed;
            padding:20px;
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:30px;
        }

        .sidebar ul{
            list-style:none;
        }

        .sidebar ul li{
            margin:15px 0;
        }

        .sidebar ul li a{
            color:#fff;
            text-decoration:none;
            display:block;
            padding:10px;
            border-radius:8px;
            transition:.3s;
        }

        .sidebar ul li a:hover{
            background:#374151;
        }

        /* Conteúdo */
        .content{
            margin-left:240px;
            width:calc(100% - 240px);
        }

        header{
            background:#fff;
            padding:20px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 2px 5px rgba(0,0,0,.1);
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            padding:25px;
        }

        .card{
            background:#fff;
            border-radius:12px;
            padding:20px;
            box-shadow:0 4px 10px rgba(0,0,0,.08);
        }

        .card h3{
            color:#555;
            margin-bottom:10px;
        }

        .card p{
            font-size:28px;
            font-weight:bold;
            color:#2563eb;
        }

        .table-container{
            padding:25px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:#fff;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 4px 10px rgba(0,0,0,.08);
        }

        th{
            background:#2563eb;
            color:white;
        }

        th,td{
            padding:15px;
            text-align:left;
            border-bottom:1px solid #ddd;
        }

        tr:hover{
            background:#f2f2f2;
        }

        button{
            background:#2563eb;
            color:white;
            border:none;
            padding:8px 14px;
            border-radius:6px;
            cursor:pointer;
        }

        button:hover{
            background:#1d4ed8;
        }

        @media(max-width:768px){
            .sidebar{
                width:70px;
            }

            .sidebar h2{
                font-size:16px;
            }

            .sidebar a{
                font-size:12px;
            }

            .content{
                margin-left:70px;
                width:calc(100% - 70px);
            }
        }
    </style>

      <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Deseja  sair dessa sessão
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="?logout=ok" class="btn btn-primary">confirmar</a>
      </div>
    </div>
  </div>
</div>



    <aside class="sidebar">
        <h2>Admin</h2>

        <ul>
            <li><a href="#">🏠 Dashboard</a></li>
            <li><a href="#">👥 Usuários</a></li>
            <li><a href="#">📦 Produtos</a></li>
            <li><a href="#">🛒 Pedidos</a></li>
            <li><a href="#">⚙ Configurações</a></li>
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">🚪 Sair</a></li>
        </ul>
    </aside>

    <main class="content">

        <header>
            <h1>Painel Administrativo</h1>
            <span>Administrador</span>
        </header>

        <section class="cards">

            <div class="card">
                <h3>Usuários</h3>
                <p>1.245</p>
            </div>

            <div class="card">
                <h3>Pedidos</h3>
                <p>328</p>
            </div>

            <div class="card">
                <h3>Produtos</h3>
                <p>587</p>
            </div>

            <div class="card">
                <h3>Faturamento</h3>
                <p>R$ 58.900</p>
            </div>

        </section>

        <section class="table-container">

            <h2 style="margin-bottom:15px;">Últimos Usuários</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td>João Silva</td>
                        <td>joao@email.com</td>
                        <td>Ativo</td>
                        <td><button>Editar</button></td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Maria Souza</td>
                        <td>maria@email.com</td>
                        <td>Ativo</td>
                        <td><button>Editar</button></td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Carlos Lima</td>
                        <td>carlos@email.com</td>
                        <td>Bloqueado</td>
                        <td><button>Editar</button></td>
                    </tr>

                </tbody>
            </table>

        </section>

    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>