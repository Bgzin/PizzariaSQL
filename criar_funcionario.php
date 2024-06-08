<?php
include 'functions.php';
$pdo = pdo_connect_pgsql();
$msg = '';
// Verifica se os dados POST não estão vazios
if (!empty($_POST)) {
    // Se os dados POST não estiverem vazios, insere um novo registro
    // Configura as variáveis que serão inserid_entregasas. Devemos verificar se as variáveis POST existem e, se não existirem, podemos atribuir um valor padrão a elas.
    $id_funcionario = isset($_POST['id_funcionario']) && !empty($_POST['id_funcionario']) && $_POST['id_funcionario'] != 'auto' ? $_POST['id_funcionario'] : NULL;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $id_supervisor = isset($_POST['id_supervisor']) ? $_POST['id_supervisor'] : '';
    $atribuicoes = isset($_POST['atribuicoes']) ? $_POST['atribuicoes'] : '';
    $areas_trabalho = isset($_POST['areas_trabalho']) ? $_POST['areas_trabalho'] : '';
    // Insere um novo registro na tabela contacts
    $stmt = $pdo->prepare('INSERT INTO promocoes (id_funcionario, nome, id_supervisor, atribuicoes, areas_trabalho) VALUES (?, ?, ?, ?,?)');
    $stmt->execute([$id_funcionario, $nome, $id_supervisor, $atribuicoes, $areas_trabalho]);
    // Mensagem de saída
    $msg = 'Funcionario Realizado com Sucesso!';
}
?>


<?= template_header('Cadastro Funcionario') ?>

<div class="content update">
    <h2>Registrar Funcionario</h2>
    <form action="criar_promocao.php" method="post">
        <label for="id_funcionario">ID do Funcionario</label>
        <label for="nome">Nome do Funcionario</label>
        <input type="text" name="id_funcionario" placeholder="" value="" id_funcionario="id_funcionario">
        <input type="text" name="nome" placeholder="Nome do Funcionário" id_funcionario="nome">
        <label for="id_supervisor">ID do Supervisor</label>
        <label for="atribuicoes">Atribuições</label>
        <input type="text" name="id_supervisor" placeholder="Descrição" id_funcionario="id_supervisor">
        <input type="text" name="atribuicoes" placeholder="Atribuição" id_funcionario="atribuicoes">
        <input type="submit" value="Cadastrar Funcionario">
    </form>
    <?php if ($msg) : ?>
        <p><?= $msg ?></p>
    <?php endif; ?>
</div>

<?= template_footer() ?>