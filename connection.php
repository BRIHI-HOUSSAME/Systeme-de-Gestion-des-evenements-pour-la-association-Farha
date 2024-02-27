<?php
    $dsn = 'mysql:host=localhost;dbname=farha';
    $user = 'root';
    $pass = 'Hossam2003@SQL';



try {
    $DB = new PDO($dsn, $user, $pass);
    $DB->exec('USE farha');
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'failed ' . $e->getMessage();
}




?>