function abrirModalDominio() {
    document.getElementById('dom_id').value = '';
    document.getElementById('dom_nome').value = '';
    document.getElementById('dom_desc').value = '';
    document.getElementById('tituloModalDominio').innerText = 'Novo Domínio';
    document.getElementById('modalDominio').style.display = 'flex';
}

function editarDominio(id, nome, descricao) {
    document.getElementById('dom_id').value = id;
    document.getElementById('dom_nome').value = nome;
    document.getElementById('dom_desc').value = descricao;
    document.getElementById('tituloModalDominio').innerText = 'Editar Domínio';
    document.getElementById('modalDominio').style.display = 'flex';
}

function abrirModalCredencial(dominioId) {
    document.getElementById('cred_id').value = '';
    document.getElementById('cred_dominio_id').value = dominioId;
    document.getElementById('cred_login').value = '';
    document.getElementById('cred_senha').value = '';
    document.getElementById('cred_desc').value = '';
    document.getElementById('tituloModalCredencial').innerText = 'Nova Credencial';
    document.getElementById('modalCredencial').style.display = 'flex';
}

function editarCredencial(id, dominioId, login, senha, descricao) {
    document.getElementById('cred_id').value = id;
    document.getElementById('cred_dominio_id').value = dominioId;
    document.getElementById('cred_login').value = login;
    document.getElementById('cred_senha').value = senha;
    document.getElementById('cred_desc').value = descricao;
    document.getElementById('tituloModalCredencial').innerText = 'Editar Credencial';
    document.getElementById('modalCredencial').style.display = 'flex';
}

// A exclusão do domínio (exige digitar o nome)
function confirmarExclusaoDominio(id, nomeDominio) {
    const digitado = prompt(`⚠️ ATENÇÃO: Excluir o domínio "${nomeDominio}" apagará TODAS as credenciais vinculadas a ele!\n\nPara confirmar a exclusão, digite o nome do domínio abaixo:`);
    
    if (digitado === nomeDominio) {
        window.location.href = `actions.php?acao=excluir&tipo=dominio&id=${id}`;
    } else if (digitado !== null) {
        alert("Nome incorreto. A exclusão foi cancelada por segurança.");
    }
}

// A exclusão da credencial
function confirmarExclusaoCredencial(id) {
    if (confirm("Tem certeza que deseja excluir esta credencial?")) {
        window.location.href = `actions.php?acao=excluir&tipo=credencial&id=${id}`;
    }
}

// Função de copiar texto (Balãozinho)
function copiarTexto(texto) {
    navigator.clipboard.writeText(texto).then(() => {
        const toast = document.getElementById("toast");
        toast.className = "toast show";
        
        // Esconde o balãozinho após 3 segundos
        setTimeout(function() { 
            toast.className = toast.className.replace("toast show", "toast"); 
        }, 3000);
        
    }).catch(err => {
        console.error('Erro ao copiar: ', err);
    });
}

function fecharModal(idModal) {
    document.getElementById(idModal).style.display = 'none';
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.style.display = 'none';
    }
}