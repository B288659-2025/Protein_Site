<?php

// Start the session so we can access and remove session data
session_start();

// Remove all session variables to clear stored user information such as login status
session_unset();

// Destroy the session completely to log the user out securely
session_destroy();

// Redirect the user to the dashboard page after logout
header("Location: dash.php");

// Stop the script immediately after redirecting
exit();

?>
