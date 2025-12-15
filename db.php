<?php

$link = mysqli_connect("db", "appuser", "apppassword", "app");

if (!$link) {
    die("Failed to connect to db: " . mysqli_connect_error());
}

$createTable = "CREATE TABLE IF NOT EXISTS users(
    id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

mysqli_query($link, $createTable);