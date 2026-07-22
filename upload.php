<?php
// Inclui o seu arquivo de conexão existente
require_once __DIR__ . '/componentes/conexao.php';

$con = config::connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome_digitado = trim($_POST['nome_foto'] ?? '');
    $arquivo = $_FILES['imagem'] ?? null;

    // 1. Validação inicial do upload
    if (!$arquivo || $arquivo['error'] !== UPLOAD_ERR_OK) {
        die("Erro no envio do arquivo. Verifique o tamanho limite do PHP.");
    }

    // 2. Validação rigorosa por tipo MIME e extensão
    $mimeType = mime_content_type($arquivo['tmp_name']);
    $extensaoOriginal = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

    $tiposAceitos = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png'  => ['png']
    ];

    $eValido = false;
    foreach ($tiposAceitos as $mime => $exts) {
        if ($mimeType === $mime && in_array($extensaoOriginal, $exts)) {
            $eValido = true;
            break;
        }
    }

    if (!$eValido) {
        die("Formato inválido! Envie apenas imagens JPG ou PNG.");
    }

    // 3. Cria o recurso de imagem de acordo com a origem
    if ($mimeType === 'image/png') {
        $imgOriginal = imagecreatefrompng($arquivo['tmp_name']);
    } else {
        $imgOriginal = imagecreatefromjpeg($arquivo['tmp_name']);
    }

    if (!$imgOriginal) {
        die("Falha ao processar a imagem fornecida.");
    }

    // 4. Cálculo de redimensionamento proporcional (máx. 1024px)
    $larguraOriginal = imagesx($imgOriginal);
    $alturaOriginal  = imagesy($imgOriginal);
    $limitePX        = 1024;

    if ($larguraOriginal > $limitePX || $alturaOriginal > $limitePX) {
        if ($larguraOriginal >= $alturaOriginal) {
            $novaLargura = $limitePX;
            $novaAltura  = (int) round(($alturaOriginal / $larguraOriginal) * $limitePX);
        } else {
            $novaAltura  = $limitePX;
            $novaLargura = (int) round(($larguraOriginal / $alturaOriginal) * $limitePX);
        }
    } else {
        $novaLargura = $larguraOriginal;
        $novaAltura  = $alturaOriginal;
    }

    // 5. Renderiza a nova imagem redimensionada
    $imgRedimensionada = imagecreatetruecolor($novaLargura, $novaAltura);

    // Preserva canal alpha de transparência caso a imagem original seja PNG
    imagealphablending($imgRedimensionada, false);
    imagesavealpha($imgRedimensionada, true);

    imagecopyresampled(
        $imgRedimensionada, $imgOriginal,
        0, 0, 0, 0,
        $novaLargura, $novaAltura,
        $larguraOriginal, $alturaOriginal
    );

    // 6. Garante a existência do diretório /fotos
    $pastaDestino = __DIR__ . '/fotos/';
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0755, true);
    }

    // Nome físico único para salvar no disco
    $hashArquivo     = uniqid() . '_' . time();
    $nomeArquivoWebp = $hashArquivo . '.webp';
    $caminhoFinal    = $pastaDestino . $nomeArquivoWebp;

    // 7. Compressão adaptativa para WebP (alvo: <= 120KB)
    $qualidade = 85;
    $maxBytes  = 120 * 1024; // 120 Kilobytes

    do {
        imagewebp($imgRedimensionada, $caminhoFinal, $qualidade);
        $tamanhoBytes = filesize($caminhoFinal);
        $qualidade -= 5;
    } while ($tamanhoBytes > $maxBytes && $qualidade >= 10);

    // Desaloca a memória
    imagedestroy($imgOriginal);
    imagedestroy($imgRedimensionada);

    // 8. Gravação no banco de dados usando $con
    try {
        $sql = "INSERT INTO fotos_sistema (nome_foto, pasta, extensao, estatus) 
                VALUES (:nome_foto, :pasta, :extensao, :estatus)";

        $stmt = $con->prepare($sql);

        // Guardamos o nome único gerado no campo `nome_foto`
        $stmt->execute([
            ':nome_foto' => $nomeArquivoWebp,
            ':pasta'     => 1,      // Tipo INT conforme tabela
            ':extensao'  => 'webp', // Formato final em que foi gravado
            ':estatus'   => 1       // Status Ativo
        ]);

        echo "<script>
                alert('Imagem enviada, otimizada para WebP e salva com sucesso!');
                window.location.href = 'index.html';
              </script>";

    } catch (PDOException $e) {
        // Se falhar o banco, remove a imagem gravada para não deixar arquivos órfãos
        if (file_exists($caminhoFinal)) {
            unlink($caminhoFinal);
        }
        die("Erro ao registrar no banco de dados: " . $e->getMessage());
    }
}
?>