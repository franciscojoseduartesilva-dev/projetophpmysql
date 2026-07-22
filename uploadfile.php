<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Fotos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0">Enviar Nova Imagem</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        
                        <!-- Nome da Imagem -->
                        <div class="mb-3">
                            <label for="nome_foto" class="form-label font-weight-bold">Nome da Imagem</label>
                            <input type="text" class="form-control" id="nome_foto" name="nome_foto" maxlength="50" required placeholder="Ex: Banner Principal">
                        </div>

                        <!-- Seleção do Arquivo -->
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Arquivo (JPG ou PNG)</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/jpeg, image/png" required onchange="previewImage(event)">
                            <div class="form-text">Redimensionamento automático para 1024px e conversão para WebP (máx. 120KB).</div>
                        </div>

                        <!-- Pré-visualização -->
                        <div class="mb-3 text-center d-none" id="preview-container">
                            <img id="image-preview" src="#" alt="Pré-visualização" class="img-fluid rounded border" style="max-height: 200px;">
                        </div>

                        <!-- Botão de Envio -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Processar e Salvar</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const container = document.getElementById('preview-container');
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        container.classList.remove('d-none');
    } else {
        container.classList.add('d-none');
    }
}
</script>

</body>
</html>
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