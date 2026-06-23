<?php

$data = date("d-m-Y");
$hora = date("H:i:s");

echo $data . " " . $hora;

?>

<br>

<?php

$valor = 10;

if ($valor > 10):

    echo "Numero e maior do que 10";


else:
    echo "Não é maior que 10";

endif;




?>
<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS v5.3.8 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous" />
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mouse</td>
                        <td>25</td>
                    </tr>
                    <tr>
                        <td>Teclado</td>
                        <td>18</td>
                    </tr>
                    <tr>
                        <td>Monitor</td>
                        <td>12</td>
                    </tr>
                    <tr>
                        <td>Notebook</td>
                        <td>8</td>
                    </tr>
                    <tr>
                        <td>Impressora</td>
                        <td>5</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Bundle (includes Popper) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>