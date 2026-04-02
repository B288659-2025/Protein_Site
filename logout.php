<?php

// Start the session so we can access and remove session data
session_start();

// Remove all session variables to clear stored user information such as login status
session_regenerate_id(true);

// Clear all session data
$_SESSION = [];

// Remove all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect the user to the index page after logout
header("Location: index.php");

// Stop the script immediately after redirecting
exit;

?>

