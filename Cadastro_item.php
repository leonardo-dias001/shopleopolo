<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inserir Item no Painel ADM</title>
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        background-color: #f4f4f4;
    }
    .header {
        background-color: #333;
        color: white;
        padding: 10px 20px; /* Ajuste na altura do padding */
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .header h1 {
        margin: 0;
        font-size: 24px; /* Ajuste para garantir que o texto não seja muito grande */
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
        transform: translateY(-50%); /* Centrar verticalmente o botão */
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
    input[type="text"], input[type="number"], input[type="file"], textarea {
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
        <a href="Cadastro_item.php">Item</a>
        
    </div>
    <a href="Cardapio.php">Cardápio</a>
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
    var i;

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

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4"></textarea>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/png, image/jpeg">

        <label for="valor_compra">Valor de Compra:</label>
        <input type="number" id="valor_compra" name="valor_compra" step="0.01" min="0">

        <label for="valor_venda">Valor de Venda:</label>
        <input type="number" id="valor_venda" name="valor_venda" step="0.01" min="0">

        <label for="lucro">Lucro:</label>
        <input type="number" id="lucro" name="lucro" step="0.01" min="0">

        <input type="submit" name="cadastrar" value="Inserir Item">
        <button type="button" onclick="alert('Cancelado!');">Cancelar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar'])) {
        include 'banco.php'; // Certifique-se de incluir o arquivo de conexão corretamente

        $titulo      = $_POST['titulo'];
        $descricao   = $_POST['descricao'];
        $fotoNome    = $_FILES['foto']['name'];
        $valorCompra = $_POST['valor_compra'];
        $valorVenda  = $_POST['valor_venda'];
        $lucro       = $_POST['lucro'];

        $diretorioUpload = 'uploads/';
        if (!is_dir($diretorioUpload)) {
            mkdir($diretorioUpload, 0777, true); // Cria o diretório se ele não existir
        }
        $caminhoCompleto = $diretorioUpload . basename($fotoNome);

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto)) {
            echo "O arquivo " . htmlspecialchars(basename($fotoNome)) . " foi carregado.";
        } else {
            echo "Ocorreu um erro ao fazer upload do arquivo.";
        }

        $sql = "INSERT INTO itens (TITULO, DESCRICAO, FOTO, VALOR_COMPRA, VALOR_VENDA, LUCRO) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $titulo, $descricao, $fotoNome, $valorCompra, $valorVenda, $lucro);

        if ($stmt->execute()) {
            echo "Novo registro criado com sucesso.";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>

</body>

</body>
</html>
