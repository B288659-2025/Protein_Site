<?php
require 'menu.php';
require 'db.php';
echo "<h2 class='section-title'>Contact us</h2>";
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $submitted = true;

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $message = $_POST['message'];

    $stmt = $pdo->prepare("
        INSERT INTO contact_messages (name, email, message)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([$name, $email, $message]);
}
?>

<div class="container">

    <div class="card">

<?php if ($submitted): ?>

    <p class="info-text">
    Thank you for your message. Your feedback has been received.
    </p>

<?php else: ?>

    <p>
    Feel free to send us a question or leave us a suggestion for how we can
    improve our services.
    </p>

<form method="POST" action="contact.php">

<div class="form-row">
    <label for="name">Name (optional):</label>
    <input type="text" id="name" name="name">
</div>

<div class="form-row">
    <label for="email">Email (optional):</label>
    <input type="email" id="email" name="email">
</div>

<div class="form-row">
    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="6" required></textarea>
</div>

    <button type="submit" class="login-card">
        Send Message
    </button>

</form>
<?php endif; ?>

</div>

</div>
