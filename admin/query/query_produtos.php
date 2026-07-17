<?php
$con = Config::connect();

$dados = [];

$sql = "SELECT id, nome, categoria, preco,status
        FROM produtos
        ORDER BY nome DESC";

        $stmt = $con->query($sql);

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

