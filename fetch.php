  <?php  
 //fetch.php  
 $connect = mysqli_connect("localhost", "root", "", "PTFinance"); 
  
 if(isset($_POST["id"]))  
 {  
      $query = "SELECT * FROM organisation WHERE id = '".$_POST["id"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }elseif(isset($_POST["year_id"])){
 	
 	  $query = "SELECT * FROM financialYear WHERE id = '".$_POST["year_id"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row); 
 }  
 ?>
 