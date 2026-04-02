<?php

// Include navigation menu
require 'menu.php';

// Include database connection because we are inserting data into the database
require 'db.php';

// Set section title
echo "<h2 class='section-title'>Contact us</h2>";


// This variable tracks whether the form has been submitted
// It starts as false so the form is shown initially
$submitted = false;


// Check if the form was submitted using POST
// This prevents the code from running when the page first loads
// It only runs after the user clicks the submit button
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
	// Set the variable to true to mark that the form has been submitted
	$submitted = true;

	// Get user input safely
	// If name or email is empty, set them to null since they can anonymously send suggestions
	$name = $_POST['name'] ?? null;
	$email = $_POST['email'] ?? null;

	// Message is required, so we take it directly
	$message = $_POST['message'];

	// Prepare SQL statement to insert the message into the database
	$stmt = $pdo->prepare("insert into contact_messages (name, email, message) values (?, ?, ?)");

	// Execute the query with the provided data
	$stmt->execute([$name, $email, $message]);
}

?>

<!-- Use the container and card classes for content organization -->
<div class="container">

	<div class="card">

		<?php if ($submitted): ?>

			<!-- Show confirmation message after submission -->

			<p class="info-text">
				Thank you for your message! Your feedback has been received.
			</p>

		<?php else: ?>

			<!-- Show instructions -->

			<p>
				Feel free to send us a question or leave us a suggestion for how we can improve our services.
			</p>


			<!-- Contact form -->

			<form method="POST" action="contact.php">

				Name (optional):<br>
				<input type="text" name="name"><br><br>

				Email (optional):<br>
				<input type="email" name="email"><br><br>

				Message:<br>
				<textarea name="message" rows="6" required></textarea><br><br>

				<button type="submit" class="login-card">
					Send Message
				</button>

			</form>

		<?php endif; ?>

	</div>

</div>
