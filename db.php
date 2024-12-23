<?php
$host = 'localhost';          // Servidor onde está o banco de dados (geralmente 'localhost')
$user = 'root';               // Usuário do banco (por padrão, 'root' no XAMPP)
$password = '';               // Senha do usuário (vazia se você não configurou uma senha)
$dbname = 'crud_php';         // Nome do banco de dados que criamos no phpMyAdmin

// Conexão ao banco de dados
$conexao = mysqli_connect($host, $user, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if (!$conexao) {
    die('Falha na conexão: ' . mysqli_connect_error());
}
?>
