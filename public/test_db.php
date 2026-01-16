<?php

try {
    $pdo = new PDO('sqlite:C:\Users\sliml\Desktop\magang\mutiara-web\database\database.sqlite');
    echo 'Connected successfully';
} catch (PDOException $e) {
    echo 'Connection failed: '.$e->getMessage();
    echo '<br>Available Drivers:<br>';
    print_r(PDO::getAvailableDrivers());
}
