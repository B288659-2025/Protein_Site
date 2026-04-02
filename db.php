<?php

// Set the PDO connection to the database
$pdo = new PDO(
    "mysql:host=127.0.0.1;dbname=s2794196_website",
    "s2794196",
    'T15$o76!m98;'
);

// Throw errors instead of silently failing
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

