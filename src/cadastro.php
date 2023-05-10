<?php 
    $emailValido = true;
    $senhasIguais = true;
    $dadosValidos = true;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $ConfirmarSenha = $_POST["ConfirmarSenha"];
        if (isset($email) && isset($senha) && isset($ConfirmarSenha)) {
            $arquivo = "../csv/users.csv";
            $fp = fopen($arquivo, "r");
            if ($fp) {
                while(($row = fgetcsv($fp)) !== false) {
                    if ($row[0] == $email) {
                        $emailValido = false;
                        $dadosValidos = false;
                        break;
                    }
                }
                if ($senha !== $ConfirmarSenha) {
                    $senhasIguais = false;
                    $dadosValidos = false;
                }
                fclose($fp);
                if ($dadosValidos) {
                    $fp = fopen($arquivo, "a");
                    fputcsv($fp, [$email, $senha]);
                    session_start();
                    $_SESSION["user"] = $email;
                    $_SESSION["auth"] = true;
                    fclose($fp);
                    header("location: /src/home.php", true, 302);
                    exit;
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
    <title>Cadastro</title>
</head>
<style>
    .formDefault input[type="email"],
.formDefault input[type="password"] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: none;
  border-radius: 4px;
  background-color: #f8f8f8;
}

</style>
<body>
    <h1>Cadastro    </h1>
    <form action=<?= $_SERVER["PHP_SELF"]?> method="post" class="formDefault">
        <input type="email" placeholder="E-mail" name="email" required>
        <input type="password" placeholder="Senha" name="senha" required>
        <input type="password" placeholder="Confirmar Senha" name="ConfirmarSenha" required>
        <input type="submit" value="Criar">
        <p class="p"><a href="/index.php">Fazer login</a></p>
    </form>
    <?php if (!$emailValido):?>
        <p class="aviso">Email já utilizado!</p>
    <?php endif?>
    <?php if (!$senhasIguais):?>
        <p class="aviso">As senha precisam ser iguais!</p>
    <?php endif?>
</body>
</html>