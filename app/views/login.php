
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="poas/../assets/styles/loginFormStyles.css">
    <script src="poas/../assets/scripts/loginForm.js"></script>
        
</head>
<body>

    <div class="d-flex flex-column align-items-center w-100">
        <!-- Notify is there's an error with the log in ( Invalid credentials ) -->
        <?php if( isset($_GET['errorMessage'] ) ) : ?>
            <div class="alert alert-danger text-center w-100" style="max-width: 500px;" role="alert">
                <?= $_GET['errorMessage'] ?>
            </div>
        <?php endif; ?>
        <div class="text-center">
            <img src="poas/../assets/img/squareLogo.png" alt="Logo" class="mb-4" style="width: 100px;">
        </div>

        <!-- Log in form -->
        <div class="login-container">
            <h3 class="text-center mb-4">Iniciar sesión</h3>
            <form id="loginForm" method="POST" action="?controller=poa&method=signIn">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-login">Entrar</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
