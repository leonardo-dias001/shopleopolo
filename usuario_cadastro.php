<?php
session_start(); // Inicia a sessão

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: login.php");
    exit;
}
?>


<?php
// Inclui o arquivo de conexão com o banco de dados
include 'banco.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém e sanitiza os dados do formulário
    $nome_empresa = $conn->real_escape_string($_POST['nome_empresa']);
    $usuario      = $conn->real_escape_string($_POST['usuario']);
    $senha        = $conn->real_escape_string($_POST['senha']); // Hash da senha
    $nome_usuario = $conn->real_escape_string($_POST['nome_usuario']);
    $sn_user_adm  = $conn->real_escape_string($_POST['sn_user_adm']);

    // Cria a query SQL para inserir os dados
    $sql = "INSERT INTO usuarios (Nome_empresa, USUARIO, SENHA, NOME_USUARIO, SN_USER_ADM) VALUES (?, ?, ?, ?, ?)";

    // Prepara a query para execução
    if ($stmt = $conn->prepare($sql)) {
        // Vincula os parâmetros (s = string)
        $stmt->bind_param("sssss", $nome_empresa, $usuario, $senha, $nome_usuario, $sn_user_adm);

        // Executa a query
        if ($stmt->execute()) {
            // Redireciona para index.php se o cadastro for bem-sucedido
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='index.php';</script>";
        } else {
            // Redireciona para usuario_cadastro.php se houver falha no cadastro
            echo "<script>alert('Erro ao cadastrar usuário: " . addslashes($stmt->error) . "'); window.location.href='usuario_cadastro.php';</script>";
        }
        

        // Fecha o statement
        $stmt->close();
    } else {
        echo "Erro ao preparar a query: " . $conn->error;
    }

    // Fecha a conexão
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .menu-btn {
            background-color: #007bff;
            border: none;
            padding: 8px 15px;
            color: white;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }
        .navbar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        .navbar a, .dropdown-btn {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 25px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .navbar a:hover, .dropdown-btn:hover {
            background-color: #ddd;
            color: black;
        }
        .dropdown-container {
            display: none;
            background-color: #262626;
            padding-left: 8px;
        }
        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            color: white;
        }
        form {
            max-width: 300px;
            margin: 100px auto 50px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"], input[type="number"], select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"], button[type="button"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: calc(50% - 11px);
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
        }
        button[type="button"] {
            background-color: #f44336;
            color: white;
            float: right;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Império</h1>
    <button class="menu-btn" onclick="toggleNav()">☰</button>
</div>

<div id="myNavbar" class="navbar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="javascript:void(0)" class="dropdown-btn">Cadastros</a>
    <div class="dropdown-container">
        <a href="usuario_cadastro.php">Usuário</a>
        <a href="Cadastro_item.php">Item</a>
        
    </div>
    <a href="Cardapio.php?e='ADEGAS016'">Cardápio</a>

<script>
    function toggleNav() {
        var navbar = document.getElementById("myNavbar");
        if (navbar.style.width === "250px") {
            navbar.style.width = "0";
        } else {
            navbar.style.width = "250px";
        }
    }

    function closeNav() {
        document.getElementById("myNavbar").style.width = "0";
    }

    var dropdown = document.getElementsByClassName("dropdown-btn");
    for (var i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>

<form action="" method="POST">
    <label for="nome_empresa">Nome da Empresa:</label>
    <input type="text" id="nome_empresa" name="nome_empresa" required autocomplete="off">

    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario" required autocomplete="off">

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required autocomplete="off">

    <label for="nome_usuario">Nome Completo do Usuário:</label>
    <input type="text" id="nome_usuario" name="nome_usuario" autocomplete="off">

    <label for="sn_user_adm">Usuário ADM:</label>
    <select id="sn_user_adm" name="sn_user_adm" required>
        <option value="SIM">SIM</option>
        <option value="NÃO">NAO</option>
    </select>

    <input type="submit" value="Cadastrar">
    <button type="button" onclick="alert('Cancelado!');">Cancelar</button>
</form>

</body>
</html>
