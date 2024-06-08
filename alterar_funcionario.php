<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';
// Verifica se o ID da Funcionario existe
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // Obtém os dados do formulário
        $id_funcionario = isset($_POST['id_funcionario']) ? $_POST['id_funcionario'] : NULL;
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $id_supervisor = isset($_POST['id_supervisor']) ? $_POST['id_supervisor'] : '';
        $atribuicoes = isset($_POST['atribuicoes']) ? $_POST['atribuicoes'] : '';
        $areas_trabalho = isset($_POST['areas_trabalho']) ? $_POST['areas_trabalho'] : '';
        // Atualiza o registro
        $stmt = $pdo->prepare('UPDATE funcionarios SET nome = ?, id_supervisor = ?, atribuicoes = ?, areas_trabalho = ? WHERE id_funcionario = ?');
        $stmt->execute([$nome, $id_supervisor, $atribuicoes, $areas_trabalho, $_GET['id']]);
        $msg = 'Atualização Realizada com Sucesso!';
    }
    // Obter os dados da Funcionario
    $stmt = $pdo->prepare('SELECT * FROM funcionarios WHERE id_funcionario = ?');
    $stmt->execute([$_GET['id']]);
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$funcionario) {
        exit('Funcionario Não Localizado!');
    }
} else {
    exit('Nenhum Funcionario Especificado!');
}
?>

<?=template_header('Atualizar/Alterar Funcionario')?>

<div class="content update">
    <h2>Atualizar Funcionario - <?=$funcionario['nome']?></h2>
    <form action="alterar_funcionario.php?id=<?=$funcionario['id_funcionario']?>" method="post">
        <label for="id_funcionario">ID Funcionario</label>
        <label for="nome">Nome do Funcionario</label>
        <input type="text" name="id_funcionario" value="<?=$funcionario['id_funcionario']?>" readonly>
        <input type="text" name="nome" placeholder="Nome do Funcionario" value="<?=$funcionario['nome']?>" id="nome">
        <label for="id_supervisor">ID Supervisor</label>
        <label for="atribuicoes">Atribuições</label>
        <input type="text" name="id_supervisor" placeholder="ID Supervisor" value="<?=$funcionario['id_supervisor']?>" id="id_supervisor">
        <input type="text" name="atribuicoes" placeholder="Atribuições" value="<?=$funcionario['atribuicoes']?>" id="atribuicoes">
        <label for="areas_trabalho">Area de Trabalho</label>
        <label></label>
        <input type="text" name="areas_trabalho" value="<?=$funcionario['areas_trabalho']?>" id="areas_trabalho">
        <label></label>
        <input type="submit" value="Atualizar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
