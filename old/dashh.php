<?php
session_start();

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Continue as guest
    if (isset($_POST["guest"])) {

        $_SESSION["id_user"] = null;

        header("Location: index.php");
        exit;
    }

    // Login
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

            header("Location: dashboard.php");
            exit;
        }

        $error = "Invalid email or password.";
    }
}


require_once "styles.php";
require_once "header.php";

echo "
<div style='
text-align:center;
margin-top:20px;
color:#444;
font-size:15px;
'>

Retrieve protein sequences, perform alignments, scan motifs, and export results using Protalyze.

</div>
";
echo "<div class='container'>";
?>

<div style="
background:white;
padding:30px;
border-radius:10px;
max-width:420px;
margin:60px auto;
box-shadow:0 5px 15px rgba(0,0,0,0.1);
d">

<h2 style="margin-top:0;">Login</h2>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
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

<button type="submit" name="login">
Log In
</button>

</form>

<br>

<p>
Don't have an account?
<a href="signup.php">Sign up</a>
</p>

<form method="POST">

<button type="submit" name="guest">
Continue as Guest
</button>

</form>

</div>

</div>
