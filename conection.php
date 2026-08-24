<?php
class Conexao {
    private static $instancia = null;

    public static function getConexao() {

        if (self::$instancia === null) {
            
            $config = parse_ini_file('config.ini');

            if ($config === false) {
                die("Erro: Não foi possível ler o arquivo config.ini.");
            }

            $host = $config['host'];
            $dbname = $config['dbname'];
            $user = $config['user'];
            $password = $config['password'];

            try {
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                self::$instancia = new pdo($dsn, $user, $password);

                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {

                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        
        return self::$instancia;
    }
}
?>