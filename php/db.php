<?php
$HOSTNAME = "db";
$DB_NAME = "users_db";
$USERNAME = "root";
$PASSWORD = "atm";

try {
  $db = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DB_NAME) or die('Could not connect: ' . mysql_error());
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>