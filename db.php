<?php

// Set the PDO connection to the database - will be reset for submission
$pdo = new PDO(
    "mysql:host=127.0.0.1;dbname=DATABASE_NAME",
    "USERNAME",
    "PASSWORD"
);

// Turn off foreign key checks so old data can be deleted safely
$pdo->exec("Set foreign_key_checks = 0");

// Delete guest analyses older than 1 day
// Source along with embedded source: https://stackoverflow.com/questions/8544438/select-records-from-now-1-day
$pdo->exec("delete from analyses where id_user is null and session_id is not null and created_at < NOW() - interval 1 day");

// Turn foreign key checks back on
$pdo->exec("Set foreign_key_checks = 1");
