<?php
include 'functions.php';

$pdo = pdo_connect_pgsql();

$stmt = $pdo->query('
    SELECT 
        dia_semana,
        hora_abertura,
        hora_fechamento
    FROM 
        horario_funcionamento
');

$horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Horario de Funcionamento')?>


    <div class="content read">
        <h2>Horário de Funcionamento</h2>
        <table>
            <thead>
                <tr>
                    <td>Dia da Semana</td>
                    <td>Hora de Abertura</td>
                    <td>Hora de Fechamento</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horarios as $horario): ?>
                <tr>
                    <td><?= $horario['dia_semana'] ?></td>
                    <td><?= $horario['hora_abertura'] ?></td>
                    <td><?= $horario['hora_fechamento'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<?=template_footer()?>
