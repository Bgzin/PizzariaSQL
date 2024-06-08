<?php
    include 'functions.php';
  
    // Verificar se foi feita uma pesquisa
    if(isset($_GET['search'])) {
        // Conectar ao banco de dados PostgreSQL
        $pdo = pdo_connect_pgsql();

        // Preparar a consulta SQL para buscar as pizzas com o sabor selecionado
        $search = '%' . $_GET['search'] . '%';
        $stmt = $pdo->prepare('SELECT * FROM funcionarios WHERE nome LIKE :search');
        $stmt->bindValue(':search', $search, PDO::PARAM_STR);
        $stmt->execute();

        // Obter os resultados da consulta
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar se foram encontrados resultados
        if(empty($contacts)) {
            $error = 'Nenhum funcionario encontrado.';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultados da Pesquisa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 300px;
            margin-bottom: 10px;
        }
        button[type="submit"], button[type="button"] {
            padding: 8px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #45a049;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <?=template_header('Pizzaria Matheus')?><br><br>
    <div class="content read">
        <form class="" id="searchForm" action="" method="get">
            <label for="search">Pesquisar por funcionario:</label>
            <select id="search" name="search">
                <option value="">Selecione o funcionario...</option>
                <?php
                    // Conectar ao banco de dados PostgreSQL
                    $pdo = pdo_connect_pgsql();

                    // Preparar a consulta SQL para obter os sabores de pizza
                    $stmt = $pdo->query('SELECT DISTINCT nome FROM funcionarios');
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($_GET['search'] ?? '') === $row['nome'] ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($row['nome'], ENT_QUOTES) . '" ' . $selected . '>' . htmlspecialchars($row['nome'], ENT_QUOTES) . '</option>';
                    }
                ?>
            </select>
            <button class="create-contact" type="submit" id="searchButton">Pesquisar</button>
            <button type="button" id="clearButton">Limpar</button>
        </form>
    </div>

    <div class="content read">
        <?php if (isset($error)): ?>
            <p class="error"><?=htmlspecialchars($error, ENT_QUOTES)?></p>
        <?php elseif (isset($contacts)): ?>
            <h3>Resultados da Pesquisa</h3>
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
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?=$contact['id_funcionario']?></td>
                            <td><?=$contact['nome']?></td>
                            <td><?=$contact['id_supervisor']?></td>
                            <td><?=$contact['atribuicoes']?></td>
                            <td><?=$contact['areas_trabalho']?></td>
                            <td class="actions">
                    <a href="alterar_funcionario.php?id=<?=$contact['id_funcionario']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="apagar_funcionario.php?id=<?=$contact['id_funcionario']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
                </tbody>
            </table>
            
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('clearButton').addEventListener('click', function() {
            document.getElementById('search').selectedIndex = 0;
        });
    </script>
</body>
</html>
