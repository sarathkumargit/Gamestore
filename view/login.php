<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Game Store</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Teko&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .login-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
        }

        .login-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2), 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        .login-card .card-body {
            padding: 2rem;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="../images/logo4.png" class="logo" style="width:130px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="my-4">Login</h1>
        <div class="card col-md-6 login-card">
            <div class="card-body">
                <form class="row g-3 needs-validation" id="LoginForm" method="POST" novalidate>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01" class="form-label">Email</label>
                        <input type="email" class="form-control" id="validationCustom01" name="email" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom02" class="form-label">Password</label>
                        <input type="password" class="form-control" id="validationCustom02" name="password" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>
                    <div class="col-md-12 mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberme" name="rememberme">
                        <label for="rememberme" class="form-check-label">Remember Me</label>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn btn-dark w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12 mt-4 text-center">
                        <p>If you do not have an account: <a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

<script>
    async function showAlert(message, type) {
        const alertContainer = document.createElement('div');
        alertContainer.classList.add('alert', `alert-${type}`);
        alertContainer.textContent = message;
        const form = document.getElementById('LoginForm');
        form.parentNode.insertBefore(alertContainer, form);
        setTimeout(() => {
            alertContainer.remove();
        }, 2000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('LoginForm');

        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            form.classList.add('was-validated');

            if (form.checkValidity()) {
                const formData = new FormData(form);
                try {
                    const response = await axios.post('../Controller/LoginController.php', formData);
                    console.log(response.data.redirect)
                    if (response.data.status === 'error') {
                        showAlert(response.data.message, 'danger');
                    } else if (response.data.status === 'success') {
                        showAlert(response.data.message, 'success');
                    }
                    setTimeout(() => {
                        window.location.href = response.data.redirect;
                    }, 2000);
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred during login');
                }
            } else {
                event.stopPropagation();
            }
        }, false);
    });
</script>

<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</body>
</html>
