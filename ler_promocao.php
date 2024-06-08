<?php
include 'functions.php';
// Conectar ao banco de dados PostgreSQL
$pdo = pdo_connect_pgsql();
// Obter a página via solicitação GET (parâmetro URL: page), se não existir, defina a página como 1 por padrão
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Número de registros para mostrar em cada página
$records_per_page = 5;

// Preparar a instrução SQL e obter registros da tabela contacts, LIMIT irá determinar a página
$stmt = $pdo->prepare('SELECT * FROM promocoes ORDER BY id_promocao OFFSET :offset LIMIT :limit');
$stmt->bindValue(':offset', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Buscar os registros para exibi-los em nosso modelo.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obter o número total de contatos, isso é para determinar se deve haver um botão de próxima e anterior
$num_contacts = $pdo->query('SELECT COUNT(*) FROM promocoes')->fetchColumn();
?>


<?= template_header('Visualizar promocao') ?>

<div class="content read">
    <h2>Visualizar Promoção</h2>
    <a href="criar_promocao.php" class="create-contact">Registrar Promoção</a>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nome da Promoção</th>
                <th>Descrição Promoção</th>
                <th>% Desconto</th>
                <th>Data Inicio</th>
                <th>Data Final</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact) : ?>
                <tr>
                <td><?=$contact['id_promocao']?></td>
                            <td><?=$contact['nome_promocao']?></td>
                            <td><?=$contact['descricao']?></td>
                            <td><?=$contact['desconto']?></td>
                            <td><?=$contact['data_inicio']?></td>
                            <td><?=$contact['data_fim']?></td>
                    <td class="actions">
                        <a href="alterar_promocao.php?id=<?= $contact['id_promocao'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="apagar_promocao.php?id=<?= $contact['id_promocao'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1) : ?>
            <a href="ler_promocao.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page * $records_per_page < $num_contacts) : ?>
            <a href="ler_promocao.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?= template_footer() ?>