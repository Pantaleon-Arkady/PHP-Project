<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register Page</title>
    <link rel="stylesheet" href="/statics/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono&display=swap" rel="stylesheet">
    <script src="/statics/bootstrap.bundle.min.js"></script>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Space Mono', monospace;
        }

        body {
            height: 100vh;
        }

        .Main_div {
            height: 100%;
        }

        .form-container {
            background-color: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
    </style>
</head>

<body class="p-3 bg-dark">
    <div class="Main_div bg-secondary rounded d-flex flex-row justify-content-center align-items-center">
        <div class="bg-light w-50 m-3 rounded d-flex flex-column justify-content-center align-items-center text-center p-4">
            <?php if (isset($_GET['register']) && $_GET['register'] === 'pin'): ?>
                <h2 class="mb-3">Trial App Name</h2>
                <div>
                    <p>
                        We sent a pin to your 
                        <a href="http://localhost:8025/" target="_blank">email</a>
                        please verify.
                    </p>
                </div>
            <?php else: ?>
                <h2 class="mb-3">Trial App Name</h2>
                <div>
                    <a href="http://localhost:8080/register?register=login" class="text-decoration-none me-2">Log In</a>
                    <span>or</span>
                    <a href="http://localhost:8080/register?register=signup" class="text-decoration-none ms-2">Sign Up</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="bg-light w-50 m-3 rounded d-flex justify-content-center align-items-center p-4">
            <?php if (isset($_GET['register']) && $_GET['register'] === 'signup'): ?>
                <div class="form-container w-100">
                    <h4 class="mb-4 text-center">Create an Account</h4>
                    <form method="POST" action="/signing-up" id="registerForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-2" id="registerBtn">
                            <span id="registerText">Register</span>
                            <span id="registerSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </form>
                    <?php if (isset($_SESSION['registered'])): ?>
                        <div class="alert alert-success py-3">
                            <strong>Success!</strong> You are now registered in Trial App Name.
                        </div>
                        <?php unset($_SESSION['registered']); ?>
                    <?php endif; ?>
                </div>
            <?php elseif (isset($_GET['register']) && $_GET['register'] === 'login'): ?>
                <div class="form-container w-100">
                    <h4 class="mb-4 text-center">Log In</h4>
                    <form method="POST" action="/logging-in" id="logInForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username or Email</label>
                            <input
                                type="text"
                                class="form-control"
                                id="namemail"
                                name="namemail"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-2" id="logInBtn">
                            <span id="logInText">Log In</span>
                            <span id="logInSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </form>
                    <?php if (isset($_SESSION['registered'])): ?>
                        <div class="alert alert-success py-3">
                            <strong>Success!</strong> You are now registered in Trial App Name.
                        </div>
                        <?php unset($_SESSION['registered']); ?>
                    <?php endif; ?>
                </div>
            <?php elseif (isset($_GET['register']) && $_GET['register'] === 'pin'): ?>
                <div class="form-container w-100 pin-form">
                    <h5 class="text-center mb-3">Verify</h5>
                    <form method="POST" action="/register-pin" id="pinForm">
                        <div class="mb-3">
                            <input type="password" class="form-control" name="pin" maxlength="6" pattern="\d{6}" required placeholder="Enter PIN..." aria-label="PIN">
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Submit</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="form-container w-100 text-center">
                    <h4 class="mb-3">Welcome to Trial App Name</h4>
                    <p class="text-muted">Please choose to <strong>Log In</strong> or <strong>Sign Up</strong> to continue.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
<script>
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('registerBtn');
            const spinner = document.getElementById('registerSpinner');
            const text = document.getElementById('registerText');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Submitting...';

            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    }

    const logInForm = document.getElementById('logInForm');
    if (logInForm) {
        logInForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('logInBtn');
            const spinner = document.getElementById('logInSpinner');
            const text = document.getElementById('logInText');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Submitting...';

            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    }
</script>

</html>