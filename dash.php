<?php
session_start();

// Load database connection
require 'db.php';

// Decide which page mode to show
$mode = $_GET['mode'] ?? 'login';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {

	// If user chooses guest access
	if (isset($_POST["guest"])) {
		$_SESSION["id_user"] = null;
		header("Location: index.php");
		exit;
	}

	// Handle login request
	if (isset($_POST["login"])) {

		// Get login details
		$email = $_POST["email"];
		$password = $_POST["password"];

		// Look up user by email
		$stmt = $pdo->prepare("Select id_user, password_hash from users where email = ?");
		$stmt->execute([$email]);

		$user = $stmt->fetch();

		// Check password using secure hash verification
		if ($user && password_verify($password, $user["password_hash"])) {
			$_SESSION["id_user"] = $user["id_user"];
			header("Location: index.php");
			exit;
		}

		// Show error if login fails
		$error = "Invalid email or password.";
	}

	// Handle signup request
	if (isset($_POST["signup"])) {

		// Get signup details
		$first = $_POST["first"];
		$last = $_POST["last"];
		$email = $_POST["signup_email"];
		$password = $_POST["signup_password"];

		// Check password strength
		// Must include uppercase letter, number, and special character
		if (
			strlen($password) < 8 ||
			!preg_match('/[A-Z]/', $password) ||
			!preg_match('/[0-9]/', $password) ||
			!preg_match('/[\W]/', $password)
		) {
			$error = "Password must be at least 8 characters and include one uppercase letter, one number, and one special character.";
			$mode = "signup";
		}
		else {

			// Check if email already exists
			$stmt = $pdo->prepare("Select id_user from users where email = ?");
			$stmt->execute([$email]);

			if ($stmt->fetch()) {
				$error = "An account with this email already exists.";
				$mode = "signup";
			}
			else {

				// Create secure password hash
				$password_hash = password_hash($password, PASSWORD_DEFAULT);

				// Insert new user into database
				$stmt = $pdo->prepare("Insert into users (first, last, email, password_hash) values (?, ?, ?, ?)");
				$stmt->execute([$first, $last, $email, $password_hash]);

				// Redirect after successful signup
				header("Location: dash.php?created=1");
				exit;
			}
		}
	}

	// Handle forgot password request
	if (isset($_POST["forgot"])) {

		// Get email address
		$email = $_POST["forgot_email"];

		// Check if email exists
		$stmt = $pdo->prepare("Select id_user from users where email = ?");
		$stmt->execute([$email]);

		// Always show success message for security
		$success = "Password reset request submitted.
		If an account is associated with this email, the system administrator will handle the password reset.";

		$mode = "forgot";
	}
}

// Load styles and header
require_once "styles.php";
require_once "header.php";

// Show page title
echo '<div class="section-title">Welcome to the Protalyze Protein Analysis Portal</div>';
echo "<div class='container'>";
?>

<div class="dash-card">

<?php if ($mode === 'login') { ?>

<h2>Login</h2>

<?php
// Show login error
if (isset($error)) {
	echo "<p style='color:red;'>$error</p>";
}

// Show account created message
if (isset($_GET["created"])) {
	echo "<p style='color:green;'>Account created successfully. You can now log in.</p>";
}
?>

<form method="POST">

<!--  Require username and password to login -->
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

<!-- Show both options -->
<p>
Don't have an account?<br>
<a href="dash.php?mode=signup">Sign up</a>
or
<a href="index.php">continue as guest</a>
</p>

<?php } ?>


<?php if ($mode === 'signup') { ?>

<h2>Sign Up</h2>

<?php
// Show signup error
if (isset($error)) {
	echo "<p style='color:red;'>$error</p>";
}
?>

<form method="POST">

<!-- Signup Form -->
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

<!-- Show both options -->

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
<!-- Just a message since the password reset function is not implemented -->
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

<!-- Footer written manually because the menu file is not imported on this login and signup page -->

Protalize Protein Analysis Toolkit<br>
University of Edinburgh

</div>


