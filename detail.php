<?php 
include('inc/functions.php');

// Get the id from the URL and filter it
if(isset($_GET['id'])) {
    $entry_id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
    $journal_entry = get_journal_entry($entry_id);
    
    // put the array of tags related to this journal entry into the $tags variable
    $tags = get_tags($entry_id);
  
} 

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>MyJournal</title>
        <link href="https://fonts.googleapis.com/css?family=Cousine:400" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/site.css">
    </head>
    <body>
        <header>
            <div class="container">
                <div class="site-header">
                    <a class="logo" href="index.php"><i class="material-icons">library_books</i></a>
                    <a class="button icon-right" href="new.php"><span>New Entry</span> <i class="material-icons">add</i></a>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="entry-list single">
                    <article>
                          <?php
                          echo "<h1>" . $journal_entry['title'] . "</h1>";                        
                          echo "<time>" . $journal_entry['date'] . "</time>";
                        ?>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                        <p>    
                         <?php
                          echo $journal_entry['time_spent'];
                         ?>
                        </p> 
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p>
                                <?php 
                                echo $journal_entry['learned'];
                                ?>
                            </p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <p>
                            <?php 
                                echo $journal_entry['resources'];
                                ?>
                            </p>    
                        </div>
                        <div class="entry">
                            <h3>Tags:</h3>
                            
                            <ul>
                            <?php 
                               foreach($tags as $tag) {   
                               echo "<li>";      
                                              
                               echo "<a href='index.php?tag=" . $tag['tag_id']  ."'>" . $tag['tag_name'] . " </a>";
                               echo "</li>";
                               }                                
                            ?>
                            </ul>                            
                              
                        </div>
                    </article>
                </div>
            </div>
            <div class="edit">
            <p>
            <?php    
            echo "<a href='edit.php?id=" .$entry_id. "'>Edit Entry</a></li>";
            ?>
            </p>
              
            </div>
        </section>
        <footer>
            <div>
                &copy; MyJournal
            </div>
        </footer>
    </body>
</html>