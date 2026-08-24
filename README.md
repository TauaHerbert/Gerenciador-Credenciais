# 🔐 Gerenciador de Credenciais

Um sistema web completo para armazenamento e gerenciamento seguro de senhas e credenciais, organizado por domínios. Desenvolvido com foco em segurança da informação, arquitetura limpa e experiência do usuário (UI/UX).

## 🚀 Funcionalidades

*   **Gestão de Domínios:** Cadastro, edição e exclusão de domínios (projetos, empresas ou sites).
*   **Gestão de Credenciais:** Armazenamento seguro de logins e senhas vinculados a cada domínio.
*   **Segurança Avançada (Criptografia e Hash):** As senhas são protegidas no banco de dados utilizando criptografia reversível **AES-256-CBC** através do OpenSSL, combinada com o uso de **SHA-256** para a derivação e fortalecimento das chaves secretas.
*   **Interface Interativa:** Utilização da tag HTML5 `<details>` para listas em formato "sanfona" (accordion), modais dinâmicos para formulários e notificações flutuantes (Toasts).
*   **Copy to Clipboard:** Botão de acesso rápido para copiar senhas com um clique.
*   **Exclusão Segura:** Sistema de validação por *prompt* (exigindo a digitação do nome) para evitar a exclusão acidental de domínios que contenham múltiplas credenciais.

## 🛠️ Tecnologias e Arquitetura

O projeto foi construído utilizando as seguintes tecnologias:

*   **Backend:** PHP 8+
    *   Padrão de Projeto **Singleton** para o gerenciamento da conexão com o banco.
    *   Uso de **PDO (PHP Data Objects)** e *Prepared Statements* para prevenção contra SQL Injection.
    *   Criptografia com **OpenSSL** e algoritmos **SHA-256** / **AES-256-CBC**.
*   **Frontend:** HTML5, CSS3 e Vanilla JavaScript.
*   **Banco de Dados:** MySQL.
*   **Segurança e Versionamento:** Proteção de variáveis de ambiente e chaves de segurança via arquivo `config.ini` (ignorado pelo `.gitignore`).

## ⚙️ Como executar o projeto localmente

### 1. Requisitos
* Servidor local (XAMPP, WAMP, Laragon, etc) rodando PHP e MySQL.
* Git instalado na máquina.