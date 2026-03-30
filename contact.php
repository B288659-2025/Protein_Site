<?php
require 'menu.php';
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
