<?php

require_once '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoConteudo = $_POST["codigoConteudo"];
    $tituloConteudo = $_POST["tituloConteudo"];
    $descricaoConteudo = $_POST["descricaoConteudo"];
    $data_postagem = $_POST["data_postagem"];
    $professor = $_POST["professor"];
    $disciplina = $_POST["disciplina"];
    $tipo_conteudo = $_POST["tipo_conteudo"];
    $id_disciplina = $_POST["id_disciplina"];

    try {
        $sql = "INSERT INTO conteudo (codigoConteudo, titulo, descricao, data_postagem, professor, disciplina, tipo_conteudo, Disciplina_id_disciplina) 
                VALUES (:codigo, :titulo, :descricao, :data_postagem, :professor, :disciplina, :tipo, :id_disciplina)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigoConteudo,
            ':titulo' => $tituloConteudo,
            ':descricao' => $descricaoConteudo,
            ':data_postagem' => $data_postagem,
            ':professor' => $professor,
            ':disciplina' => $disciplina,
            ':tipo' => $tipo_conteudo,
            ':id_disciplina' => $id_disciplina
        ]);

        echo "<p>Dados inseridos com sucesso!</p>";
        echo '<p><a href="../../../servicos-professor/pagina-servicos-professor.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Dashboard</a></p>';
    } catch (PDOException $e) {
        echo "<p>Erro ao inserir dados: " . $e->getMessage() . "</p>";
        echo '<p><a href="form-conteudo.php" style="padding: 10px 20px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;">Voltar ao Cadastro</a></p>';
    }
} else {
    echo "<p>Requisição inválida.</p>";
}

?>