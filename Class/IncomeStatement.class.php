<?php 
require_once ("Class/DB.class.php");

class IncomeStatement
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DB();
    }
    
    function addIncomeStatement($setup_date,$category,$year,$account,$name,$debit,$credit,$balance,$date) {

        $query = "INSERT INTO income_statement(setup_date,category,finacialYear,account,name,debit,credit,balance,entry_date) VALUES (?,?,?,?,?,?,?,?,?)";

        $paramType ="sssssiiis";
        $paramValue =array(
            $setup_date,
            $category,
            $year,
            $account,
            $name,
            $debit,
            $credit,
            $balance,
            $date
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);

        return $insertId;
    }
    
    function editIncomeStatement($setup_date,$category,$name,$debit,$credit) {
        $query = "UPDATE income_statement SET amount = ?,des = ? WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array(
            $name,
            $des,
            $org_id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function deleteIncomeStatement($id) {
        $query = "DELETE FROM income_statement WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getIncomeStatementById($id) {
        $query = "SELECT * FROM income_statement WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $id
        );
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
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
    
    function getIncomeStatement() {
        $sql = "SELECT * FROM income_statement ORDER BY setup_date ASC";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

}
?>