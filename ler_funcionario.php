<?php
include 'functions.php';
// Conectar ao banco de dados PostgreSQL
$pdo = pdo_connect_pgsql();
// Obter a página via solicitação GET (parâmetro URL: page), se não existir, defina a página como 1 por padrão
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Número de registros para mostrar em cada página
$records_per_page = 5;

// Preparar a instrução SQL e obter registros da tabela contacts, LIMIT irá determinar a página
$stmt = $pdo->prepare('SELECT * FROM funcionarios ORDER BY id_funcionario OFFSET :offset LIMIT :limit');
$stmt->bindValue(':offset', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Buscar os registros para exibi-los em nosso modelo.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obter o número total de contatos, isso é para determinar se deve haver um botão de próxima e anterior
$num_contacts = $pdo->query('SELECT COUNT(*) FROM funcionarios')->fetchColumn();
?>


<?= template_header('Visualizar funcionario') ?>

<div class="content read">
    <h2>Visualizar Funcionário</h2>
    <a href="criar_funcionario.php" class="create-contact">Registrar Funcionário</a>
    <table>
        <thead>
            <tr>
                <th># Funcionario</th>
                <th>Nome</th>
                <th># Supervisor</th>
                <th>Atribuição</th>
                <th>Área de Trabalho</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact) : ?>
                <tr>
                    <td><?= $contact['id_funcionario'] ?></td>
                    <td><?= $contact['id_funcionario'] ?></td>
                    <td><?= $contact['nome'] ?></td>
                    <td><?= $contact['id_supervisor'] ?></td>
                    <td><?= $contact['atribuicoes'] ?></td>
                    <td><?= $contact['areas_trabalho'] ?></td>
                    <td class="actions">
                        <a href="alterar_funcionario.php?id=<?= $contact['id_funcionario'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="apagar_funcionario.php?id=<?= $contact['id_funcionario'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1) : ?>
            <a href="ler_funcionario.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page * $records_per_page < $num_contacts) : ?>
            <a href="ler_funcionario.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?= template_footer() ?>