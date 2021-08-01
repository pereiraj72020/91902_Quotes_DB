<?php

if(!isset($_REQUEST['subject_ID']))
{
    header('Location: index.php');
}

$subject_to_find = $_REQUEST['subject_ID'];

    // get subject heading...
    $sub_sql = "SELECT * FROM `subject` WHERE `Subject_ID` = $subject_to_find";
    $sub_query = mysqli_query($dbconnect, $sub_sql);
    $sub_rs = mysqli_fetch_assoc($sub_query);

?>

<h2>Subject Results (<?php echo $sub_rs['Subject']?>)</h2>

<?php
    
// get quotes
$find_sql = "SELECT * FROM quotes
JOIN author ON (`author`.`Author_ID`=`quotes`.`Author_ID`)
WHERE `Subject1_ID` = $subject_to_find
OR `Subject2_ID` = $subject_to_find
OR `Subject3_ID` = $subject_to_find
";

$find_query = mysqli_query($dbconnect, $find_sql);
$find_rs = mysqli_fetch_assoc($find_query);

// Loop through results and display them...
do {
    
    $quote = preg_replace('/[^A-Za-z0-9.,\s\'\-]/', ' ', $find_rs['Quote']);
    
    // get author name
    include("get_author.php");
    
    ?>

    <div class="results">
    <p>
        <?php echo $quote; ?><br />
        
        <!-- display author name -->
        <a href="index.php?page=author&authorID=<?php echo
        $find_rs['Author_ID']; ?>">
            <?php echo $full_name; ?>
        </a>
        
    </p>

    <?php include("show_subjects.php"); ?>
        
</div>
    
    $full_name = $first." ".$middle." ".$last;
    
    
    <!-- subject tags go here -->
    <p>
        <?php
            $sub1_ID = $find_rs['Subject1_ID'];
            $sub2_ID = $find_rs['Subject2_ID'];
            $sub3_ID = $find_rs['Subject3_ID'];
    
            $all_subjects = array($sub1_ID, $sub2_ID, $sub3_ID);        
    
            // loop through subject ID's and look up the subject name 
            foreach($all_subjects as $subject) {
                // Get subject name
                $sub_sql = "SELECT * FROM `subject` WHERE `Subject_ID` = 
                $subject";
                $sub_query = mysqli_query($dbconnect, $sub_sql);
                $sub_rs = mysqli_fetch_assoc($sub_query);             
                
                if($subject != 0)
                {
                    
                
                
                ?>
            <!-- show subjects -->
            <span class="tag">
                <a href="index.php?page=subject&subjectID=<?php ?>">
                    <?php echo $sub_rs['Subject']; ?>
                </a>
            </span> &nbsp;
                
        <?php
        
            } // end subject exists if
                    
            unset($subject);
                
            } // end subject loop
    
        ?>    
    
    </p>

<br />

<?php
    
}   // end of display results 'do'
    
while($find_rs = mysqli_fetch_assoc($find_query))

?>