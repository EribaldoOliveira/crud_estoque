<?php
include 'db.php';

if ($conexao) {
    echo "Conexão bem-sucedida!";
} else {
    echo "Erro ao conectar ao banco de dados.";
}
?>
