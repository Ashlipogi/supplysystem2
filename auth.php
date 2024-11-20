<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Create Account</title>
    <style>
        :root {
            --primary-color: #3498db;
            --primary-hover: #2980b9;
            --bg-color: #1a1a1a;
            --text-color: #b3b3b3;
            --input-bg: #333;
            --input-border: #444;
        }

        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: url('logo.png') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}


        .auth-container {
            background-color: var(--bg-color);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .auth-toggle {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .auth-toggle button {
            background-color: transparent;
            border: none;
            color: var(--text-color);
            font-size: 1rem;
            cursor: pointer;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease, border-color 0.3s ease;
            border-bottom: 2px solid transparent;
        }

        .auth-toggle button.active {
            color: white;
            border-bottom-color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            pointer-events: none;
        }

        .form-group input {
            width: 95%;
            padding: 0.75rem 0.5rem;
            border: 1px solid var(--input-border);
            background-color: var(--input-bg);
            color: white;
            border-radius: 4px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: -0.75rem;
            left: 0.25rem;
            font-size: 0.75rem;
            color: var(--primary-color);
            background-color: var(--bg-color);
            padding: 0 0.25rem;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .hidden {
            display: none;
        }

        @media (max-width: 480px) {
            .auth-container {
                padding: 1.5rem;
            }
        }
    </style>
    
</head>
<body>
    
    <div class="auth-container">
        <div class="auth-toggle">
            <button id="loginToggle" class="active">Login</button>
            <button id="signupToggle">Create Account</button>
        </div>
        
        <!-- Login Form -->
        <form id="loginForm" action="login.php" method="POST">
    <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
        <div id="error-message" style="color: red; text-align: center; margin-bottom: 10px;">
            Invalid login credentials. Please try again.
        </div>
    <?php endif; ?>
    <div class="form-group">
        <input type="email" id="loginEmail" name="email" required placeholder=" ">
        <label for="loginEmail">Email</label>
    </div>
    <div class="form-group">
        <input type="password" id="loginPassword" name="password" required placeholder=" ">
        <label for="loginPassword">Password</label>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <a href="index.html" class="home-link" style="display: block; text-align: center; margin-top: 20px;">Back to Home</a>
</form>

        <!-- Signup Form -->
        <form id="signupForm" action="" method="POST" class="hidden">
            <div class="form-group">
                <input type="text" id="signupName" name="name" required placeholder=" ">
                <label for="signupName">Full Name</label>
            </div>
            <div class="form-group">
                <input type="email" id="signupEmail" name="email" required placeholder=" ">
                <label for="signupEmail">Email</label>
            </div>
            <div class="form-group">
                <input type="password" id="signupPassword" name="password" required placeholder=" ">
                <label for="signupPassword">Password</label>
            </div>
            <div class="form-group">
                <input type="password" id="signupConfirmPassword" name="password_confirmation" required placeholder=" ">
                <label for="signupConfirmPassword">Confirm Password</label>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
            <a href="index.html" class="home-link" style="display: block; text-align: center; margin-top: 20px;">Back to Home</a>
        </form>
    </div>
    <script>
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        const role = document.getElementById('role').value;

        // Dynamically set the action attribute based on role
        if (role === 'admin') {
            this.action = 'admin_auth.php';
        } else {
            this.action = 'user_auth.php';
        }
    });
</script>
    <script>
        const loginToggle = document.getElementById('loginToggle');
        const signupToggle = document.getElementById('signupToggle');
        const loginForm = document.getElementById('loginForm');
        const signupForm = document.getElementById('signupForm');

        loginToggle.addEventListener('click', () => {
            loginToggle.classList.add('active');
            signupToggle.classList.remove('active');
            loginForm.classList.remove('hidden');
            signupForm.classList.add('hidden');
        });

        signupToggle.addEventListener('click', () => {
            signupToggle.classList.add('active');
            loginToggle.classList.remove('active');
            signupForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
        });

        // Add input validation
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const inputs = form.querySelectorAll('input');
                let isValid = true;

                inputs.forEach(input => {
                    if (!input.checkValidity()) {
                        isValid = false;
                        input.classList.add('invalid');
                    } else {
                        input.classList.remove('invalid');
                    }
                });

                if (isValid) {
                    // You can submit the form here or perform any other action
                    console.log('Form is valid, submitting...');
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>