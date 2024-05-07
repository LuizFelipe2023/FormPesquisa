<?php
require_once('../config/connect.php');

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_admin.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM teste");
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Lista de Pessoas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        <a href="admin.php"><i class="fas fa-home"></i> Painel Administrativo</a>
        <a href="lista_pessoas.php"><i class="fas fa-users"></i> Lista de Pessoas</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Painel Administrativo - Lista de Pessoas</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Nível de Satisfação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $pessoa) : ?>
                    <tr>
                        <td><?php echo $pessoa['id']; ?></td>
                        <td><?php echo $pessoa['nome']; ?></td>
                        <td><?php echo $pessoa['cpf']; ?></td>
                        <td><?php echo $pessoa['nivel_satisfacao']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
