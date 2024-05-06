<?php
require_once("../config/connect.php");

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = isset($_POST["nome"]) ? $_POST["nome"] : '';
    $cpf = isset($_POST["cpf"]) ? $_POST['cpf'] : '';
    $nivel_satisfacao = isset($_POST["nivel_satisfacao"]) ? $_POST["nivel_satisfacao"] : '';

    if (empty($nome) || empty($cpf) || empty($nivel_satisfacao)) {
        $msg = "Por favor preencha todos os campos";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO teste (nome, cpf, nivel_satisfacao) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $nome, PDO::PARAM_STR);
            $stmt->bindParam(2, $cpf, PDO::PARAM_STR);
            $stmt->bindParam(3, $nivel_satisfacao, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: success.php");
                exit();
            } else {
                header("Location: error.php");
                exit();
            }
        } catch (PDOException $e) {
            $msg = "Erro: " . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário com Bootstrap</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/app.css">
</head>

<body>
    <div class="container">
        <h1>PESQUISA</h1>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Formulário de Pesquisa</div>
                    <div class="card-body">
                        <form method="POST" action="index.php">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control mb-3" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF:</label>
                                <input type="text" class="form-control mb-3" id="cpf" name="cpf" required>
                            </div>
                            <div class="form-group">
                                <label for="nivel_satisfacao">Nível de Satisfação:</label>
                                <select class="form-control mb-3" id="nivel_satisfacao" name="nivel_satisfacao" required>
                                    <option value="">Selecione...</option>
                                    <option value="1">😊 Satisfeito</option>
                                    <option value="2">😐 Neutro</option>
                                    <option value="3">😡 Insatisfeito</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>