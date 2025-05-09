<?php
$erros = "";
//var_dump($_POST);

if (
    empty($_POST["codigoDisciplina"]) ||
    empty($_POST["nomeDisciplina"]) ||
    empty($_POST["carga_horaria"]) ||
    empty($_POST["professor"]) ||
    empty($_POST["descricaoDisciplina"]) ||
    empty($_POST["semestre_periodo"])||
    empty($_POST["id_professor"]) ||
    empty($_POST["id_turma"])||
    empty($_POST["id_professor"])){
    $erros .= "Todos os campos devem ser preenchidos.<br>";
}

if (strlen($_POST["codigoDisciplina"]) < 3 || strlen($_POST["codigoDisciplina"]) > 20) {
    $erros .= "Erro: campo 'Código Disciplina' deve ter entre 3 e 20 caracteres.<br>";
}

if (strlen($_POST["nomeDisciplina"]) < 3 || strlen($_POST["nomeDisciplina"]) > 20) {
    $erros .= "Erro: campo 'Nome Disciplina' deve ter entre 3 e 20 caracteres.<br>";
}

if (!is_numeric($_POST["carga_horaria"]) || $_POST["carga_horaria"] < 10 || $_POST["carga_horaria"] > 100) {
    $erros .= "Erro: campo 'Carga Horária' deve ser um número entre 10 e 100.<br>";
}

if (strlen($_POST["professor"]) < 10 || strlen($_POST["professor"]) > 20) {
    $erros .= "Erro: campo 'Professor' deve ter entre 10 e 20 caracteres.<br>";
}

if (strlen($_POST["descricaoDisciplina"]) < 30 || strlen($_POST["descricaoDisciplina"]) > 300) {
    $erros .= "Erro: campo 'Descrição Disciplina' deve ter entre 30 e 300 caracteres.<br>";
}

if (strlen($_POST["semestre_periodo"]) < 3 || strlen($_POST["semestre_periodo"]) > 20) {
    $erros .= "Erro: campo 'Semestre/Periodo' deve ter entre 3 e 20 caracteres.<br>";
}

//Validar IDs? Sao chaves estrangeiras

if (!empty($erros)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erros ao Cadastrar Disciplina</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros ao Cadastrar Disciplina</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='form-disciplina.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    
    echo '<form action="inserir-disciplina.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>
