<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';
// Verifica se os dados POST não estão vazios
if (!empty($_POST)) {
    // Se os dados POST não estiverem vazios, insere um novo registro
    // Configura as variáveis que serão inserid_entregasas. Devemos verificar se as variáveis POST existem e, se não existirem, podemos atribuir um valor padrão a elas.
    $id_promocao = isset($_POST['id_promocao']) && !empty($_POST['id_promocao']) && $_POST['id_promocao'] != 'auto' ? $_POST['id_promocao'] : NULL;
    $nome_promocao = isset($_POST['nome_promocao']) ? $_POST['nome_promocao'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $desconto = isset($_POST['desconto']) ? $_POST['desconto'] : '';
    $data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : '';
    $cadastro = isset($_POST['cadastro']) ? $_POST['cadastro'] : date('Y-m-d H:i:s');
    $data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : date('Y-m-d H:i:s');
    // Insere um novo registro na tabela contacts
    $stmt = $pdo->prepare('INSERT INTO promocoes (id_promocao, nome_promocao, descricao, desconto, data_inicio, cadastro, data_fim) VALUES (?, ?, ?, ?, ?, ?,?)');
    $stmt->execute([$id_promocao, $nome_promocao, $descricao, $desconto, $data_inicio, $cadastro, $data_fim]);
    // Mensagem de saída
    $msg = 'Promoção Realizada com Sucesso!';
}
?>


<?= template_header('Cadastro Promoção') ?>

<div class="content update">
    <h2>Registrar Promoção</h2>
    <form action="criar_promocao.php" method="post">
        <label for="id_promocao">ID</label>
        <label for="nome_promocao">Nome da Promoção</label>
        <input type="text" name="id_promocao" placeholder="" value="" id_promocao="id_promocao">
        <input type="text" name="nome_promocao" placeholder="Nome da Promoção" id_promocao="nome_promocao">
        <label for="descricao">Descrição</label>
        <label for="desconto">Desconto</label>
        <input type="text" name="descricao" placeholder="Descrição" id_promocao="descricao">
        <input type="text" name="desconto" placeholder="% do desconto" id_promocao="desconto">
        <input type="datetime-local" name="data_inicio" value="<?= date('Y-m-d\TH:i') ?>" id_promocao="data_inicio">
        <input type="datetime-local" name="data_fim" value="<?= date('Y-m-d\TH:i') ?>" id_promocao="data_fim">
        <input type="submit" value="Cadastrar Promoção">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>