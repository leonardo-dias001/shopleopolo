<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cardápio Online</title>
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background: #f4f4f4;
    }
    .nav-bar {
        background: #555;
        color: white;
        padding: 10px 0;
        text-align: center;
    }
    .nav-bar a {
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        display: inline-block;
    }
    .menu-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Correção para dispositivos móveis */
        gap: 20px;
        padding: 20px;
        margin: 20px auto;
        max-width: 1200px;
    }
    .menu-item {
        background: white;
        border: 1px solid #ddd;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .menu-item img {
        width: auto;
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .menu-item-info {
        text-align: center;
    }
    .menu-item h3, .menu-item p, .price {
        margin: 5px 0;
    }
    .price {
        color: green;
        font-weight: bold;
    }
    .item-actions {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }
    .item-actions button {
        padding: 5px 10px;
        margin: 0 5px;
        background-color: lightgray;
        border: none;
        cursor: pointer;
    }
    .item-actions button.decrease {
        color: red;
    }
    .item-actions button.increase {
        color: green;
    }
    .quantity {
        min-width: 20px;
        text-align: center;
    }
    .cart-info {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: white;
        border-top: 1px solid #ddd;
        padding: 10px;
        box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .cart-buttons {
        display: flex;
    }
    .cart-buttons button {
        padding: 10px 20px;
        margin: 0 5px;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .finalize-btn {
        background-color: #5cb85c;
        color: white;
        border-color: #4cae4c;
    }
    .cancel-btn {
        background-color: #d9534f;
    }
    .cart-buttons button:hover {
        opacity: 0.85;
    }
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 400px;
        width: 100%;
    }
    .modal-content label,
    .modal-content input {
        display: block;
        margin-bottom: 10px;
    }
    .modal-content input {
        width: calc(100% - 20px);
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .modal-content button {
        padding: 10px 20px;
        margin-top: 10px;
        background-color: #5cb85c;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>
</head>
<body>

<div class="nav-bar">
    <a href="#">Itens</a>
    
</div>

<div class="menu-section">
    <!-- Exemplo de item do cardápio -->
<?php

    include 'banco.php'; // Incluindo o arquivo de conexão

    // Consulta ao banco de dados
    $sql = "SELECT titulo, descricao, foto, valor_venda FROM itens";
    $result = $conn->query($sql); // Usando o MySQLi

// Verificar se há resultados
    if ($result->num_rows > 0) {
        // Iteração sobre os resultados e criação das divs dos itens do menu
        while ($item = $result->fetch_assoc()) {
            echo '<div class="menu-item">';
            echo '<img src="uploads/' . htmlspecialchars($item['foto']) . '" alt="' . htmlspecialchars($item['titulo']) . '">';
            echo '<div class="menu-item-info">';
            echo '<h3>' . htmlspecialchars($item['titulo']) . '</h3>';
            echo '<p>' . htmlspecialchars($item['descricao']) . '</p>';
            echo '<p class="price">R$ ' . htmlspecialchars(number_format($item['valor_venda'], 2, ',', '.')) . '</p>';
            echo '</div>';
            echo '<div class="item-actions">';
            echo '<button class="decrease">-</button>';
            echo '<span class="quantity">0</span>';
            echo '<button class="increase">+</button>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "0 resultados";
    }

        // Fechar a conexão
        $conn->close();
        ?>
            <!-- Repita a estrutura .menu-item para outros itens do menu -->
        </div>

        <div class="cart-info">
            <div>Total Itens: <span class="total-items">0</span> | Total Preço: R$<span class="total-price">0,00</span></div>
            <div class="cart-buttons">
                <button class="finalize-btn">Finalizar</button>
                <button class="cancel-btn">Cancelar</button>
            </div>
        </div>

<!-- Modal para coletar endereço -->
<div class="modal" id="address-modal" style="display: none;">
    <div class="modal-content">
        <label>Rua:</label>
        <input type="text" id="street" name="street" required>
        <label>Tipo Local:</label>
        <input type="text" id="type" name="type" required>
        <label>Número:</label>
        <input type="text" id="number" name="number" required>
        <label>Troco para:</label>
        <input type="text" id="change" name="change" required>
        <button id="submit-address">Enviar</button>
        <button id="close-address-modal" style="float: right; color: red; background: none; border: none;">X</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const items = document.querySelectorAll('.menu-item');
    let totalItems = 0;
    let totalPrice = 0;
    let orderDescription = '';

    items.forEach(item => {
        const decreaseButton = item.querySelector('.decrease');
        const increaseButton = item.querySelector('.increase');
        const quantitySpan   = item.querySelector('.quantity');
        const price = parseFloat(item.querySelector('.price').textContent.replace('R$', '').replace(',', '.'));
        const itemName = item.querySelector('h3').textContent;
        const itemDescription = item.querySelector('p').textContent;

        decreaseButton.addEventListener('click', function() {
            let currentQuantity = parseInt(quantitySpan.textContent);
            if (currentQuantity > 0) {
                quantitySpan.textContent = currentQuantity - 1;
                totalItems--;
                totalPrice -= price;
                updateCartInfo();
            }
        });

        increaseButton.addEventListener('click', function() {
            quantitySpan.textContent = parseInt(quantitySpan.textContent) + 1;
            totalItems++;
            totalPrice += price;
            updateCartInfo();
        });
    });

    function updateCartInfo() {
        document.querySelector('.total-items').textContent = totalItems;
        document.querySelector('.total-price').textContent = totalPrice.toFixed(2).replace('.', ',');
    }

    const finalizeButton = document.querySelector('.finalize-btn');
    const cancelButton = document.querySelector('.cancel-btn');

    finalizeButton.addEventListener('click', function() {
        const addressModal = document.getElementById('address-modal');
        addressModal.style.display = 'flex';
    });

    const closeButton = document.getElementById('close-address-modal');
    closeButton.addEventListener('click', function() {
        const addressModal = document.getElementById('address-modal');
        addressModal.style.display = 'none';
    });

    const submitButton = document.getElementById('submit-address');
    submitButton.addEventListener('click', function() {
        const street = document.getElementById('street').value;
        const type   = document.getElementById('type').value;
        const number = document.getElementById('number').value;
        const change = document.getElementById('change').value;

        const message = `Olá, segue abaixo o meu pedido:\n\nItens:\n${orderDescription}\nLocal de entrega:\nRua: ${street}, ${type}, ${number}\nTroco para: ${change}\nTotal Preço: R$${totalPrice.toFixed(2).replace('.', ',')}`;

        console.log('Endereço do cliente:', street, type, number, 'Troco para:', change);
        console.log('Mensagem a enviar:', message);

        // Abre a conversa no WhatsApp com o número correto
        window.open('https://wa.me/5516991713186?text=' + encodeURIComponent(message));

        const addressModal = document.getElementById('address-modal');
        addressModal.style.display = 'none';

        // Limpar variáveis do pedido após finalizar
        totalItems = 0;
        totalItems = 0;
        totalPrice = 0;
        currentQuantity = 0; 
        orderDescription = '';
        updateCartInfo();

        //VOLTA QUANTIDADE DO ITEM PARA 0 
        document.querySelectorAll('.quantity').forEach(quantitySpan => quantitySpan.textContent = '0');

        alert('Pedido finalizado com sucesso!');
    });

    cancelButton.addEventListener('click', function() {
        totalItems = 0;
        totalPrice = 0;
        orderDescription = '';
        document.querySelectorAll('.quantity').forEach(function(quantitySpan) {
            quantitySpan.textContent = '0';
        });
        updateCartInfo();
        alert('Pedido cancelado.');
    });
});
</script>

</body>
</html>
