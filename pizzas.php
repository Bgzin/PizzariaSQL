<?php
include 'functions.php';

$pdo = pdo_connect_pgsql();

$stmt = $pdo->query('
    SELECT 
        nome,
        ingredientes
    FROM 
        pizzas
');

$pizzas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Pizzas Disponíveis')?>

<div class="content read">
    <h2>Pizzas Disponíveis</h2>
    <table>
        <thead>
            <tr>
                <td>Nome da Pizza</td>
                <td>Ingredientes</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pizzas as $pizza): ?>
            <tr>
                <td><?= $pizza['nome'] ?></td>
                <td><?= $pizza['ingredientes'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?=template_footer()?>