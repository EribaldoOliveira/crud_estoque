<?php
// db.php - Conexão com o banco de dados
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'crud_php';

// Conexão com o banco de dados
$conexao = mysqli_connect($host, $user, $password, $dbname);

if (!$conexao) {
    die('Falha na conexão: ' . mysqli_connect_error());
}

// Função para adicionar um novo usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $sql = "INSERT INTO usuarios (nome, email, telefone) VALUES ('$nome', '$email', '$telefone')";
    if (mysqli_query($conexao, $sql)) {
        header('Location: index.php'); // Redireciona após cadastro
    } else {
        echo 'Erro ao cadastrar: ' . mysqli_error($conexao);
    }
}

// Função para editar um usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', telefone = '$telefone' WHERE id = $id";
    if (mysqli_query($conexao, $sql)) {
        header('Location: index.php'); // Redireciona após atualização
    } else {
        echo 'Erro ao atualizar: ' . mysqli_error($conexao);
    }
}

// Função para excluir um usuário
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM usuarios WHERE id = $id";
    if (mysqli_query($conexao, $sql)) {
        header('Location: index.php'); // Redireciona após exclusão
    } else {
        echo 'Erro ao excluir: ' . mysqli_error($conexao);
    }
}

// Listar os usuários
$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexao, $sql);

// Variável para controlar o modo de edição
$editarUsuario = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sqlEdit = "SELECT * FROM usuarios WHERE id = $id";
    $resultadoEdit = mysqli_query($conexao, $sqlEdit);
    $editarUsuario = mysqli_fetch_assoc($resultadoEdit);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Usuários</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link para o arquivo CSS -->
</head>

<body>
    <h1>Usuários Cadastrados</h1>

    <!-- Formulário para cadastrar um novo usuário ou editar um usuário existente -->
    <h2><?php echo isset($editarUsuario) ? 'Editar Usuário' : 'Cadastrar Novo Usuário'; ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo isset($editarUsuario['id']) ? $editarUsuario['id'] : ''; ?>">
        Nome: <input type="text" name="nome" required value="<?php echo isset($editarUsuario['nome']) ? $editarUsuario['nome'] : ''; ?>"><br>
        Email: <input type="email" name="email" required value="<?php echo isset($editarUsuario['email']) ? $editarUsuario['email'] : ''; ?>"><br>
        Telefone: <input type="text" name="telefone" value="<?php echo isset($editarUsuario['telefone']) ? $editarUsuario['telefone'] : ''; ?>"><br>
        <button type="submit" name="<?php echo isset($editarUsuario) ? 'atualizar' : 'cadastrar'; ?>">
            <?php echo isset($editarUsuario) ? 'Atualizar' : 'Cadastrar'; ?>
        </button>
    </form>

    <!-- Exibição da lista de usuários -->
    <h2>Lista de Usuários</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
        <?php while ($usuario = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo $usuario['nome']; ?></td>
                <td><?php echo $usuario['email']; ?></td>
                <td><?php echo $usuario['telefone']; ?></td>
                <td>
                <a href="?edit=<?php echo $usuario['id']; ?>" class="editar">Editar</a>
                <a href="?delete=<?php echo $usuario['id']; ?>" class="excluir">Excluir</a>


                    <!-- <a href="?edit=<?php echo $usuario['id']; ?>">Editar</a>
                    <a href="?delete=<?php echo $usuario['id']; ?>">Excluir</a> -->
                </td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>
