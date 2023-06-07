<?php
    // testando
    $dadosValidos = true;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        if (isset($email) && isset($senha)) {
            $arquivo = "csv/users.csv";
            $fp = fopen($arquivo, "r");
            if ($fp) {
                while(($row = fgetcsv($fp)) !== false) {
                    if ($row[0] == $email && $row[1] == $senha) {
                        session_start();
                        $_SESSION["user"] = $row[0];
                        $_SESSION["auth"] = true;
                        fclose($fp);
                        header("location: /src/home.php", true, 302);
                        exit;
                    }
                }
                fclose($fp);
                $dadosValidos = false;
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
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action=<?= $_SERVER["PHP_SELF"]?> method="post" class="formDefault">
        <input type="email" placeholder="E-mail" name="email" required>
        <input type="password" placeholder="Senha" name="senha" required>
        <input type="submit" value="Entrar">
        <p class="p"><a href="src/cadastro.php">Criar conta</a></p> 
    </form>
    <?php if (!$dadosValidos):?>
        <p class="aviso">Dados inválidos!</p>
    <?php endif?>
</body>
</html>