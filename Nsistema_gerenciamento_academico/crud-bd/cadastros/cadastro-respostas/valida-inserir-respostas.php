<?php
$erros = "";

var_dump($_POST);
if (
    empty($_POST["codigoRespostas"]) ||
    empty($_POST["respostaDada"]) ||
    empty($_POST["id_questao"]) ||
    empty($_POST["id_prova"]) ||
    empty($_POST["id_disciplina"]) ||
    empty($_POST["id_professor"])) {
        
    $erros .= "Todos os campos devem ser preenchidos.<br>";
}
// 'nota' e 'acertou' vem como strings que podem ser 0 ou 1
// se for 0 o sistema entende como false e sempre da erro
// por isso nao fiz uma validação individual para esses campos

if (strlen($_POST["codigoRespostas"]) < 3 || strlen($_POST["codigoRespostas"]) > 20) {
    $erros .= "Erro: campo 'Código da Resposta' deve ter entre 3 e 20 caracteres.<br>";
}

if (strlen($_POST["respostaDada"]) != 1 || !preg_match('/^[a-zA-Z]$/', $_POST["respostaDada"])) {
    $erros .= "Erro: campo 'Resposta Dada' deve conter um único caractere alfabético.<br>";
}

//Como validar os IDs que sao chaves estrangeiras?

if (!empty($erros)) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Erros ao Cadastrar Resposta</title>
        <meta charset='utf-8'>
        <link rel='stylesheet' href='../../../css/style.css'>
    </head>
    <body class='servicos_forms'>
        <div class='form_container'>
            <h2>Erros ao Cadastrar Resposta</h2>
            <div style='color: red;'>$erros</div>
            <hr>
            <a href='form-respostas.php'>Voltar ao formulário</a>
        </div>
    </body>
    </html>";
    exit;
} else {
    // Sem erros: gera formulário oculto para submissão
    echo '<form action="inserir-respostas.php" method="POST" name="form_inserir">';
    foreach ($_POST as $key => $value) {
        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
    }
    echo '</form>';
    echo '<script>document.forms["form_inserir"].submit();</script>';
    exit;
}
?>
