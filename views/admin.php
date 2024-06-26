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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Painel Administrativo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 20px;
            overflow-y: auto;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .sidebar a {
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .content {
            margin-left: 200px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .logout {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            background-color: #555;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout:hover {
            background-color: #777;
        }

        .header {
            background-color: #444;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        @media only screen and (max-width: 768px) {
            .sidebar {
                width: 150px;
            }

            .content {
                margin-left: 150px;
            }
        }

        @media only screen and (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

<div class="sidebar">
        <a href="#"><i class="fas fa-home"></i> Painel Administrativo</a>
        <a href="listar_pessoas.php"><i class="fas fa-users"></i> Lista de Pessoas</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Painel Administrativo</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Satisfeito</td>
                    <td><?php echo $satisfeito; ?></td>
                </tr>
                <tr>
                    <td>Neutro</td>
                    <td><?php echo $neutro; ?></td>
                </tr>
                <tr>
                    <td>Insatisfeito</td>
                    <td><?php echo $insatisfeito; ?></td>
                </tr>
                <tr>
                    <td>Total de Respostas</td>
                    <td><?php echo $totalRespostas; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
