<?php 
require 'conection.php'; 
require 'seguranca.php'; 

$pdo = Conexao::getConexao();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Credenciais</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Gerenciador de Credenciais</h1>
            <button class="btn" onclick="abrirModalDominio()">+ Novo Domínio</button>
        </header>

        <?php
        $stmtDominios = $pdo->query("SELECT * FROM dominios ORDER BY nome ASC");
        $dominios = $stmtDominios->fetchAll(pdo::FETCH_ASSOC);

        if (count($dominios) === 0): ?>
            <p>Nenhum domínio cadastrado ainda. Comece adicionando um novo!</p>
        <?php else: ?>
            
            <?php foreach ($dominios as $dominio): ?>
            <details>
                <summary>
                    <div>
                        <?= htmlspecialchars($dominio['nome']) ?>
                        <span class="dominio-desc"><?= htmlspecialchars($dominio['descricao']) ?></span>
                    </div>
                    <div>
                            <button class="btn btn-small btn-secondary" onclick='event.preventDefault(); event.stopPropagation(); editarDominio(<?= $dominio["id"] ?>, <?= json_encode($dominio["nome"]) ?>, <?= json_encode($dominio["descricao"]) ?>)'>Editar</button>

                            <button class="btn btn-small btn-danger" onclick='event.preventDefault(); event.stopPropagation(); confirmarExclusaoDominio(<?= $dominio["id"] ?>, <?= json_encode($dominio["nome"]) ?>)'>Excluir</button>

                            <button class="btn btn-small" onclick='event.preventDefault(); event.stopPropagation(); abrirModalCredencial(<?= $dominio["id"] ?>)'>+ Credencial</button>    
                    </div>
                </summary>
                
                <?php
                $stmtCred = $pdo->prepare("SELECT * FROM credenciais WHERE id_dominio = ?");
                $stmtCred->execute([$dominio['id']]);
                $credenciais = $stmtCred->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <?php if (count($credenciais) > 0): ?>
                <table class="credenciais-table">
                    <thead>
                        <tr>
                            <th>Login</th>
                            <th>Senha</th> 
                            <th>Descrição</th>
                            <th style="width: 250px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($credenciais as $cred): 
                            $senhaReal = desencriptarSenha($cred['senha']);
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($cred['login']) ?></td>
                            <td><strong><?= htmlspecialchars($senhaReal) ?></strong></td>
                            <td><?= htmlspecialchars($cred['descricao']) ?></td>
                            
                            <td>
                                <div class="acoes-tabela">
                                    <button class="btn btn-small btn-outline-primary" onclick='copiarTexto(<?= json_encode($senhaReal) ?>)'>Copiar Senha</button>
                                    <button class="btn btn-small btn-outline-secondary" onclick='editarCredencial(<?= $cred["id"] ?>, <?= $cred["id_dominio"] ?>, <?= json_encode($cred["login"]) ?>, <?= json_encode($senhaReal) ?>, <?= json_encode($cred["descricao"]) ?>)'>Editar</button>
                                    <button class="btn btn-small btn-outline-danger" onclick='confirmarExclusaoCredencial(<?= $cred["id"] ?>)'>Excluir</button>
                                </div>
                            </td>
                            
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p style="padding: 15px; font-size: 13px; color: #666;">Nenhuma credencial vinculada a este domínio.</p>
                <?php endif; ?>
            </details>
            <?php endforeach; ?>
            
        <?php endif; ?>

    </div>

    <div id="modalDominio" class="modal-overlay">
        <div class="modal">
            <h3 id="tituloModalDominio">Cadastro de Domínio</h3>
            <form action="actions.php" method="POST">
                <input type="hidden" name="acao" value="salvar_dominio">
                <input type="hidden" name="id" id="dom_id">
                
                <div class="form-group">
                    <label>Nome do Domínio</label>
                    <input type="text" name="nome" id="dom_nome" required>
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" name="descricao" id="dom_desc">
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="fecharModal('modalDominio')">Cancelar</button>
                    <button type="submit" class="btn">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalCredencial" class="modal-overlay">
        <div class="modal">
            <h3 id="tituloModalCredencial">Cadastro de Credencial</h3>
            <form action="actions.php" method="POST">
                <input type="hidden" name="acao" value="salvar_credencial">
                <input type="hidden" name="id" id="cred_id">
                <input type="hidden" name="dominio_id" id="cred_dominio_id">
                
                <div class="form-group">
                    <label>Login / Usuário</label>
                    <input type="text" name="login" id="cred_login" required>
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="text" name="senha" id="cred_senha" required>
                </div>
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" name="descricao" id="cred_desc">
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="fecharModal('modalCredencial')">Cancelar</button>
                    <button type="submit" class="btn">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    
    <div id="toast" class="toast">Senha copiada com sucesso!</div>
    
    <script src="script.js"></script>
</body>
</html>