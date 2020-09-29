<?php 

// Remove before going live
ini_set('display_errors','On');

// Connect to database
try {
$db = new PDO('sqlite:./inc/journal.db');
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $e->getMessage();
  die();

}
?>
