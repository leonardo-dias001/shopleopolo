<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel ADM</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f4f4f4; /* Cor de fundo igual à primeira página */
        }
        .header {
            background-color: #333;
            color: white;
            padding: 10px 20px; /* Padding original da primeira página */
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px; /* Tamanho de fonte igual ao da primeira página */
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
            top: 50%; /* Alinhamento vertical centralizado */
            transform: translateY(-50%); /* Transformação para centralizar verticalmente */
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
        @media screen and (max-width: 768px) {
            .header h1 {
                font-size: 18px; /* Ajuste o tamanho do texto conforme necessário */
            }
            .menu-btn {
                padding: 8px 10px; /* Padding reduzido para telas menores */
                font-size: 16px; /* Tamanho da fonte reduzido para telas menores */
                position: absolute;
                top: 50%; /* Posicionar no meio verticalmente */
                transform: translateY(-50%); /* Deslocar para cima pela metade de sua altura para centralizar */
            }
            .navbar a, .dropdown-btn {
                font-size: 18px; /* Tamanho da fonte reduzido para os itens do menu em telas menores */
            }
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

    for (i = 0; i < dropdown.length; i++) {
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

</body>
</html>
