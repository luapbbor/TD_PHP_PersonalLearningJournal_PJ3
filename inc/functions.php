<?php

// --------------------------------------------------------------------------//
// -------------------------       SELECTS        ---------------------------//
// --------------------------------------------------------------------------//

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

// This function gets a list of tags that are related to the journal entry.
// @param $entry_id is obtain from the URL
function get_tags($entry_id) {
  include('dbconnect.php');
  
  $sql = 'SELECT * FROM tags
          INNER JOIN entries_tags_link
          ON tags.id = entries_tags_link.tag_id
          WHERE entries_tags_link.entry_id = ?';    
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$entry_id,PDO::PARAM_INT);
    $results->execute();
    return $results->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }  
 }

// This function returns the id of the last entered journal entry from the "entries" table
function get_latest_entry() {
  include('dbconnect.php');
    
  $sql = 'SELECT id FROM entries ORDER BY id DESC LIMIT 1';
    
  try {
    $results = $db->prepare($sql);
    $results->execute();
    return $results->fetch(PDO::FETCH_ASSOC);
    print_r($results);
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  } 
}

 

// --------------------------------------------------------------------------//
// -------------------------      INSERTS        ---------------------------//
// --------------------------------------------------------------------------//

// This function adds the entry_id and tag_id into the "entries_tags_link" table
// Entry id is pulled from the get_latest_entry() function
// tag id is pulled from the form when it is submitted
function add_tags($entry_id,$tag_id) {
  include('dbconnect.php');
  $sql = 'INSERT INTO entries_tags_link(entry_id,tag_id) VALUES(?,?)';
  try {
    $results = $db->prepare($sql);
    $results->bindValue(1,$entry_id,PDO::PARAM_INT);
    $results->bindValue(2,$tag_id,PDO::PARAM_INT);
     $results->execute();
  } catch (Exception $e) {
    echo $e->getMessage();
    return false;
  }
  return true;
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

// --------------------------------------------------------------------------//
// -------------------------      UPDATES        ---------------------------//
// --------------------------------------------------------------------------//

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



// --------------------------------------------------------------------------//
// -------------------------       DELETES       ---------------------------//
// --------------------------------------------------------------------------//

// This function deletes a journal entry from the table "entries"
// @ param $entry_id is obtained from the foreach loop (index.php) that loops through each item in the get_journal_entries function
function delete_entry($entry_id) {
  include('dbconnect.php');
      
  $sql = 'DELETE FROM entries WHERE id = ?';
      
  try {
     $results = $db->prepare($sql);
     $results->bindValue(1,$entry_id,PDO::PARAM_INT);
     $results->execute();
      // activate use of foreign key constraints
  $db->exec( 'PRAGMA foreign_keys = ON;' );
  } catch (Exception $e) {
     echo $e->getMessage();
  return false;
  }
   return $results->fetch();
}

// This function deletes tags that are related to a journal entry
function delete_tags($entry_id) {
  include('dbconnect.php');
      
  $sql = 'DELETE FROM entries_tags_link WHERE entry_id = ?';
      
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
