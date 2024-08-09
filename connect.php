<?php

define('DB_DSN','mysql:host=172.18.0.2;dbname=ep_steps;charset=utf8');
define('DB_USER','admin_user');
define('DB_PASS','pass123');

try {
    $db = new PDO(DB_DSN, DB_USER, DB_PASS);
    
} catch (PDOException $e) {
    print "Error: " . $e->getMessage();
    die(); 
}

?>