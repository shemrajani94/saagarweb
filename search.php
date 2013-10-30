<html>
<head>
<Title>Search Form</Title>
<style type="text/css">
   body { background-color: #fff; border-top: solid 10px #000;
	  color: #333; font-size: .85em; margin: 20; padding: 20;
	  font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 }
   h1, h2, h3, h4, h5,  { color: #000; margin-bottom: 0; padding-bottom: 0; }
     h1 { font-size: 2em; }
     h2 { font-size: 1.75em; }
     h3 { font-size: 1.2em; }
     h4 { font-size: 1.2em; }
     h5 { font-size: 1.2em; }
     table { margin-top: 0.75em; }
     th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
     td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Search here!</h1>
    <p>Fill in your name, email address and company, then click <strong>Submit</strong> to register.</p>
<form method="post" action="search.php" id="searchform" >
      <input type="text" name="name">
      <input type="submit" name="submit" value="Search" />
</form>

<?php
    if(isset($_POST['submit'])){ 
	 $name=$_POST['name']; 
	 
	 
	// DB connection info
    //TODO: Update the values for $host, $user, $pwd, and $db
    //using the values you retrieved earlier from the portal.
    $host = "eu-cdbr-azure-west-b.cloudapp.net";
     $user = "bf2ba5fb6ac7d2";
     $pwd = "6d1aa0dc";
     $db = "saagarh";
     // Connect to database.
     try {
       $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
       $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
     }
     catch(Exception $e){
       die(var_dump($e));
     } 
     
     $sql="SELECT id, name, email, date, company FROM registration_tbl WHERE  name LIKE '%"$name"%' OR email LIKE '%"$name"%' OR company LIKE '%"$name"%'";
	  
	$result=mysql_query($sql);
	
	
	//-create  while loop and loop through result set 
	while($row=mysql_fetch_array($result)){ 
	          $Rname  =$row['name']; 
	          $email =$row['email']; 
	          $company =$row['company']; 
	          $id = $row['id']; 
	          $date = $row['date'];
	          
	  //-display the result of the array 
	  echo "<ul>\n"; 
	  echo "<li>" . "<a  href=\"search.php?id=$id\">"   $Rname . $email . $company . $date"</a></li>\n"; 
	  echo "</ul>"; 
	  } 

	
	else{ 
	  
	  echo  "<p>Please enter a search query</p>"; 
	  
	  } 
    
}
    
?>
</body>
</html>
