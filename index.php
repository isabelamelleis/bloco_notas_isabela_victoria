<?php

    include 'db_connect.php';

    $sql_read = "SELECT id_nota, titulo_nota, anotacao, data_nota, prioridade_nota, email_usuario FROM nota INNER JOIN usuario ON id_usuario = fk_usuario";
    $result_read = $conn -> query($sql_read);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloco de notas</title>
</head>
<body>
    <h1>
        Notas
    </h1>
    <a href="criar_notas.php"><button>+</button></a>
    <br><br>
    <?php

        if ($result_read -> num_rows > 0) {
            echo"<table border='1'>
            <tr>
                    <th> Título </th>
                    <th> Anotação </th>
                    <th> Prioridade </th>
                    <th> Usuário </th>
                    <th> Data de criação </th>
            </tr>";
            while($row = $result_read -> fetch_assoc()){
                echo "<tr>
                    <td> {$row['titulo_nota']} </td>
                    <td> {$row['anotacao']} </td>
                    <td> {$row['prioridade_nota']} </td>
                    <td> {$row['email_usuario']} </td>
                    <td> {$row['data_nota']} </td>
                    <td>
                        <a href='update_notas.php?editar_id={$row['id_nota']}'>&#128393;</a> |
                        <a href='index.php?deletar_id={$row['id_nota']}'>&#128465;</a>
                    </td>
                    </tr>";
        }
            echo "</table>";
        } else{
                echo "Está vazio :(";
        }

    ?>
</body>
</html>

<?php

    if(isset($_GET['deletar_id'])) {

        $id_nota = $_GET['deletar_id'];
        $sql_deletar = "DELETE FROM nota WHERE id_nota = '$id_nota'";
        header('Location: index.php');

        if ($conn -> query($sql_deletar) === TRUE) {
            echo "<br> Dados excluídos com sucesso.";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn -> close();
?>