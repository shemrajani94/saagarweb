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
    <p>Search the database by inputting the name, email address and company you are looking for. 
    If have a specific query for a certain field then leave it blank.</p>
<form method="post" action="search.php" enctype="multipart/form-data" >
      Name  <input type="text" name="name" id="name"/></br>
      Email <input type="text" name="email" id="email"/></br>
      Company <input type="text" name="company" id="company"/></br>
      <input type="search" name="search" value="search" />
</form>
<?php
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
     // Insert registration info
     if(!empty($_POST)) {
       try {
	 $name = $_POST['name'];
	 $email = $_POST['email'];
	 $company = $_POST['company'];
	 $date = date("Y-m-d");
	 // Insert data
        $sql_select = "SELECT * FROM registration_tbl WHERE (name, email, company) 
                   VALUES (?,?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $company);
        $stmt->execute();
       }
       catch(Exception $e) {
	 die(var_dump($e));
       }
       echo "<h3>Your're registered!</h3>";
     }
     // Retrieve data
     $sql_select = "SELECT * FROM registration_tbl";
     $stmt = $conn->query($sql_select);
     $registrants = $stmt->fetchAll(); 
     if(count($registrants) > 0) {
       echo "<h2>People who are registered:</h2>";
       echo "<table>";
       echo "<tr><th>Name</th>";
       echo "<th>Email</th>";
       echo "<th>Date</th>";
       echo "<th>Company</th></tr>";
       foreach($registrants as $registrant) {
	 echo "<tr><td>".$registrant['name']."</td>";
	 echo "<td>".$registrant['email']."</td>";
	 echo "<td>".$registrant['date']."</td>";
	 echo "<td>".$registrant['company']."</td></tr>";
       }
       echo "</table>";
     } else {
       echo "<h3>No one is currently registered.</h3>";
     }
?>
</body>
</html>