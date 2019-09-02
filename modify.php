<html>
<body>

<?php

$conn = mysqli_connect("remotemysql.com","fKAjehLO2Y","DG1B4qhwpV", "fKAjehLO2Y");

if ($conn == false)

  {

  die('Could not connect: ' . mysqli_connect_error());

  }


$sql="UPDATE loansApp.Loans
SET Amount_Due = (Amount_Due - $_POST[amount]), Last_Payment = NOW() -- make date/time display time
WHERE ID = $_POST[id];";

$sqlReverse="UPDATE loansApp.Loans
SET Amount_Due = (Amount_Due + $_POST[amount]) 
WHERE ID = $_POST[id];";

$sqlDelete="DELETE FROM loansApp.Loans
WHERE ID = $_POST[id];";

$sqlSelect="SELECT Amount_Due 
FROM loansApp.Loans 
WHERE ID = $_POST[id];";

$sqlSelectTable="SELECT ID
FROM loansApp.Loans
WHERE ID = $_POST[id];";

  

  if (mysqli_query($conn, $sql)) {
    $id = $_POST[id];
    echo $id;
    $sqlInsert1="INSERT INTO loansApp.ID$id(transaction_date, Amount)
                VALUES (NOW(), $_POST[amount]);";
                echo $sqlInsert1;
    if (mysqli_query($conn, $sqlInsert1)) {
      echo "It Worked!";
    }
 
  $query = $conn->prepare($sqlSelect); // prepate a query
  $query->bind_param('i', $amount_due); // binding parameters via a safer way than via direct insertion into the query. 'i' tells mysql that it should expect an integer.
  $query->execute(); // actually perform the query
  $result = $query->get_result(); // retrieve the result so it can be used inside PHP
  $r = $result->fetch_array(MYSQLI_ASSOC); // bind the data from the first result row to $r
  
  if($r['Amount_Due'] == 0){
    if(mysqli_query($conn, $sqlDelete)) {
      echo "Congratulations! You Have Paid Off This Loan! Thank you for your payment!";
  
      $id = $_POST['id'];

      $sqlDeleteTable="DROP TABLE loansApp.ID$id;";
      
      if (mysqli_query($conn, $sqlDeleteTable)){
        
        }
      }
    }
  else if ($r['Amount_Due'] < 0) {
    if(mysqli_query($conn, $sqlReverse)){
      echo "You don't owe that much! Please try again.";
    }
  }

  else {
    echo "Thank you for your payment! ";
  }
 }

else{
    echo "Not able to execute $sql. " . mysqli_error($conn);
}

mysqli_close($conn);

?>

<a href="index.php"> <p>Back</p></a>

</body>

</html>