<?php

    include 'db_connect.php';

    $id_editar = $_GET['editar_id'];

    $sql_dados_preenchidos = "SELECT titulo_nota, anotacao, prioridade_nota, fk_usuario, email_usuario FROM nota INNER JOIN usuario ON id_usuario = fk_usuario WHERE id_nota = '$id_editar'";
    $result_dados_preenchidos = $conn -> query($sql_dados_preenchidos);
    $nota = $result_dados_preenchidos -> fetch_assoc(); // fetch_assoc cria um array associativo e atribui à variável $nota

    $sql_usuario = "SELECT id_usuario, email_usuario FROM usuario";
    $result_usuario = $conn -> query($sql_usuario);

    $sql_enum = "SHOW COLUMNS FROM nota LIKE 'prioridade_nota'";
    $result_enum = $conn -> query($sql_enum);

    if ($result_enum -> num_rows > 0) {
        $row = $result_enum -> fetch_assoc();
        $enum_valores = str_replace("enum('", "", $row['Type']);
        $enum_valores = str_replace("')", "", $enum_valores);
        $enum_valores = explode("','", $enum_valores);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titulo_nota = $_POST['titulo_nota'];
        $anotacao = $_POST['anotacao'];
        $prioridade = $_POST['prioridade'];
        $fk_usuario = $_POST['usuario'];

        $sql_update = "UPDATE nota SET titulo_nota = '$titulo_nota', anotacao = '$anotacao', prioridade_nota = '$prioridade', fk_usuario = '$fk_usuario' WHERE id_nota = '$id_editar'";

        if ($conn -> query($sql_update) === TRUE) {
            echo "Atualização realidada com sucesso <br> <br>";
        }

        $conn -> close();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar nota</title>
</head>
<body>
    <form action="update_notas.php?editar_id=<?php echo $id_editar; ?>" method="POST">
        <label for="titulo_nota">Título:</label>
        <input type="text" name="titulo_nota" value="<?php echo $nota['titulo_nota']; ?>" placeholder="Escreva o título da nota" required> <!-- value, neste caso, faz com que o título da nota seja preenchido automaticamente com o valor atual após clicar no id para update (no index) -->
        <label for="prioridade">Prioridade:</label>
        <select name="prioridade" required>
            <option selected disabled>Selecione</option>

            <?php

                foreach ($enum_valores as $valor) { 
                    $selected = ($nota['prioridade_nota'] == $valor) ? 'selected' : ''; // basicamente, essa parte verifica se o valor de 'prioridade' da nota (que deve estar guardado dentro da variável $nota) é igual ao valor ($valor) do loop atual, que está relacionado aos valores enum da coluna de prioridade_nota. Se os valores são iguais, a option que parou no loop vai ser selecionada ('selected')
                    echo "<option value='{$valor}' {$selected}>{$valor}</option>";
                }

            ?>

        </select>
        <label for="usuario">Usuário:</label>
        <select name="usuario" required>
            <option selected disabled>Selecione</option>

            <?php

                if ($result_usuario -> num_rows > 0) {
                    while($row = $result_usuario -> fetch_assoc()) {
                        $selected = ($nota['fk_usuario'] == $row['id_usuario']) ? 'selected' : '';
                        echo "<option value='{$row['id_usuario']}' {$selected}>{$row['email_usuario']}</option>";
                    }
                } else {
                    echo "<option disabled>Nenhum usuário registrado</option>";
                }

            ?>

        </select>
        <br>
        <br>
        <textarea name="anotacao" rows="20" cols="80" placeholder="Escreva sua nota..."><?php echo $nota['anotacao']; ?></textarea>
        <br>
        <button type="submit" name="salvar_nota">
            Salvar ✔
        </button>
        <br>
        <br>
        <a href="index.php">Ver todas as notas</a>
        <br>
        <br>
    </form>
</body>
</html>