<?php
session_start();

require 'db.php';

$mode = $_GET['mode'] ?? 'login';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["guest"])) {
        $_SESSION["id_user"] = null;
        header("Location: index.php");
        exit;
    }

    if (isset($_POST["login"])) {

        $email = $_POST["email"];
        $password = $_POST["password"];

        $stmt = $pdo->prepare("
            SELECT id_user, password_hash
            FROM users
            WHERE email = ?
        ");

        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password_hash"])) {
            $_SESSION["id_user"] = $user["id_user"];
            header("Location: index.php");
            exit;
        }

        $error = "Invalid email or password.";
    }

    if (isset($_POST["signup"])) {

        $first = $_POST["first"];
        $last = $_POST["last"];
        $email = $_POST["signup_email"];
        $password = $_POST["signup_password"];

        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[0-9]/', $password) ||
            !preg_match('/[\W]/', $password)
        ) {
            $error = "Password must be at least 8 characters and include one uppercase letter, one number, and one special character.";
            $mode = "signup";
        } else {

            $stmt = $pdo->prepare("
                SELECT id_user
                FROM users
                WHERE email = ?
            ");

            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $error = "An account with this email already exists.";
                $mode = "signup";
            } else {

                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("
                    INSERT INTO users (first, last, email, password_hash)
                    VALUES (?, ?, ?, ?)
                ");

                $stmt->execute([$first, $last, $email, $password_hash]);

                header("Location: dash.php?created=1");
                exit;
            }
        }
    }

    if (isset($_POST["forgot"])) {

        $email = $_POST["forgot_email"];

        $stmt = $pdo->prepare("
            SELECT id_user
            FROM users
            WHERE email = ?
        ");

        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $success = "If this email exists, a password reset link would be sent. This functionality is simulated in this system, but a reset link would normally be sent to the registered email address.";
        } else {
            $success = "If this email exists, a password reset link would be sent. This functionality is simulated in this system, but a reset link would normally be sent to the registered email address.";
        }

        $mode = "forgot";
    }
}

require_once "styles.php";
require_once "header.php";
echo '<div class="section-title">Welcome to the Protalyze Protein Analysis Portal</div>';
echo "<div class='container'>";
?>

<div class="card">

<?php if ($mode === 'login') { ?>

<h2>Login</h2>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}

if (isset($_GET["created"])) {
    echo "<p style='color:green;'>Account created successfully. You can now log in.</p>";
}
?>

<form method="POST">

<label>Email:</label>
<br>
<input type="email" name="email" required>

<br><br>

<label>Password:</label>
<br>
<input type="password" name="password" required>

<br><br>

<button class = "login-card" type="submit" name="login">
Log In
</button>

</form>

<br>

<p>
<a href="dash.php?mode=forgot">
Forgot password?
</a>
</p>

<p>
Don't have an account?
<a href="dash.php?mode=signup">
Sign up
</a>
</p>

<form method="POST">
<button class = "login-card" type="submit" name="guest">
Continue as Guest
</button>
</form>

<?php } ?>

<?php if ($mode === 'signup') { ?>

<h2>Sign Up</h2>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST">

<label>First name:</label>
<br>
<input type="text" name="first" required>

<br><br>

<label>Last name:</label>
<br>
<input type="text" name="last" required>

<br><br>

<label>Email:</label>
<br>
<input type="email" name="signup_email" required>

<br><br>

<label>Password:</label>
<br>
<input type="password" name="signup_password" required>

<br><br>

<button class = "login-card" type="submit" name="signup">
Create Account
</button>

</form>

<br>

<p>
Already have an account?
<a href="dash.php">
Log in
</a>
</p>

<?php } ?>

<?php if ($mode === 'forgot') { ?>

<h2>Forgot Password</h2>

<?php
if (isset($success)) {
    echo "<p style='color:green;'>$success</p>";
}
?>

<form method="POST">

<label>Email:</label>
<br>
<input type="email" name="forgot_email" required>

<br><br>

<button type="submit" name="forgot">
Reset Password
</button>

</form>

<br>

<p>
<a href="dash.php">
Back to login
</a>
</p>

<?php } ?>
</div>
</div>
<div class="footer">
    Protalize Protein Analysis Toolkit<br>
    University of Edinburgh
</div>
