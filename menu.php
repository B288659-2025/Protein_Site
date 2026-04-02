<?php

// Start the session if it has not started yet
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

// Load styles and header for all pages
require_once 'styles.php';
require_once 'header.php';

?>

<nav>

	<!-- Navigation links to different pages -->

	<a href="about.php">About</a>
	<a href="index.php">Search</a>
	<a href="seq.php">Sequences</a>
	<a href="align.php">Alignment</a>
	<a href="motif.php">Motif Scan</a>
	<a href="analysis.php">Analysis</a>
	<a href="previous.php">History</a>
	<a href="export.php">Export Results</a>
	<a href="read.php">Read More</a>
	<a href="help.php">Help</a>
	<a href="contact.php">Contact us</a>
	<a href="credits.php">Credits</a>

	<?php if (isset($_SESSION["id_user"]) && $_SESSION["id_user"] !== null): ?>

		<!-- Show logout link if user is logged in -->
		<a href="logout.php">Logout</a>

	<?php else: ?>

		<!-- Show login link if user is not logged in -->
		<a href="loginu.php">Login</a>

	<?php endif; ?>

</nav>

<main class="page-content">

<?php

// This function prints the footer at the bottom of the page
// It is written here in the menu page so when menu.php is included in any page, the footer is also included

function show_page_footer()
{
	echo "</div>";
	echo "<div class='footer'>";
	echo "Protalize Protein Analysis Toolkit<br>";
	echo "University of Edinburgh";
	echo "</div>";
	echo "</body>";
	echo "</html>";
}

// Run the footer function automatically when the page finishes
register_shutdown_function('show_page_footer');

?>
