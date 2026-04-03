<?php
// Start session
session_start();

// Include database connection
require 'db.php'; // Make sure this file has $conn = new mysqli(...)

// Initialize variables
$name = $email = $password = $confirm_password = "";
$name_err = $email_err = $password_err = $success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate Email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate Password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must be at least 6 characters.";
    } else {
        $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    }

    // If no errors, insert into database
    if (empty($name_err) && empty($email_err) && empty($password_err)) {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $success_msg = "Registration successful! <a href='login.php'>Login here</a>.";
        } else {
            $email_err = "Email already exists or some error occurred.";
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Create Account</h3>

                    <?php if(!empty($success_msg)) echo '<div class="alert alert-success">'.$success_msg.'</div>'; ?>

                    <form action="register.php" method="POST">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <div class="invalid-feedback"><?php echo $name_err; ?></div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <div class="invalid-feedback"><?php echo $email_err; ?></div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                            <div class="invalid-feedback"><?php echo $password_err; ?></div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>

                        <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>