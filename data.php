  <?php  
 //fetch.php  
 $connect = mysqli_connect("localhost", "root", "", "PTFinance"); 
  
 
$query = "SELECT * FROM income_statement ";  
$result = mysqli_query($connect, $query);  
$row = mysqli_fetch_array($result);  
echo json_encode($row);  

 ?>
 