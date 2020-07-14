<?php 
require_once ("Class/DB.class.php");

class Deposit
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DB();
    }
    
    function addDeposit($setup_date,$acc,$amount,$des) {

        $query = "INSERT INTO deposit(setup_date,account,amount,des) VALUES (?, ?, ?, ?)";

        $paramType = "siis";
        $paramValue = array(
            $setup_date,
            $acc,
            $amount,
            $des
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);
        

        return $insertId;
    }
    
    function editDeposit($setup_date,$acc,$amount,$des) {
        $query = "UPDATE deposit SET name = ?,des = ? WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array(
            $name,
            $des,
            $org_id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function deleteDeposit($id) {
        $query = "DELETE FROM deposit WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getDepositById($id) {
        $query = "SELECT * FROM deposit WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $id
        );
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }
    
    function getAllDeposits() {
        $sql = "SELECT * FROM deposit ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getAllDepositForSelcetion() {
        $sql = "SELECT * FROM deposit ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);

          if (! empty($result)) {
            foreach ($result as $k => $v) {

           echo '<option value="'.$result[$k]["id"].'">'.$result[$k]["setup_date"].'   '.$result[$k]["amount"].'  </option>';

            }
        }
    }
}
?>