    <?php
    
        include 'db_connect.php';

        $sql_usuario = "SELECT id_usuario, email_usuario FROM usuario";
        $result_usuario = $conn -> query($sql_usuario);

        // como a coluna prioridade_nota é um campo enum, não se pode apenas usar select para pesquisar essa coluna na tabela, então usamos 'show columns from nota', que busca todas as colunas da tabela nota, e depois 'like "prioridade_nota"', que filtra a coluna prioridade_nota 
        $sql_enum = "SHOW COLUMNS FROM nota LIKE 'prioridade_nota'";
        $result_enum = $conn -> query($sql_enum);

        // o resultado da consulta acima será uma string: "enum('Baixa','Média','Alta')". Por isso, é necessário tirar os parênteses, as aspas e a palavra enum
        if ($result_enum -> num_rows > 0) {
            $row = $result_enum -> fetch_assoc();
            $enum_valores = str_replace("enum('", "", $row['Type']); //str_replace serve para tirar os caracteres que não são desejados na string
            $enum_valores = str_replace("')", "", $enum_valores);
            $enum_valores = explode("','", $enum_valores); // explode está quebrando a string que sobrou e transformando em array
        }

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

                    // loop que percorre o array enum_values e transforma todos os valores do enum em options. Para cada rodada do loop, o valor do item atual do array é armazenado em $valor
                    foreach ($enum_valores as $valor) { 
                        echo "<option value='{$valor}'>{$valor}</option>";
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
                        echo "<option disabled>Nenhum usuário registrado</option>";
                    }

                ?>

            </select>
            <br>
            <br>
            <textarea name="anotacao" rows="20" cols="80" placeholder="Escreva sua nota..."></textarea>
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
            $anotacao = $_POST['anotacao'];
            $prioridade = $_POST['prioridade'];
            $fk_usuario = $_POST['usuario'];
            
            $sql_create = "INSERT INTO nota (titulo_nota, anotacao, prioridade_nota, fk_usuario) VALUES ('$titulo_nota', '$anotacao', '$prioridade', '$fk_usuario')";

            if($conn -> query($sql_create) === TRUE){
                header('Location: index.php');
                exit();
            } else {
                echo "Erro:". $sql."<br>".$conn -> error;
            }
            
        }

    ?>