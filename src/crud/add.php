<?php
require "../auth/auth.php";
$livroValido = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = uniqid();
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $editora = $_POST["editora"];
    $genero = $_POST["genero"];
    if (isset($id) && isset($titulo) && isset($autor) && isset($editora) && isset($genero)) {
        $arquivo = "../../csv/livros.csv";
        $fp = fopen($arquivo, "r");
        if ($fp) {
            while (($row = fgetcsv($fp)) !== false) {
                if ($row[1] == $titulo && $row[2] == $autor && $row[4] == $genero) {
                    $livroValido = false;
                    break;
                }
            }
        }
        fclose($fp);
        if ($livroValido) {
            $fp = fopen($arquivo, "a");
            if ($fp) {
                fputcsv($fp, [$id, $titulo, $autor, $editora, $genero]);
            }
            fclose($fp);
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
    <title>Crud</title>
    <script>
        window.addEventListener("load", function() {
            const buttonVoltar = document.querySelector("#bVoltar");

            buttonVoltar.addEventListener("click", function() {
                window.location.href = "/src/home.php";
            });

        });
    </script>
</head>

<body>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" class="formDefault">
        <input type="text" placeholder="Título" name="titulo" required>
        <input type="text" placeholder="Autor" name="autor" required>
        <input type="text" placeholder="Editora" name="editora" required>
        <select name="genero" required>
            <option value="" disabled selected hidden>Selecione um gênero</option>
            <option value="Biografia">Biografia</option>
            <option value="Ficção">Ficção</option>
            <option value="Não ficção">Não ficção</option>
        </select>
        <input type="submit" value="Adicionar">
    </form>
    <button class="button-default" id="bVoltar">Voltar</button>
    <?php if (!$livroValido) : ?>
        <p class="aviso">Livro já adicionado</p>
    <?php endif ?>
    <div>
        <h1>Ficção</h1>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Editora</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $arquivo = "../../csv/livros.csv";
                $fp = fopen($arquivo, "r");
                ?>
                <?php if ($fp) : ?>
                    <?php while (($row = fgetcsv($fp)) !== false) : ?>
                        <tr>
                            <?php if ($row[4] === "Ficção") : ?>
                                <td><?= $row[1] ?></td>
                                <td><?= $row[2] ?></td>
                                <td><?= $row[3] ?></td>
                                <td>
                                    <a href="delete.php?id=<?= $row[0] ?>">
                                        <button class="button-default">
                                            Remover
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $row[0] ?>">
                                        <button class="button-default">
                                            Editar
                                        </button>
                                    </a>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endwhile ?>
                <?php endif ?>
            </tbody>
        </table>
        <?php rewind($fp) ?>
        <h1>Não Ficção</h1>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Editora</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $arquivo = "../../csv/livros.csv";
                $fp = fopen($arquivo, "r");
                ?>
                <?php if ($fp) : ?>
                    <?php while (($row = fgetcsv($fp)) !== false) : ?>
                        <tr>
                            <?php if ($row[4] === "Não ficção") : ?>
                                <td><?= $row[1] ?></td>
                                <td><?= $row[2] ?></td>
                                <td><?= $row[3] ?></td>
                                <td>
                                    <a href="delete.php?id=<?= $row[0] ?>">
                                        <button class="button-default">
                                            Remover
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $row[0] ?>">
                                        <button class="button-default">
                                            Editar
                                        </button>
                                    </a>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endwhile ?>
                <?php endif ?>
            </tbody>
        </table>
        <?php rewind($fp) ?>
        <h1>Biografia</h1>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Editora</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $arquivo = "../../csv/livros.csv";
                $fp = fopen($arquivo, "r");
                ?>
                <?php if ($fp) : ?>
                    <?php while (($row = fgetcsv($fp)) !== false) : ?>
                        <tr>
                            <?php if ($row[4] === "Biografia") : ?>
                                <td><?= $row[1] ?></td>
                                <td><?= $row[2] ?></td>
                                <td><?= $row[3] ?></td>
                                <td>
                                    <a href="delete.php?id=<?= $row[0] ?>">
                                        <button class="button-default">
                                            Remover
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $row[0] ?>">
                                        <button class="button-default">
                                            Editar
                                        </button>
                                    </a>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endwhile ?>
                <?php endif ?>
            </tbody>
        </table>
        <?php fclose($fp) ?>
    </div>
</body>

</html>