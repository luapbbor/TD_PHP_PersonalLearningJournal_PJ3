<?php
$error_message = " ";
include('inc/functions.php');

// If a form was posted with POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get all the input from form and filter it
    $title = filter_input(INPUT_POST, 'title',FILTER_SANITIZE_STRING);
    $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
    $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_STRING);
    $learned = filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING);
    $resources = filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING);
   

    // If title, time spent or learned are empty show error
    if (empty($title) || empty($time_spent)|| empty($learned)) {
        $error_message = "Please fill in required fields - Title, Time Spent & Learned. ";
    } else {
        // Else call the function to add the new journal entry into the database
        if(add_journal_entry($title,$date,$time_spent,$learned,$resources)){
           $error_message = "Your new journal entry has been added !";
        } else {
            $error_message = "Sorry, could not add your Journal entry";           
        }
    }
}


// When the submit button is pressed
// Cannot put it into the previous $_SERVER['REQUEST_METHOD'] == 'POST' as the journal entry needs to be inserted into the database first
if(isset($_POST['submit'])){
    // If any of the tag checkboxes are checked
    if(!empty($_POST['tags'])) {
        // Get the id of the last entered journal entry
        foreach(get_latest_entry() as $entry){
        $entry_id = $entry;
        }
    // get the tag id of each tag that was checked     
    foreach($_POST['tags'] as $tag_id){
    // Insert into the entries_tags_link table with the "add_tags" function
    add_tags($entry_id,$tag_id);    
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
                <div class="new-entry">
                    <p>
                    <?php echo $error_message; ?>
                    </p>
                    <h2>New Entry</h2>
                    <form method="post">
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="time-spent" type="text" name="timeSpent"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"></textarea>
                        <h3>Tags</h3>
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
                        <input type="submit" name='submit' value="Publish Entry" class="button">
                        <a href="index.php" class="button button-secondary">Cancel</a>
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