<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Tai Mũi Họng</title>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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

        .login-container {
            background: white;
            padding: 2.5rem;
            border-radius: var(--border-radius);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h1 {
            color: var(--primary-color);
            font-size: 2.2rem;
            margin-bottom: 0.8rem;
            font-weight: 600;
        }

        .login-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
            outline: none;
        }

        .form-control:focus + i {
            color: var(--primary-color);
        }

        .form-control.error {
            border-color: var(--error-color);
            background-color: #fff;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.85rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-message::before {
            content: "!";
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            background-color: var(--error-color);
            color: white;
            border-radius: 50%;
            font-size: 12px;
            font-weight: bold;
        }

        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-secondary {
            background-color: #fff;
            color: var(--primary-color);
            border: 1px solid #e0e0e0;
        }
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-secondary:hover {
            background-color: #f8f9fa;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .form-check {
            display: flex;
            align-items: center;
        }
        
        .form-check-input {
            margin-right: 8px;
        }

        .form-footer a {
            color: var(--secondary-color);
            text-decoration: none;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            color: #666;
        }

        .register-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .success-message {
            color: var(--success-color);
            background-color: #e8f5e9;
            border: 1px solid var(--success-color);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Đăng Nhập</h1>
            <p>Chào mừng bạn trở lại!</p>
        </div>

        <?php if (!empty($success)): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" class="form-control <?php echo (!empty($error) && (strpos($error, 'Tên đăng nhập') !== false || strpos($error, 'Vui lòng') !== false)) ? 'error' : ''; ?>" placeholder="Tên đăng nhập hoặc Email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" class="form-control <?php echo (!empty($error) && (strpos($error, 'Mật khẩu') !== false || strpos($error, 'Vui lòng') !== false)) ? 'error' : ''; ?>" placeholder="Mật khẩu" required>
            </div>
            
            <?php if (!empty($error)): ?>
                <p class="error-message"><?php echo $error; ?></p>
            <?php endif; ?>

            <div class="form-footer">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Ghi nhớ đăng nhập
                    </label>
                </div>
                <a href="#">Quên mật khẩu?</a>
            </div>

            <div class="form-group" style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>

        <div class="register-link">
            Chưa có tài khoản? <a href="index.php?action=register">Đăng ký ngay</a>
        </div>
    </div>
</body>
</html> 