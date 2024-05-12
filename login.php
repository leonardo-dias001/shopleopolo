<?php
session_start(); // Inicia a sessão
include 'banco.php'; // Seu arquivo de conexão com o banco de dados

// Função para carregar as empresas
function carregarEmpresas($conn) {
    $empresas = array();
    $sql = "SELECT NOME_EMPRESA FROM empresas";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $empresas[] = $row['NOME_EMPRESA'];
        }
    }
    return $empresas;
}

// Processa o login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_empresa = $conn->real_escape_string($_POST['nome_empresa']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $senha = $conn->real_escape_string($_POST['senha']); // Idealmente, você deve usar hashing de senha

    // Consulta ao banco de dados para verificar o usuário
    $sql = "SELECT * FROM usuarios WHERE NOME_EMPRESA = ? AND USUARIO = ? AND SENHA = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome_empresa, $usuario, $senha);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true; // Define a sessão como logada
        $_SESSION['usuario']  = $usuario; // Armazena o nome do usuário na sessão
        $_SESSION['empresa']  = $nome_empresa; // Armazena o nome da empresa na sessão
        header("Location: index.php"); // Redireciona para index.php
        exit;
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 15px;
        }
        form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 350px;
            transition: box-shadow 0.3s;
        }
        form:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #495057;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box; /* Add box-sizing to include padding in width */
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        p {
            color: #dc3545;
            text-align: center;
            margin-top: -15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <h1>Login</h1>
        <label for="nome_empresa">Empresa:</label>
        <select id="nome_empresa" name="nome_empresa">
            <?php
            include 'banco.php'; // Seu arquivo de conexão com o banco de dados
            $empresas = carregarEmpresas($conn);
            foreach ($empresas as $empresa) {
                echo "<option value=\"{$empresa}\">{$empresa}</option>";
            }
            ?>
        </select>

        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <input type="submit" value="Login">
        <?php if (!empty($erro)) { echo "<p>$erro</p>"; } ?>
    </form>
</body>
</html>

