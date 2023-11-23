<?php
$pdo = new PDO('mysql:host=localhost;dbname=recados', 'root', '');

if (isset($_POST['nome'])) {
    $nome_usuario = $_POST['nome'];
    $mensagem = $_POST['recado'];

    $sql = $pdo->prepare("INSERT INTO sua_tabela (usuario, mensagem) VALUES (:usuario, :mensagem)");
    $sql->execute(array(':usuario' => $nome_usuario, ':mensagem' => $mensagem));
}

if (isset($_POST['apagar'])) {
    $sql = $pdo->prepare("DELETE FROM sua_tabela");
    $sql->execute();
}

if (isset($_POST['uni_msg'])) {
    if (isset($_POST['mensagem_id'])) {
        $mensagem_id = $_POST['mensagem_id'];
        $sql = $pdo->prepare("DELETE FROM sua_tabela WHERE id = :id");
        $sql->bindParam(':id', $mensagem_id, PDO::PARAM_INT);
        $sql->execute();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .recados {
            margin-top: 10px;
            display: flex;
            gap: 16px;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid rgba(0, 0, 0, .5);
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <h1>digite o nome e recado</h1>
    <form method="POST">
        <input type="text" name="nome">
        <input type="text" name="recado">
        <input type="submit" value="enviar">
        <input type="submit" value="apagar todos recados" name="apagar">
    </form>

    <?php
    $sql = $pdo->prepare("SELECT * FROM sua_tabela");
    $sql->execute();

    $recadosEnomes = $sql->fetchAll();
    foreach ($recadosEnomes as $key => $value) :
        echo "<div class ='recados'>";
        echo $value['id'] . "  |  " . $value['usuario'] . "  |  " . $value['mensagem'];
    ?>
        <form method="POST">
            <input type="hidden" name="mensagem_id" value="<?php echo $value['id']; ?>">
            <input type="submit" name="uni_msg" value="apagar esta mensagem">
        </form>

    <?php
        echo "</div>";
    endforeach;
    ?>

</body>

</html>
