<?php
session_start();
require 'db.php'; // your database connection

$email = $password = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate
    if (empty($email)) {
        $email_err = "Please enter your email.";
    }

    if (empty($password)) {
        $password_err = "Please enter your password.";
    }

    // If no validation errors
    if (empty($email_err) && empty($password_err)) {
        // Check in database
        $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $name, $db_email, $db_password);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $db_password)) {
                // Password correct → start session
                $_SESSION['id'] = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['email'] = $db_email;

               // Redirect to dashboard
                header("Location: dashboard.php");
                exit;
            } else {
                $login_err = "Invalid email or password.";
            }
        } else {
            $login_err = "Invalid email or password.";
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
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Login</h3>

                    <?php if(!empty($login_err)) echo '<div class="alert alert-danger">'.$login_err.'</div>'; ?>

                    <form action="login.php" method="POST">
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
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>

                        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>