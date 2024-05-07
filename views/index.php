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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-check-input {
            margin-right: 10px;
        }

        .radio-group {
            display: flex;
            justify-content: center;
        }

        .form-check-inline {
            margin-right: 20px;
        }

        .emoji {
            font-size: 32px;
            margin-right: 10px;
        }

        @media (max-width: 576px) {
            .card {
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mb-4 text-center">Pesquisa de Satisfação </h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Formulário de Pesquisa</div>
                    <div class="card-body">
                        <form method="POST" action="index.php">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="cpf">CPF:</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" required>
                            </div>
                            <div class="form-group">
                                <label for="nivel_satisfacao">Nível de Satisfação:</label><br>
                                <div class="radio-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="nivel_satisfacao" id="satisfeito" value="1" required>
                                        <label class="form-check-label" for="satisfeito"><span class="emoji">😊</span> Satisfeito</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="nivel_satisfacao" id="neutro" value="2" required>
                                        <label class="form-check-label" for="neutro"><span class="emoji">😐</span> Neutro</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="nivel_satisfacao" id="insatisfeito" value="3" required>
                                        <label class="form-check-label" for="insatisfeito"><span class="emoji">😡</span> Insatisfeito</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
