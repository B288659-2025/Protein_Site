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

        $success = "Password reset request submitted.
        If an account is associated with this email, the system administrator will handle the password reset.";    

        $mode = "forgot";
    }
}

require_once "styles.php";
require_once "header.php";
echo '<div class="section-title">Welcome to the Protalyze Protein Analysis Portal</div>';
echo "<div class='container'>";
?>

<div class="dash-card">

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

<div class="form-row">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
</div>

<div class="form-row">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
</div>

<div class="forgot-row">
    <a href="dash.php?mode=forgot">
        Forgot password?
    </a>
</div>

<button class="login-card" type="submit" name="login">
Log In
</button>

</form>
<br>


<p>
Don't have an account?<br>
<a href="dash.php?mode=signup">Sign up</a>
or
<a href="index.php">continue as guest</a>
</p>

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

<div class="form-row">
    <label for="first">First name:</label>
    <input type="text" id="first" name="first" required>
</div>

<div class="form-row">
    <label for="last">Last name:</label>
    <input type="text" id="last" name="last" required>
</div>

<div class="form-row">
    <label for="signup_email">Email:</label>
    <input type="email" id="signup_email" name="signup_email" required>
</div>

<div class="form-row">
    <label for="signup_password">Password:</label>
    <input type="password" id="signup_password" name="signup_password" required>
</div>

<button class="login-card" type="submit" name="signup">
Create Account
</button>

</form>
<br>

<p>
Already have an account?<br>
<a href="dash.php?">Log in</a>
or
<a href="index.php">continue as guest</a>
</p>



<?php } ?>

<?php if ($mode === 'forgot'): ?>

<h2>Forgot Password</h2>

<?php if (isset($success)): ?>
<p class="info-text">
<?php echo $success; ?>
</p>

<br>
<a href="dash.php">
Back to login
</a>

<?php else: ?>

<p class="info-text">
Enter the email associated with your account. Password reset requests are handled manually by the system administrator.
</p>

<form method="POST">

<label>Email:</label>
<br>
<input type="email" name="forgot_email" required>

<br><br>

<button class="login-card" type="submit" name="forgot">
Reset Password
</button>

</form>

<?php endif; ?>

<?php endif; ?>

</div>
</div>
<div class="footer">
    Protalize Protein Analysis Toolkit<br>
    University of Edinburgh
</div>
