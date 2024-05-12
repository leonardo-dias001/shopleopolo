<?php
// Definindo as variáveis de conexão
$host = "sexyshop.mysql.uhserver.com"; // ou o IP do servidor de banco de dados
$dbname = "sexyshop";    // nome do banco de dados
$user = "sexyshop";     // usuário do banco de dados
$password = "m@n@g3r"; // senha do usuário do banco de dados

// Criando a conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
