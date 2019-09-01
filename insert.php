<html>

<body>

 

 

<?php

$conn = mysqli_connect("localhost","root","root");

if ($conn == false)

  {

  die('Could not connect: ' . mysqli_connect_error());

  }


$sqlInsert="INSERT INTO loansApp.Loans(Recipient, Reason, Amount_Due)
VALUES ('$_POST[recipient]', '$_POST[reason]','$_POST[amountDue]');";

$sqlSelect="SELECT ID FROM loansApp.Loans ORDER BY ID DESC LIMIT 1;";

// $sqlCreate="CREATE TABLE `loansApp`.`ID$id` ( `Date` DATE NOT NULL , `Amount` FLOAT NOT NULL ) ENGINE = InnoDB;
// ";

if (mysqli_query($conn, $sqlInsert)) {
  echo "1 record added";

  $query = $conn->prepare($sqlSelect); // prepate a query
  $query->bind_param('i', $id); // binding parameters via a safer way than via direct insertion into the query. 'i' tells mysql that it should expect an integer.
  $query->execute(); // actually perform the query
  $result = $query->get_result(); // retrieve the result so it can be used inside PHP
  $r = $result->fetch_array(MYSQLI_ASSOC);
  $id = $r['ID']; // bind the data from the first result row to $r

  $sqlCreate="CREATE TABLE `loansApp`.`ID$id` ( `transaction_date` DATE NOT NULL , `Amount` FLOAT NOT NULL );";
  
  if (mysqli_query($conn, $sqlCreate)){
    
    }

 }

else{
    echo "Not able to execute $sqlInsert. " . mysqli_error($conn);
}



 

mysqli_close($conn);

?>

<a href="index.php"> <p>Back</p></a>

</body>

</html>