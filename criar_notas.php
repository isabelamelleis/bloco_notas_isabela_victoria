<?php
 
    include 'db_connect.php';

    $sql_usuario = "SELECT id_usuario, email_usuario FROM usuario";
    $result_usuario = $conn -> query($sql_usuario);

    $sql_enum = "SELECT prioridade_nota FROM usuario";
    $result_enum = $conn -> query($sql_enum);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>
</head>
<body>
    <form action="criar_notas.php" method="POST">
        <label for="titulo_nota">Título:</label>
        <input type="text" name="titulo_nota" placeholder="Escreva o título da nota" required>
        <label for="prioridade">Prioridade:</label>
        <select name="prioridade" required>
            <option selected disabled>Selecione</option>

            <?php

                if ($result_enum ->  num_rows > 0) {
                    while($row = $result_enum -> fetch_assoc()) {
                        echo "<option value='{$row['id_nota']}'>{$row['prioridade_nota']}</option>";
                    }
                } else {
                    echo "<option disabled>Nenhum usuário encontrado</option>";
                }

            ?>

        </select>
        <label for="usuario">Usuário:</label>
        <select name="usuario" required>
            <option selected disabled>Selecione</option>

            <?php

                if ($result_usuario ->  num_rows > 0) {
                    while($row = $result_usuario -> fetch_assoc()) {
                        echo "<option value='{$row['id_usuario']}'>{$row['email_usuario']}</option>";
                    }
                } else {
                    echo "<option disabled>Nenhum usuário encontrado</option>";
                }

            ?>

        </select>
        <br>
        <br>
        <textarea name="nota" rows="20" cols="80" placeholder="Escreva sua nota..."></textarea>
        <br>
        <button type="submit" name="salvar_nota">
            Salvar ✔
        </button>
    </form>
</body>
</html>

<?php

    include 'db_connect.php';

    if(isset($_POST['salvar_nota'])) {
        $titulo_nota = $_POST['titulo_nota'];
        $prioridade = $_POST['prioridade'];
        $anotacao = $_POST['anotacao'];
        
        
    }

?>