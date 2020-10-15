<?php 
$error_message = " ";

// Get the id from the URL
include('inc/functions.php');
if(isset($_GET['id'])) {
    $entry_id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
    // Assigns the function get_journal_entry to the variable $journal_entry as an array
    $journal_entry = get_journal_entry($entry_id);
    $journal_entry_tags = get_tags($entry_id);
    $all_tags = get_all_tags();   
    } 


// When the form is posted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input from the form
    $title = filter_input(INPUT_POST, 'title',FILTER_SANITIZE_STRING);
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING);
    $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
    $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);
    // If title, time spent or learned are empty show error
    if (empty($title) || empty($time_spent)|| empty($learned)) {
        $error_message = "Please fill in required fields - Title, Time Spent & Learned ";
    } else {
        // else attempt to update the journal entry in the database
        if(edit_journal_entry($title,$date,$time_spent,$learned,$resources,$entry_id)){
            delete_tags($entry_id);
            foreach($_POST['tags'] as $tag_id){
                add_tags($entry_id,$tag_id);
            }
            header('Location: detail.php?id=' . $entry_id);
            exit;
        } else {
            $error_message = "Sorry, could not edit Journal entry";
        }
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
                <div class="edit-entry">
                <?php echo $error_message; ?>
                    <h2>Edit Entry</h2>
                    <form method="post">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title" value="<?php echo $journal_entry['title'];?>"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date" value="<?php echo $journal_entry['date'];?>"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent" value="<?php echo $journal_entry['time_spent'];?>"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned" ><?php echo $journal_entry['learned'];?></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember" ><?php echo $journal_entry['resources'];?></textarea>
                        <h3>Tags:</h3>
                            
                            <ul>
    <input type="checkbox" name='tags[]' value="1"> PHP <br/>
    <input type="checkbox" name='tags[]' value="2"> PDO <br/>
    <input type="checkbox" name='tags[]' value="3"> HTML <br/>
    <input type="checkbox" name='tags[]' value="4"> SQL <br/>
    <input type="checkbox" name='tags[]' value="5"> Javascript <br/>
    <input type="checkbox" name='tags[]' value="6"> SASS<br/>
    <input type="checkbox" name='tags[]' value="7"> Bootstrap <br/>
    <input type="checkbox" name='tags[]' value="8"> CSS <br/>
                                                        </ul>     
                        <input type="submit" value="Publish Entry" class="button">
                        <a href="detail.php?id='<?php echo $entry_id;  ?>''" class="button button-secondary">Cancel</a>
                    </form>
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