<?php
require_once("../config/connect.php");

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $msg = "Por favor, preencha todos os campos.";
    } else {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $msg = "Este e-mail já está sendo usado.";
        } else {
            $sql = "INSERT INTO usuarios (email, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            if ($stmt->execute([$email, $hashed_password])) {
                $msg = "Usuário cadastrado com sucesso.";
                header("location: login_admin.php");
                exit();
            } else {
                $msg = "Erro ao cadastrar usuário.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Registrar</h2>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                    <div class="text-center">
                        <p><?php echo $msg; ?></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
