<?php

$dbHost = 'eu-cdbr-azure-west-b.cloudapp.net'; // localhost will be used in most cases
// set these to your mysql database username and password.
$dbUser = 'bf2ba5fb6ac7d2'; 
$dbPass = '6d1aa0dc';
$dbDatabase = 'saagarh'; // the database you put the table into.
$con = mysql_connect($dbHost, $dbUser, $dbPass) or trigger_error("Failed to connect to MySQL Server. Error: " . mysql_error());

mysql_select_db($dbDatabase) or trigger_error("Failed to connect to database {$dbDatabase}. Error: " . mysql_error());

// Set up our error check and result check array
$error = array();
$results = array();

// First check if a form was submitted. 
// Since this is a search we will use $_GET
if (isset($_GET['search'])) {
   $searchTerms = trim($_GET['search']);
   $searchTerms = strip_tags($searchTerms); // remove any html/javascript.
   
   if (strlen($searchTerms) < 3) {
      $error[] = "Search terms must be longer than 3 characters.";
   }else {
      $searchTermDB = mysql_real_escape_string($searchTerms); // prevent sql injection.
   }
   
   // If there are no errors, lets get the search going.
   if (count($error) < 1) {
      $searchSQL = "SELECT id, name, email, company, date FROM registration_tbl WHERE ";
      
      // grab the search types.
      $types = array();
      $types[] = isset($_GET['sname'])?"`name` LIKE '%{$searchTermDB}%'":'';
      $types[] = isset($_GET['stitle'])?"`email` LIKE '%{$searchTermDB}%'":'';
      $types[] = isset($_GET['scompany'])?"`company` LIKE '%{$searchTermDB}%'":'';
      
      $types = array_filter($types, "removeEmpty"); // removes any item that was empty (not checked)
      
      if (count($types) < 1)
         $types[] = "`name` LIKE '%{$searchTermDB}%'"; // use the name as a default search if none are checked
      
          $andOr = isset($_GET['matchall'])?'AND':'OR';
      $searchSQL .= implode(" {$andOr} ", $types) . " ORDER BY `email`"; // order by email.

      $searchResult = mysql_query($searchSQL) or trigger_error("There was an error.<br/>" . mysql_error() . "<br />SQL Was: {$searchSQL}");
      
      if (mysql_num_rows($searchResult) < 1) {
         $error[] = "The search term provided {$searchTerms} yielded no results.";
      }else {
         $results = array(); // the result array
         $i = 1;
         while ($row = mysql_fetch_assoc($searchResult)) {
            
           $results[] = "---Result {$i}---<br /><strong>ID:</strong> {$row['id']}<br /> <strong>Name:</strong>  {$row['name']}<br />  <strong>Email Address:</strong> {$row['email']}<br />   <strong>Company: </strong> {$row['company']}<br /><strong>Date Added: </strong> {$row['date']}<br /><br />";
            $i++;
         }
      }
   }
}

function removeEmpty($var) {
   return (!empty($var)); 
}
?>
<html>
   <title>Search Form</title>
   <style type="text/css">
      #error {
         color: red;
      }
   </style>
   <body>
      <?php echo (count($error) > 0)?"The following had errors:<br /><span id=\"error\">" . implode("<br />", $error) . "</span><br /><br />":""; ?>
      <form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>" name="searchForm">
         Search For: <input type="text" name="search" value="<?php echo isset($searchTerms)?htmlspecialchars($searchTerms):''; ?>" /><br />
         Search In: (If nothing is selected, I will only search for name)<br />
         Name: <input type="checkbox" name="sname" value="on" <?php echo isset($_GET['sname'])?"checked":''; ?> /> | 
         Email: <input type="checkbox" name="stitle" value="on" <?php echo isset($_GET['stitle'])?"checked":''; ?> /> | 
         Company: <input type="checkbox" name="scompany" value="on" <?php echo isset($_GET['scompany'])?"checked":''; ?> /><br />
                 Match All Selected Fields? <input type="checkbox" name="matchall" value="on" <?php echo isset($_GET['matchall'])?"checked":''; ?><br /><br />
         <input type="submit" name="submit" value="Search!" />
      </form>
      <?php echo (count($results) > 0)?"Your search term: {$searchTerms} returned:<br /><br />" . implode("", $results):""; ?>
   </body>
</html>
