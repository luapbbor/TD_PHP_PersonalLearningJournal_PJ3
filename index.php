<?php 
include('./inc/functions.php');

// If a form was posted with POST method, look for the input with name delete
if(isset($_POST['delete'])) {
$entry_id = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT);
    // call the function to delete the entry with the id
    if(delete_entry($entry_id)){
        
    } else {
        delete_tags($entry_id);
        header('Location: index.php');
        exit;
    }
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
            <div class="entry-list">    
                <?php 
                // If "tag" is in the URL
                if(isset($_GET['tag'])) {
                    // filter the input
                    $tag_id = filter_input(INPUT_GET, 'tag',FILTER_SANITIZE_NUMBER_INT);
                    // Get all journal entries with the tag id that is in the URL
                    foreach (get_entries_by_tag($tag_id) as $entry) {
                        echo "<article>";
                        echo "<h2>";
                        echo "<li><a href='detail.php?id=" .$entry['id'] . "'>" .
                        $entry['title'] . "</a></li>";
                        echo "<time>";
                        echo $entry['date'];
                        echo "</time>";
                        echo "</h2>";
                        $entry_id = $entry['id'];
                        foreach( get_tags($entry_id) as $tag){
                        echo "<a href='index.php?tag=" . $tag['tag_id']  ."'>" . " " . $tag['tag_name'] . " " . " </a>";
                        }
                        echo "<form method='post' action='index.php' onsubmit=\"return
                        confirm('Are you sure you want to delete this task?');\">\n";
                        echo "<input type='hidden' value='". $entry['id'] . "' name='delete'
                        ?>\n";
                        echo "<input type='submit' class='button button-secondary' value='Delete' />\n";
                        echo "</form>";
                        echo "</article>";
                    }
                
                } else {
                    foreach(get_journal_entries() as $entry) {
                        echo "<article>";
                        echo "<h2>";
                        echo "<li><a href='detail.php?id=" .$entry['id'] . "'>" .
                        $entry['title'] . "</a></li>";
                        echo "<time>";
                        echo $entry['date'];
                        echo "</time>";
                        echo "</h2>";
                        $entry_id = $entry['id'];
                        foreach( get_tags($entry_id) as $tag){
                        echo "<a href='index.php?tag=" . $tag['tag_id']  ."'>" . " " . $tag['tag_name'] . " " . " </a>";
                        }
                        echo "<form method='post' action='index.php' onsubmit=\"return
                        confirm('Are you sure you want to delete this task?');\">\n";
                        echo "<input type='hidden' value='". $entry['id'] . "' name='delete'
                        ?>\n";
                        echo "<input type='submit' class='button button-secondary' value='Delete' />\n";
                        echo "</form>";echo "</article>";
                                
                    }
                }
                ?>                   
                </div>
            </div>
        </section>
        <footer>
            <div>
                &copy; MyJournal
            </div>
        </footer>
    </body>
</html>