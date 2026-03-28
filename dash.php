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

            header("Location: index.php");
            exit;
        }

        $error = "Invalid email or password.";
    }

    // Signup
    if (isset($_POST["signup"])) {
        $first = $_POST["first"];
        $last = $_POST["last"];
        $email = $_POST["signup_email"];
        $password = $_POST["signup_password"];

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users (first, last, email, password_hash)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$first, $last, $email, $password_hash]);

        $success = "Account created successfully. You can now log in.";
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

<!-- LOGIN CARD -->

<div class="card">

<h2>Login</h2>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
}

if (isset($success)) {
    echo "<p style='color:green;'>$success</p>";
}
?>

<!-- LOGIN FORM -->

<form method="POST" id="loginForm">

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
<a href="#" onclick="showSignup(); return false;">
Sign up
</a>
</p>

<form method="POST">
<button type="submit" name="guest">
Continue as Guest
</button>
</form>

<!-- SIGNUP FORM (hidden initially) -->

<div id="signupSection" style="display:none; margin-top:20px;">


<h2>Sign Up</h2>

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

<button type="submit" name="signup">
Create Account
</button>

</form>

</div>

</div>

<!-- WHAT YOU CAN DO SECTION -->

<div class="section">

<h3>What you can do:</h3>

<ul>

<li>Retrieve protein sequences from biological databases</li>

<li>Perform multiple sequence alignment</li>

<li>Scan conserved motifs</li>

<li>Filter sequences by quality criteria</li>

<li>Export analysis results</li>

</ul>

</div>

<!-- FOOTER -->

<div class="footer">

Protalyze Protein Analysis Toolkit  
University of Edinburgh

</div>

</div>

<!-- JAVASCRIPT TO TOGGLE SIGNUP -->

<script>

function showSignup() {

    document.getElementById("signupSection").style.display = "block";

}

</script>
