<?php
// Classe para conectar ao banco de dados
class Conexao {
    
    private static $instancia = null;

    public static function getConexao() {

        // Se a conexão ainda não foi criada, entra aqui para criar
        if (self::$instancia === null) {
            
            // Lê o arquivo onde estão guardadas as senhas do banco
            $config = parse_ini_file('config.ini');

            // Se não achar o arquivo, para tudo e avisa o erro
            if ($config === false) {
                die("Erro: Não foi possível ler o arquivo config.ini.");
            }

            // Pega as informação do arquivo e coloca em variáveis
            $host = $config['host'];
            $dbname = $config['dbname'];
            $user = $config['user'];
            $password = $config['password'];

            try {
                // Prepara os dados de conexão e define o padrão de texto para aceitar acentos (utf8mb4)
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                
                // Conecta de fato usando o PDO
                self::$instancia = new pdo($dsn, $user, $password);

                // Configura o banco para avisar se algum comando SQL der errado
                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                // Se der erro (ex: senha errada ou banco fora do ar), mostra o problema e para
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        
        // Retorna a conexão pronta para usarmos nos formulários e listagens
        return self::$instancia;
    }
}
?>