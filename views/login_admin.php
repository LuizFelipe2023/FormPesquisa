<?php
require_once("../config/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, password FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $email; // Alterado de "username" para "email"
        header("location: admin.php");
        exit(); 
    } else {
        echo "Credenciais inválidas.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .login-form {
            max-width: 350px;
            margin: 0 auto;
        }
        .register-link {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Login - Painel Admin</h2>
        <div class="login-form">
            <form action="login_admin.php" method="post">
                <div class="form-group">
                    <label for="email">Email:</label> 
                    <input type="email" id="email" name="email" class="form-control" required> 
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <div class="text-center mt-3">
                <a href="register_admin.php" class="register-link">Não tem registro de admin? Registre-se aqui.</a>
            </div>
        </div>
    </div>
</body>
</html>
