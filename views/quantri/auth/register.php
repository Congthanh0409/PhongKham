<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Quản trị</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2196F3;
            --secondary-color: #1976D2;
            --error-color: #f44336;
            --success-color: #4CAF50;
            --text-color: #333;
            --border-radius: 8px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-color);
        }
        .register-container {
            background: white;
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            animation: slideUp 0.5s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .register-header { text-align: center; margin-bottom: 2.5rem; }
        .register-header h1 { color: var(--primary-color); font-size: 2.2rem; margin-bottom: 0.8rem; font-weight: 600; }
        .register-header p { color: #666; font-size: 1.1rem; }
        .form-group { margin-bottom: 1.8rem; position: relative; }
        .form-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #666; font-size: 1.2rem; transition: color 0.3s ease; }
        .form-control { width: 100%; padding: 15px 15px 15px 45px; border: 2px solid #e0e0e0; border-radius: var(--border-radius); font-size: 1rem; transition: all 0.3s ease; background-color: #f8f9fa; }
        .form-control:focus { border-color: var(--primary-color); background-color: #fff; box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1); outline: none; }
        .form-control:focus + i { color: var(--primary-color); }
        .form-control.error { border-color: var(--error-color); background-color: #fff; }
        .error-message { color: var(--error-color); font-size: 0.85rem; margin-top: 8px; display: flex; align-items: center; gap: 5px; }
        .error-message::before { content: "!"; display: inline-flex; align-items: center; justify-content: center; width: 16px; height: 16px; background-color: var(--error-color); color: white; border-radius: 50%; font-size: 12px; font-weight: bold; }
        .success-message { color: var(--success-color); font-size: 0.85rem; margin-top: 8px; display: flex; align-items: center; gap: 5px; padding: 10px; background-color: rgba(76, 175, 80, 0.1); border-radius: var(--border-radius); }
        .success-message::before { content: "\2713"; display: inline-flex; align-items: center; justify-content: center; width: 16px; height: 16px; background-color: var(--success-color); color: white; border-radius: 50%; font-size: 12px; font-weight: bold; }
        .btn { width: 100%; padding: 15px; border: none; border-radius: var(--border-radius); font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-align: center; display: inline-block; text-decoration: none; }
        .btn-primary { background-color: var(--primary-color); color: white; }
        .btn-primary:hover { background-color: var(--secondary-color); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
        .btn-primary:active { transform: translateY(0); box-shadow: none; }
        .login-link { text-align: center; margin-top: 2rem; color: #666; font-size: 1rem; }
        .login-link a { color: var(--primary-color); text-decoration: none; font-weight: 600; transition: color 0.3s ease; }
        .login-link a:hover { color: var(--secondary-color); text-decoration: underline; }
        .password-requirements { font-size: 0.85rem; color: #666; margin-top: 8px; padding-left: 20px; position: relative; }
        .password-requirements::before { content: "\2139\fe0f"; position: absolute; left: 0; top: 0; }
        @media (max-width: 480px) {
            .register-container { padding: 1.5rem; }
            .register-header h1 { font-size: 1.8rem; }
            .form-control { padding: 12px 12px 12px 40px; }
            .btn { padding: 12px; }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Đăng ký</h1>
            <p>Tạo tài khoản mới</p>
        </div>
        <form id="registerForm" method="POST" novalidate>
            <div class="form-group">
                <input type="text" class="form-control <?php echo isset($errors['username']) ? 'error' : ''; ?>" 
                    id="username" name="username" placeholder="Tên đăng nhập" required>
                <i class="fas fa-user"></i>
                <?php if (isset($errors['username'])): ?>
                    <div class="error-message"><?php echo $errors['username']; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="email" class="form-control <?php echo isset($errors['email']) ? 'error' : ''; ?>" 
                    id="email" name="email" placeholder="Email" required>
                <i class="fas fa-envelope"></i>
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="password" class="form-control <?php echo isset($errors['password']) ? 'error' : ''; ?>" 
                    id="password" name="password" placeholder="Mật khẩu" required>
                <i class="fas fa-lock"></i>
                <div class="password-requirements">Mật khẩu phải có ít nhất 6 ký tự</div>
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="password" class="form-control <?php echo isset($errors['confirm_password']) ? 'error' : ''; ?>" 
                    id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                <i class="fas fa-lock"></i>
                <?php if (isset($errors['confirm_password'])): ?>
                    <div class="error-message"><?php echo $errors['confirm_password']; ?></div>
                <?php endif; ?>
            </div>
            <?php if (isset($register_error)): ?>
                <div class="error-message"><?php echo $register_error; ?></div>
            <?php endif; ?>
            <?php if (isset($register_success)): ?>
                <div class="success-message"><?php echo $register_success; ?></div>
            <?php endif; ?>
            <button type="submit" name="register" class="btn btn-primary">Đăng ký</button>
        </form>
        <div class="login-link">
            <p>Đã có tài khoản? <a href="index.php?action=admin_login">Đăng nhập ngay</a></p>
        </div>
    </div>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let isValid = true;
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm_password').value.trim();
            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('error');
                const errorMessage = input.parentElement.querySelector('.error-message');
                if (errorMessage) errorMessage.remove();
            });
            if (username.length < 3) {
                isValid = false;
                showError('username', 'Tên đăng nhập phải có ít nhất 3 ký tự');
            }
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                isValid = false;
                showError('email', 'Email không hợp lệ');
            }
            if (password.length < 6) {
                isValid = false;
                showError('password', 'Mật khẩu phải có ít nhất 6 ký tự');
            }
            if (password !== confirmPassword) {
                isValid = false;
                showError('confirm_password', 'Mật khẩu xác nhận không khớp');
            }
            if (!isValid) {
                e.preventDefault();
            }
        });
        function showError(inputId, message) {
            const input = document.getElementById(inputId);
            input.classList.add('error');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            input.parentElement.appendChild(errorDiv);
        }
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error');
                const errorMessage = this.parentElement.querySelector('.error-message');
                if (errorMessage && !errorMessage.classList.contains('success-message')) {
                    errorMessage.remove();
                }
            });
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    </script>
</body>
</html> 