<?php
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
}catch (Exception $e) {
    echo "could not connect to the database" . $e->getMessage() . $e->getFile();
}