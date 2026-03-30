<?php

session_start();

session_regenerate_id(true);

$_SESSION = [];

session_unset();

session_destroy();

header("Location: index.php");

exit;

?>
