<?php
// Configuração do banco
$host = "mysql52-farm1.kinghost.net";
$user = "quebragalhofer";
$senha = "quebragalhofer";
$banco = "ferragemQG0305";

$conn = new mysqli($host, $user, $senha, $banco);
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

function videoMime($arquivo)
{
    $ext = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
    return match ($ext) {
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'ogg' => 'video/ogg',
        'mov' => 'video/quicktime',
        'mkv' => 'video/x-matroska',
        default => 'video/mp4',
    };
}

// Upload
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["arquivo"])) {
    $titulo = $_POST["titulo"] ?? '';
    $file = $_FILES["arquivo"];

    if ($file["error"] === 0) {
        $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $permitidos_img = ["jpg", "jpeg", "png", "gif"];
        $permitidos_video = ["mp4", "webm", "ogg"];

        if (in_array($ext, $permitidos_img)) {
            $tipo = "imagem";
        } elseif (in_array($ext, $permitidos_video)) {
            $tipo = "video";
        } else {
            echo "<div class='alert alert-danger'>Tipo de arquivo não permitido.</div>";
            $tipo = null;
        }

        if ($tipo) {
            $nome_arquivo = uniqid() . "." . $ext;
            $pasta = "uploads/";
            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            if (move_uploaded_file($file["tmp_name"], $pasta . $nome_arquivo)) {
                $sql = "INSERT INTO midias (titulo, tipo, arquivo) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $titulo, $tipo, $nome_arquivo);
                $stmt->execute();
                echo "<div class='alert alert-success'>Arquivo enviado com sucesso!</div>";
            }
        }
    }
}

// Listagem
$midias = $conn->query("SELECT * FROM midias ORDER BY criado_em DESC");
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Upload de Imagens e Vídeos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .video-container video {
        max-height: 250px;
        object-fit: cover;
        width: 100%;
    }
</style>

<body class="bg-light">

    <div class="container py-4">
        <h2 class="mb-4">Upload de Imagens e Vídeos</h2>

        <!-- Formulário -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-6">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="arquivo" class="form-label">Arquivo</label>
                        <input type="file" name="arquivo" id="arquivo" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Listagem -->
        <div class="row">
            <?php while ($m = $midias->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if ($m["tipo"] === "imagem"): ?>
                            <img src="uploads/<?= $m['arquivo'] ?>" class="card-img-top"
                                alt="<?= htmlspecialchars($m['titulo']) ?>">
                        <?php else: ?>
                            <video controls class="w-100">
                                <source src="uploads/<?= htmlspecialchars($m['arquivo']) ?>"
                                    type="<?= videoMime($m['arquivo']) ?>">
                                Seu navegador não suporta vídeos.
                            </video>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($m['titulo']) ?></h5>
                            <p class="card-text"><small class="text-muted">Enviado em
                                    <?= date("d/m/Y H:i", strtotime($m['criado_em'])) ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

</body>

</html>