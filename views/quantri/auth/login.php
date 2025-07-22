<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Quản trị</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2196F3;
            --secondary-color: #1976D2;
            --error-color: #f44336;
            --success-color: #4CAF50;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-header { text-align: center; margin-bottom: 2rem; }
        .login-header h1 { color: var(--primary-color); font-size: 2rem; margin-bottom: 0.5rem; }
        .form-group { margin-bottom: 1.5rem; position: relative; }
        .form-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #666; }
        .form-control { width: 100%; padding: 12px 15px 12px 45px; border: 2px solid #e0e0e0; border-radius: 5px; font-size: 1rem; transition: border-color 0.3s ease; }
        .form-control:focus { border-color: var(--primary-color); outline: none; }
        .form-control.error { border-color: var(--error-color); }
        .error-message { color: var(--error-color); font-size: 0.85rem; margin-top: 5px; padding: 5px 0; }
        .remember-forgot { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .remember-me { display: flex; align-items: center; gap: 0.5rem; }
        .forgot-password { color: var(--primary-color); text-decoration: none; font-size: 0.9rem; }
        .forgot-password:hover { text-decoration: underline; }
        .btn-login { width: 100%; padding: 12px; background-color: var(--primary-color); color: white; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer; transition: background-color 0.3s ease; }
        .btn-login:hover { background-color: var(--secondary-color); }
        .register-link { text-align: center; margin-top: 1.5rem; color: #666; }
        .register-link a { color: var(--primary-color); text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
        @media (max-width: 480px) {
            .login-container { margin: 1rem; padding: 1.5rem; }
            .remember-forgot { flex-direction: column; gap: 1rem; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Đăng nhập</h1>
            <p>Vui lòng đăng nhập để tiếp tục</p>
        </div>
        <form id="loginForm" method="POST">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
            </div>
            <?php if (isset($login_error)) { echo "<div class='error-message'>$login_error</div>"; } ?>
            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <span>Ghi nhớ đăng nhập</span>
                </label>
                <a href="#" class="forgot-password">Quên mật khẩu?</a>
            </div>
            <button type="submit" name="login" class="btn-login">Đăng nhập</button>
        </form>
        <div class="register-link">
            <p>Chưa có tài khoản? <a href="index.php?action=admin_register">Đăng ký ngay</a></p>
        </div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            if (!username || !password) {
                e.preventDefault();
                if (!username) {
                    document.getElementById('username').classList.add('error');
                }
                if (!password) {
                    document.getElementById('password').classList.add('error');
                }
            }
        });
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error');
            });
        });
    </script>
</body>
</html> 