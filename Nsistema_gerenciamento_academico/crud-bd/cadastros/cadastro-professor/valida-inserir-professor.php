<?php
$erros = "";

// Verificação de campos obrigatórios
if (
    empty($_POST["registroProfessor"]) ||
    empty($_POST["nomeProfessor"]) ||
    empty($_POST["emailProfessor"]) ||
    empty($_POST["enderecoProfessor"]) ||
    empty($_POST["telefoneProfessor"]) ) {
    $erros .= "Todos os campos devem ser preenchidos.<br>";
}

// Validações individuais
if (strlen($_POST["registroProfessor"]) < 3 || strlen($_POST["registroProfessor"]) > 20) {
    $erros .= "Erro: campo 'Registro do Professor' deve ter entre 3 e 20 caracteres.<br>";
}

if (strlen($_POST["nomeProfessor"]) < 10 || strlen($_POST["nomeProfessor"]) > 30) {
    $erros .= "Erro: campo 'Nome do Professor' deve ter entre 10 e 30 caracteres.<br>";
}

if (!filter_var($_POST["emailProfessor"], FILTER_VALIDATE_EMAIL)) {
    $erros .= "Erro: campo 'E-mail' inválido.<br>";
}

if (strlen($_POST["enderecoProfessor"]) < 5 || strlen($_POST["enderecoProfessor"]) > 100) {
    $erros .= "Erro: campo 'Endereço' deve ter entre 5 e 100 caracteres.<br>";
}

if (strlen($_POST["telefoneProfessor"]) < 10 || strlen($_POST["telefoneProfessor"]) > 25) {
    $erros .= "Erro: campo 'Telefone' deve ter entre 10 e 25 caracteres.<br>";
}

if (!empty($erros)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erros ao Cadastrar Professor</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros ao Cadastrar Professor</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='form-professor.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    
    echo '<form action="inserir-professor.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>
