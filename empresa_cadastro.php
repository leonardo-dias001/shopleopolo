<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'banco.php';  // Inclui o arquivo de conexão com o banco

    $nome_empresa = $_POST['nome_empresa'];
    $whatsapp = $_POST['whatsapp'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $query = "INSERT INTO empresas (Nome_empresa, WHATZAP, ENDERECO_COMPLETO, CIDADE, ESTADO)
              VALUES (?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("sssss", $nome_empresa, $whatsapp, $endereco, $cidade, $estado);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Erro ao preparar statement: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Empresa</title>
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
        input[type="text"], input[type="number"], textarea {
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
        <a href="#">Usuário</a>
        <a href="#">Empresa</a>
    </div>
    <a href="#">Financeiro</a>
</div>

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
    <input type="text" id="nome_empresa" name="nome_empresa" required>

    <label for="whatsapp">WhatsApp:</label>
    <input type="text" id="whatsapp" name="whatsapp">

    <label for="endereco">Endereço Completo:</label>
    <input type="text" id="endereco" name="endereco">

    <label for="cidade">Cidade:</label>
    <input type="text" id="cidade" name="cidade">

    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado">

    <input type="submit" value="Cadastrar">
    <button type="button" onclick="alert('Cancelado!');">Cancelar</button>
</form>

</body>
</html>
