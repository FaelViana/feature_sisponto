<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'dbpontos';

// Conexão com o banco de dados
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conexao->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conexao->connect_error);
}

// Resposta padrão
$resposta = array('success' => false, 'message' => 'Erro na consulta');

// Verifica se a matrícula foi enviada pelo formulário
if (isset($_POST['matricula'])) {
    // Usa prepared statement para evitar injeção de SQL
    $matricula = $_POST['matricula'];
    $consulta = "SELECT matricula, nome, data_nascimento, setor FROM cadastro WHERE matricula = ?";
    
    if ($stmt = $conexao->prepare($consulta)) {
        $stmt->bind_param('s', $matricula);
        $stmt->execute();
        $stmt->store_result();

        // Verifica se encontrou algum resultado
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($matricula, $nome, $data_nascimento, $setor);
            $stmt->fetch();

            $resposta['success'] = true;
            $resposta['message'] = 'Mat. encontrada';           
            $resposta['data'] = array('matricula' => $matricula, 'nome' => $nome, 'data_nascimento' => $data_nascimento, 'setor' => $setor);

            // Define variáveis de sessão

             session_start();
             $_SESSION['matricula'] = $matricula;
             $_SESSION['nome'] = $nome;
             $_SESSION['data_nascimento'] = $data_nascimento;
             $_SESSION['setor'] = $setor;
             

        } else {
            $resposta['message'] = 'matricula não encontrada';
        }

        $stmt->close();
    } else {
        $resposta['message'] = 'Erro na preparação da consulta';
    }
} else {
    $resposta['message'] = 'Matrícula não fornecida';
}

// Fecha a conexão com o banco de dados
$conexao->close();

// Converte a resposta para JSON e imprime
echo json_encode($resposta);
?>