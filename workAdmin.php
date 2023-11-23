<?php
$hii = "hii!";
$pdo = new PDO('mysql:host=localhost;dbname=recados', 'root', '');

if (isset($_POST['nome'])) {
    $nome_usuario = $_POST['nome'];
    $mensagem = $_POST['recado'];

    $sql = $pdo->prepare("INSERT INTO sua_tabela (usuario, mensagem) VALUES (:usuario, :mensagem)");
    $sql->execute(array(':usuario' => $nome_usuario, ':mensagem' => $mensagem));
}

if (isset($_POST['apagar'])) {
    $sql = $pdo -> prepare ("DELETE FROM sua_tabela");
    $sql ->execute();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>digite o nome e recado</h1>
<form method="POST">
    <input type="text" name="nome">
    <input type="text" name="recado">
    <input type="submit" value="enviar">
    <input type="submit" value ="apagar todos recados" name = "apagar">
</form>


</body>
</html>

<?php

    $sql = $pdo->prepare("SELECT * FROM sua_tabela");
    $sql->execute();

    $recadosEnomes = $sql->fetchAll();
    foreach ($recadosEnomes as $key => $value) {
            echo $value['usuario'] ."  |  " . $value['mensagem'] . "<br>";
    }

?>
