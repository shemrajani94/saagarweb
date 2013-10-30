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
      <input type="text" name="key">
      <input type="submit" name="submit" value="Search" />
</form>




<?php


  $con=mysqli_connect("eu-cdbr-azure-west-b.cloudapp.net","bf2ba5fb6ac7d2","6d1aa0dc","saagarh");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

//if(!empty($_POST)) {
      // try {
       //  $key = $_POST['key'];
	
	$result = mysqli_query($con,"SELECT id, name, email, date, company FROM registration_tbl WHERE  name LIKE "saagar" or email like "Saagar" or company like "Saagar");
         // Insert data
     

echo "<table border='1'>
<tr>
<th>name</th>
<th>email</th>
<th>date</th>
<th>company</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['email'] . "</td>";
  echo "<td>" . $row['date'] . "</td>";
  echo "<td>" . $row['company'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysqli_close($con);
?>


</body>
</html>
