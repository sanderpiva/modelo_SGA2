<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Professor</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="servicos_forms">

    <div class="form_container">
        <form class="form" method="post" action="verificar-login-professor.php">
            <h2>Login Professor</h2>

            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required>
            <br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
            <br><br>

            <button type="submit">Login</button>

        </form>
    </div>
    <a href="../index.php">Home Page</a>
</body>
<footer>
    <p>Desenvolvido por Juliana e Sander</p>
</footer>

</html>