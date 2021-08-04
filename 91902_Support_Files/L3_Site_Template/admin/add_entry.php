<?php

// check user is logged in...
if (isset($_SESSION['admin'])) {
    
    $author_ID = $_SESSION['Add_Quote'];
    echo "AuthorID: ".$author_ID;
    
    // Get subject / topic list from database
    $all_tags_sql = "SELECT * FROM `subject` ORDER BY `Subject` ASC ";
    $all_subjects = autocomplete_list($dbconnect, $all_tags_sql, 'Subject');
    
    // initialise form variables for quote
    $quote = "Please type your quote here";
    $notes = "";
    $tag_1 = "";
    $tag_2 = "";
    $tag_3 = "";
    
}   // end user logged in if

else{
    
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=../admin/login&error=$login_error");
    
}   // end user not logged in else

?>