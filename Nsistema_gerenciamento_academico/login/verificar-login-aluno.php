<?php

require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
	$login   = $_POST['login'] ?? '';
	$senhaDigitada  = $_POST['senha'] ?? '';
	 try {
        $sql = "SELECT * FROM aluno WHERE email = :login";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashArmazenado = $usuario['senha'];
            if (password_verify($senhaDigitada, $hashArmazenado)) {
                
                header("Location: login-selecao-aluno.php?sucesso=1");
            } else {
                echo "Senha incorreta.";
            }
        } else {
            echo "Aluno não encontrado.";
        }

    } catch (PDOException $e) {
        echo "Erro ao acessar o banco de dados: " . $e->getMessage();
    }
}
?>
