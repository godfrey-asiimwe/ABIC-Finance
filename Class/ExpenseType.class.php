<?php 
require_once ("Class/DB.class.php");

class ExpenseType
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DB();
    }
    
    function addExpenseType($setup_date,$name,$des) {

        $query = "INSERT INTO expenseType(setup_date,name,des) VALUES (?, ?, ?)";
        $paramType = "sss";
        $paramValue = array(
            $setup_date,
            $name,
            $des
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);

        return $insertId;
    }
    
    function editExpenseType($name,$des,$id) {
        $query = "UPDATE expenseType SET name = ?,des = ? WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array(
            $name,
            $des,
            $id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function deleteExpenseType($id) {
        $query = "DELETE FROM expenseType WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $org_id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getExpenseTypeById($exp_Type_id) {
        $query = "SELECT * FROM expenseType WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $exp_Type_id
        );
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getSpecificExpenseType($exp_Type_id,$con) {

        $sql = "SELECT * FROM expenseType WHERE  id='$exp_Type_id'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data=$row["name"];
               echo $data;
            }
        } 
    }
    
    function getAllExpenseTypes() {
        $sql = "SELECT * FROM expenseType ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getAllExpenseTypesForSelection() {
        $sql = "SELECT * FROM expenseType ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);

          if (! empty($result)) {
            foreach ($result as $k => $v) {

           echo '<option value="'.$result[$k]["id"].'">'.$result[$k]["name"].'</option>';

            }
        }
    }
}
?>