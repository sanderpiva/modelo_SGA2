<?php
$erros = "";

if (
    empty($_POST["matricula"]) ||
    empty($_POST["nomeAluno"]) ||
    empty($_POST["cpf"]) ||
    empty($_POST["emailAluno"]) ||
    empty($_POST["data_nascimento"]) ||
    empty($_POST["enderecoAluno"]) ||
    empty($_POST["cidadeAluno"]) ||
    empty($_POST["telefoneAluno"])||
    empty($_POST["id_turma"])||
    empty($_POST["senha"])
) {
    $erros .= "Todos os campos devem ser preenchidos.<br>";
}
if (strlen($_POST["nomeAluno"]) < 5 || strlen($_POST["nomeAluno"]) > 64) {
    $erros .= "Erro: campo 'nome' deve conter entre 5 e 64 caracteres.<br>";
}
if (strlen($_POST["cpf"]) != 11 || !ctype_digit($_POST["cpf"])) {
    $erros .= "Erro: campo 'cpf' inválido! Use apenas 11 números.<br>";
}
if (
    strlen($_POST["emailAluno"]) < 5 ||
    strlen($_POST["emailAluno"]) > 64 ||
    !filter_var($_POST["emailAluno"], FILTER_VALIDATE_EMAIL)
) {
    $erros .= "Erro: campo 'email' inválido! Digite um email válido.<br>";
}

if (strlen($_POST["enderecoAluno"]) < 5 || strlen($_POST["enderecoAluno"]) > 64) {
    $erros .= "Erro: campo 'endereço' deve conter entre 5 e 64 caracteres.<br>";
}

if (strlen($_POST["cidadeAluno"]) < 5 || strlen($_POST["cidadeAluno"]) > 20) {
    $erros .= "Erro: campo 'cidade' deve conter entre 5 e 20 caracteres.<br>";
}
if (strlen($_POST["telefoneAluno"]) < 10 || strlen($_POST["telefoneAluno"]) > 25) {
    $erros .= "Erro: campo 'telefone' deve conter entre 10 e 25 caracteres.<br>";
}

if (!empty($erros)) {
    
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erro de Validação</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros no Cadastro</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='cadastro-aluno.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    echo '<form action="cadastro-aluno-bd.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>
