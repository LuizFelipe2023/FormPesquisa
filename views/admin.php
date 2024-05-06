<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_admin.php");
    exit;
}

require_once("../config/connect.php");

$stmt = $conn->prepare("SELECT nivel_satisfacao, COUNT(*) as total FROM teste GROUP BY nivel_satisfacao");
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$satisfeito = 0;
$neutro = 0;
$insatisfeito = 0;
$totalRespostas = 0;

foreach ($resultados as $resultado) {
    $totalRespostas += $resultado['total'];
    switch ($resultado['nivel_satisfacao']) {
        case 1:
            $satisfeito = $resultado['total'];
            break;
        case 2:
            $neutro = $resultado['total'];
            break;
        case 3:
            $insatisfeito = $resultado['total'];
            break;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/app.css">
</head>

<body>
    <div class="container">
        <h1>Painel Administrativo - Apuração de Satisfação</h1>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">Apuração de Satisfação</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nível de Satisfação</th>
                                    <th>Quantidade</th>
                                    <th>Porcentagem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Satisfeito</td>
                                    <td><?php echo $satisfeito; ?></td>
                                    <td><?php echo round(($satisfeito / $totalRespostas) * 100, 2); ?>%</td>
                                </tr>
                                <tr>
                                    <td>Neutro</td>
                                    <td><?php echo $neutro; ?></td>
                                    <td><?php echo round(($neutro / $totalRespostas) * 100, 2); ?>%</td>
                                </tr>
                                <tr>
                                    <td>Insatisfeito</td>
                                    <td><?php echo $insatisfeito; ?></td>
                                    <td><?php echo round(($insatisfeito / $totalRespostas) * 100, 2); ?>%</td>
                                </tr>
                                <tr>
                                    <td><strong>Total de votantes</strong></td>
                                    <td colspan="2"><strong><?php echo $totalRespostas; ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
