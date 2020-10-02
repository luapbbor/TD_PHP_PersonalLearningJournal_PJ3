<?php

// This function obtains a list of all journal entries
function get_journal_entries() {
  include('dbconnect.php');
   try {
   return $db->query('SELECT * FROM entries ORDER BY date DESC');
   } catch (Exception $e) {
     echo "Error!:" . $e->getMessage() . "</br>";
     return array();
   }   
 }

// This function obtains a single journal entry via the id in the URL
// It returns the result as an array
function get_journal_entry($entry_id) {
include('dbconnect.php');
  
$sql = 'SELECT * FROM entries WHERE id = ?';
  
try {
  $results = $db->prepare($sql);
  $results->bindValue(1,$entry_id,PDO::PARAM_INT);
  $results->execute();
  return $results->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo $e->getMessage();
  return false;
} 
 
}

// This function adds a new journal entry into the database table "entries"
// @param $title, $date, $time_spent, $learned and $resources are all obtained from the form input
function add_journal_entry($title,$date,$time_spent,$learned,$resources) {
include('dbconnect.php');
$sql = 'INSERT INTO entries(title,date,time_spent,learned,resources) VALUES(?,?,?,?,?)';
try {
  $results = $db->prepare($sql);
  $results->bindValue(1,$title,PDO::PARAM_STR);
  $results->bindValue(2,$date,PDO::PARAM_STR);
  $results->bindValue(3,$time_spent,PDO::PARAM_STR);
  $results->bindValue(4,$learned,PDO::PARAM_STR);
  $results->bindValue(5,$resources,PDO::PARAM_STR);
  $results->execute();
} catch (Exception $e) {
  echo $e->getMessage();
  return false;
}
return true;
}

// This function updates a journal entry in the database table "entries"
// @param $title, $date, $time_spent, $learned and $resources are all obtained from the form input
function edit_journal_entry($title,$date,$time_spent,$learned,$resources,$entry_id) {
include('dbconnect.php');
  
$sql = "UPDATE entries SET title = ?,date = ?,time_spent = ?,learned = ?, resources = ? WHERE id = ?";
  
try {
  $results = $db->prepare($sql);
  $results->bindValue(1,$title,PDO::PARAM_STR);
  $results->bindValue(2,$date,PDO::PARAM_STR);
  $results->bindValue(3,$time_spent,PDO::PARAM_STR);
  $results->bindValue(4,$learned,PDO::PARAM_STR);
  $results->bindValue(5,$resources,PDO::PARAM_STR);
  $results->bindValue(6,$entry_id,PDO::PARAM_INT);
  $results->execute();
  $db = null;
} catch (Exception $e) {
   echo $e->getMessage();
return false;
}
return true;
}

// This function deletes a journal entry from the table "entries"
// @ param $entry_id is obtained from the foreach loop (index.php) that loops through each item in the get_journal_entries function
function delete_entry($entry_id) {
include('dbconnect.php');
    
$sql = 'DELETE FROM entries WHERE id = ?';
    
try {
   $results = $db->prepare($sql);
   $results->bindValue(1,$entry_id,PDO::PARAM_INT);
   $results->execute();
} catch (Exception $e) {
   echo $e->getMessage();
return false;
}
 return $results->fetch();
}
   
?>
