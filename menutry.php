<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'styles.php';
require_once 'header.php';
?>

<nav>

<div class="nav-left">

<a href="index.php">Search</a>
<a href="about.php">About</a>
<a href="seq.php">Sequences</a>
<a href="align.php">Alignment</a>
<a href="motif.php">Motif Scan</a>
<a href="analysis.php">Analysis</a>
<a href="previous.php">History</a>
<a href="export.php">Export Results</a>
<a href="read.php">Read More</a>
<a href="credits.php">Credits</a>

</div>

<div class="nav-right">

<a href="help.php">Help</a>
<a href="contact.php">Contact us</a>

<?php if (isset($_SESSION["id_user"]) && $_SESSION["id_user"] !== null): ?>

<a href="logout.php">Logout</a>

<?php else: ?>

<a href="loginu.php">Login</a>

<?php endif; ?>

</div>

</nav>
<main class="page-content">

<?php

function render_footer() {
    echo "</div>";
    echo "<div class='footer'>";
    echo "Protalyze Protein Analysis Toolkit<br>";
    echo "University of Edinburgh";
    echo "</div>";
    echo "</body>";
    echo "</html>";
}

register_shutdown_function('render_footer');

?>
