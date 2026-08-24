<?php
require 'conection.php';
require 'seguranca.php'; 

$pdo = Conexao::getConexao();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    try {
        // SALVAR DOMÍNIO 
        if ($acao === 'salvar_dominio') {
            $id = $_POST['id'] ?? null;
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');

            if (!empty($id)) {
                $stmt = $pdo->prepare("UPDATE dominios SET nome = ?, descricao = ? WHERE id = ?");
                $stmt->execute([$nome, $descricao, $id]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO dominios (nome, descricao) VALUES (?, ?)");
                $stmt->execute([$nome, $descricao]);
            }
            
        // SALVAR CREDENCIAL
        } elseif ($acao === 'salvar_credencial') {
            $id = $_POST['id'] ?? null;
            $dominio_id = $_POST['dominio_id'] ?? '';
            $login = trim($_POST['login'] ?? '');
            $senhaPlana = $_POST['senha'] ?? ''; 
            $descricao = trim($_POST['descricao'] ?? '');

            // Criptografa a senha antes de gravar
            $senhaCriptografada = encriptarSenha($senhaPlana);

            if (!empty($id)) {
                $stmt = $pdo->prepare("UPDATE credenciais SET login = ?, senha = ?, descricao = ? WHERE id = ?");
                // Passamos a $senhaCriptografada no lugar da senha plana
                $stmt->execute([$login, $senhaCriptografada, $descricao, $id]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO credenciais (id_dominio, login, senha, descricao) VALUES (?, ?, ?, ?)");
                // Passamos a $senhaCriptografada no lugar da senha plana
                $stmt->execute([$dominio_id, $login, $senhaCriptografada, $descricao]);
            }
        }
        
        // Retorna para a tela principal
        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        die("Erro no banco de dados: " . $e->getMessage());
    }
}

// EXCLUSÃO (DOMÍNIO OU CREDENCIAL) 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['acao']) && $_GET['acao'] === 'excluir') {
    $tipo = $_GET['tipo'] ?? '';
    $id = $_GET['id'] ?? '';

    if (!empty($id)) {
        try {
            if ($tipo === 'dominio') {
                $stmt = $pdo->prepare("DELETE FROM dominios WHERE id = ?");
                $stmt->execute([$id]);
            } elseif ($tipo === 'credencial') {
                $stmt = $pdo->prepare("DELETE FROM credenciais WHERE id = ?");
                $stmt->execute([$id]);
            }
        } catch (PDOException $e) {
            die("Erro ao excluir: " . $e->getMessage());
        }
    }
    header("Location: index.php");
    exit;
}
?>