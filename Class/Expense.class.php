<?php 
require_once ("Class/DB.class.php");

class Expense
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DB();
    }
    
    function addExpense($setup_date,$exp_type,$account,$amount,$desc) {

        $query = "INSERT INTO expense(setup_date,expense_type,account,amount,des) VALUES (?, ?, ?, ?,?)";

        $paramType = "siiis";
        $paramValue = array(
            $setup_date,
            $exp_type,
            $account,
            $amount,
            $desc
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);

        return $insertId;
    }
    
    function editExpense($exp_type,$account,$amount,$desc) {
        $query = "UPDATE expense SET amount = ?,des = ? WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array(
            $name,
            $des,
            $org_id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function deleteExpense($exp_id) {
        $query = "DELETE FROM expense WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $org_id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getExpenseById($exp_id) {
        $query = "SELECT * FROM account WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $exp_id
        );
        
        $result = $this->db_handle->runBaseQuery($query);
    }

    function getSpecificExpense($exp_id,$con) {

        $sql = "SELECT * FROM expense WHERE  id='$exp_id'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data=$row["amount"];
               echo $data;
            }
        } 
    }
    
    function getAllExpenses() {
        $sql = "SELECT * FROM expense ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getAllExpenseForSelection() {
        $sql = "SELECT * FROM expense ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);

          if (! empty($result)) {
            foreach ($result as $k => $v) {

           echo '<option value="'.$result[$k]["id"].'">'.$result[$k]["amount"].'</option>';

            }
        }
    }
}
?>