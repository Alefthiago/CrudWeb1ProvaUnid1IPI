<?php
require "../auth/auth.php";
$arquivoLivros = "../../csv/livros.csv";
$livroValido = true;
$data = [];
$id = $_GET["id"];
if (isset($id)) {
    $fp = fopen($arquivoLivros, "r");
    if ($fp) {
        while (($row = fgetcsv($fp)) !== false) {
            if ($row[0] == $id) {
                $data = $row;
                break;
            }
        }
    }
    fclose($fp);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $editora = $_POST["editora"];
    $genero = $_POST["genero"];
    if (isset($id) && isset($titulo) && isset($autor) && isset($editora) && isset($genero)) {
        $fp = fopen($arquivoLivros, "r");
        if ($fp) {
            while (($row = fgetcsv($fp)) !== false) {
                if ($row[1] == $titulo && $row[2] == $autor && $row[4] == $genero && $row[0] != $id) {
                    $livroValido = false;
                    break;
                }
            }
            rewind($fp);
            if ($livroValido) {
                $copy = tempnam("../../csv/", "");
                $temp = fopen($copy, "w");
                if ($temp) {
                    while (($row = fgetcsv($fp)) !== false) {
                        if ($row[0] == $id) {
                            fputcsv($temp, [$id, $titulo, $autor, $editora, $genero]);
                            continue;
                        }
                        fputcsv($temp, $row);
                    }
                }
                fclose($temp);
                fclose($fp);
                rename($copy, $arquivoLivros);
                header("location: /src/crud/add.php", true, 302);
            } else {
                fclose($fp);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Editar</title>
    <script>
        window.addEventListener("load", function() {
            const buttonVoltar = document.querySelector("#bVoltar");

            buttonVoltar.addEventListener("click", function() {
                window.location.href = "/src/crud/add.php";
            });

        });
    </script>
</head>

<body>
    <h1>Editar dados</h1>
    <form action="<?= $_SERVER["PHP_SELF"] ?>?id=<?= $row[0] ?>" method="post" class="formDefault">
        <input type="hidden" name="id" value="<?= $data[0] ?>">
        <label>Título</label>
        <input type="text" placeholder="Título" name="titulo" value="<?= $data[1] ?>">
        <label>Autor</label>
        <input type="text" placeholder="Autor" name="autor" value="<?= $data[2] ?>">
        <label>Editora</label>
        <input type="text" placeholder="Editora" name="editora" value="<?= $data[3] ?>">
        <label>Genêro</label>
        <select name="genero" required>
            <option value="<?= $data[4] ?>" hidden><?= $data[4] ?></option>
            <option value="Biografia">Biografia</option>
            <option value="Ficção">Ficção</option>
            <option value="Não ficção">Não ficção</option>
        </select>
        <input type="submit" value="Alterar">
    </form>
    <?php if (!$livroValido) : ?>
        <p class="aviso">Livro já adicionado</p>
    <?php endif ?>
    <button class="button-default" id="bVoltar">Voltar</button>
</body>

</html>