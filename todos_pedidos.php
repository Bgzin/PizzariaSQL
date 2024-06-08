<?php
include 'functions.php';

$pdo = pdo_connect_pgsql();

$stmt = $pdo->query('
    SELECT 
        c.id_contato, 
        c.nome AS nome_cliente, 
        c.email, 
        c.cel, 
        c.pizza
    FROM 
        contatos c 
');

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Pedidos')?>

<div class="content read">
    <h2>Pedidos</h2>
    <table>
        <thead>
            <tr>
                <td>ID Cliente</td>
                <td>Nome do Cliente</td>
                <td>Email</td>
                <td>Celular</td>
                <td>Pizza</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?= $cliente['id_contato'] ?></td>
                <td><?= $cliente['nome_cliente'] ?></td>
                <td><?= $cliente['email'] ?></td>
                <td><?= $cliente['cel'] ?></td>
                <td><?= $cliente['pizza'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>