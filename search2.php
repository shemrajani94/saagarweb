 <?php
/*****************************
 *  Simple SQL Search Tutorial by Frost
 *  of Slunked.com
 ******************************/

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
      $searchSQL = "SELECT id, name, email, company FROM registration_tbl WHERE ";
      
      // grab the search types.
      $types = array();
      $types[] = isset($_GET['body'])?"`name` LIKE '%{$searchTermDB}%'":'';
      $types[] = isset($_GET['title'])?"`email` LIKE '%{$searchTermDB}%'":'';
      $types[] = isset($_GET['desc'])?"`company` LIKE '%{$searchTermDB}%'":'';
      
      $types = array_filter($types, "removeEmpty"); // removes any item that was empty (not checked)
      
      if (count($types) < 1)
         $types[] = "`name` LIKE '%{$searchTermDB}%'"; // use the body as a default search if none are checked
      
          $andOr = isset($_GET['matchall'])?'AND':'OR';
      $searchSQL .= implode(" {$andOr} ", $types) . " ORDER BY `email`"; // order by title.

      $searchResult = mysql_query($searchSQL) or trigger_error("There was an error.<br/>" . mysql_error() . "<br />SQL Was: {$searchSQL}");
      
      if (mysql_num_rows($searchResult) < 1) {
         $error[] = "The search term provided {$searchTerms} yielded no results.";
      }else {
        
        echo "<table border='1'>
        <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Company</th>
        </tr>";

         $results = array(); // the result array
        while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['email'] . "</td>";
  echo "<td>" . $row['company'] . "</td>";
  echo "</tr>";
  }
  echo "</table>";
        
        
        
        //$i = 1;
       //  while ($row = mysql_fetch_assoc($searchResult)) {
       //     $results[] = "{$i}: {$row['name']}<br />{$row['email']}<br />{$row['company']}<br /><br />";
        //    $i++;
         }
      }
   }
}

function removeEmpty($var) {
   return (!empty($var)); 
}
?>
<html>
   <title>My Simple Search Form</title>
   <style type="text/css">
      #error {
         color: red;
      }
   </style>
   <body>
      <?php echo (count($error) > 0)?"The following had errors:<br /><span id=\"error\">" . implode("<br />", $error) . "</span><br /><br />":""; ?>
      <form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>" name="searchForm">
         Search For: <input type="text" name="search" value="<?php echo isset($searchTerms)?htmlspecialchars($searchTerms):''; ?>" /><br />
         Search In:<br />
         Body: <input type="checkbox" name="body" value="on" <?php echo isset($_GET['body'])?"checked":''; ?> /> | 
         Title: <input type="checkbox" name="title" value="on" <?php echo isset($_GET['title'])?"checked":''; ?> /> | 
         Description: <input type="checkbox" name="desc" value="on" <?php echo isset($_GET['desc'])?"checked":''; ?> /><br />
                 Match All Selected Fields? <input type="checkbox" name="matchall" value="on" <?php echo isset($_GET['matchall'])?"checked":''; ?><br /><br />
         <input type="submit" name="submit" value="Search!" />
      </form>
      <?php echo (count($results) > 0)?"Your search term: {$searchTerms} returned:<br /><br />" . implode("", $results):""; ?>
   </body>
</html>
