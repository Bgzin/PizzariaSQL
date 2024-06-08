<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';
// Verifica se o ID da promoção existe
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Obtém os dados do formulário
        $id_promocao = isset($_POST['id_promocao']) ? $_POST['id_promocao'] : NULL;
        $nome_promocao = isset($_POST['nome_promocao']) ? $_POST['nome_promocao'] : '';
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $desconto = isset($_POST['desconto']) ? $_POST['desconto'] : '';
        $data_inicio = isset($_POST['data_inicio']) ? $_POST['data_inicio'] : '';
        $cadastro = isset($_POST['cadastro']) ? $_POST['cadastro'] : date('Y-m-d H:i:s');
        $data_fim = isset($_POST['data_fim']) ? $_POST['data_fim'] : date('Y-m-d H:i:s');
        // Atualiza o registro
        $stmt = $pdo->prepare('UPDATE promocoes SET nome_promocao = ?, descricao = ?, desconto = ?, data_inicio = ?, cadastro = ?, data_fim = ? WHERE id_promocao = ?');
        $stmt->execute([$nome_promocao, $descricao, $desconto, $data_inicio, $cadastro, $data_fim, $_GET['id']]);
        $msg = 'Atualização Realizada com Sucesso!';
    }
    // Obter os dados da promoção
    $stmt = $pdo->prepare('SELECT * FROM promocoes WHERE id_promocao = ?');
    $stmt->execute([$_GET['id']]);
    $promocao = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$promocao) {
        exit('Promoção Não Localizada!');
    }
} else {
    exit('Nenhuma Promoção Especificada!');
}
?>

<?=template_header('Atualizar/Alterar Promoção')?>

<div class="content update">
    <h2>Atualizar Promoção - <?=$promocao['nome_promocao']?></h2>
    <form action="alterar_promocao.php?id=<?=$promocao['id_promocao']?>" method="post">
        <label for="id_promocao">ID</label>
        <label for="nome_promocao">Nome</label>
        <input type="text" name="id_promocao" value="<?=$promocao['id_promocao']?>" readonly>
        <input type="text" name="nome_promocao" placeholder="Nome da Promoção" value="<?=$promocao['nome_promocao']?>" id="nome_promocao">
        <label for="descricao">Descrição</label>
        <label for="desconto">Desconto</label>
        <input type="text" name="descricao" placeholder="Descrição" value="<?=$promocao['descricao']?>" id="descricao">
        <input type="text" name="desconto" placeholder="Desconto" value="<?=$promocao['desconto']?>" id="desconto">
        <label for="data_inicio">Data de Início</label>
        <label for="data_fim">Data Final</label>
        <input type="datetime-local" name="data_inicio" value="<?=$promocao['data_inicio']?>" id="data_inicio">
        <input type="datetime-local" name="data_fim" value="<?=$promocao['data_fim']?>" id="data_fim">
        <input type="submit" value="Atualizar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
