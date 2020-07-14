<?php 
require_once ("Class/DB.class.php");

class Account
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DB();
    }
    
    function addAccount($setup_date,$acc_type,$org,$account_no,$name,$status) {

        $query = "INSERT INTO account(setup_date,account_type,organisation,account_number,name,status) VALUES (?, ?, ?, ?,?,?)";

        $paramType = "siiiss";
        $paramValue = array(
            $setup_date,
            $acc_type,
            $org,
            $account_no,
            $name,
            $status
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);

        return $insertId;
    }
    
    function editAccount($name,$des,$org_id) {
        $query = "UPDATE account SET name = ?,des = ? WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array(
            $name,
            $des,
            $org_id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }

    function editAccountAmount($amount,$acc_id) {
        $query = "UPDATE account SET amount = ? WHERE id = ?";
        $paramType = "si";
        $paramValue = array(
            $amount,
            $acc_id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function deleteAccount($acc_id) {
        $query = "DELETE FROM account WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $org_id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getAccountById($acc_id) {
        $query = "SELECT * FROM account WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $org_id
        );
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getSpecificAccount($acc_id,$con) {

        $sql = "SELECT * FROM account WHERE  id='$acc_id'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data=$row["name"];
               echo $data;
            }
        } 
    }
    
    function getAllAccounts() {
        $sql = "SELECT * FROM account ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getAllAccountForSelection() {
        $sql = "SELECT * FROM account ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);

          if (! empty($result)) {
            foreach ($result as $k => $v) {

           echo '<option value="'.$result[$k]["id"].'">'.$result[$k]["name"].'</option>';

            }
        }
    }

    function getAmountOnAccount($acc_id) {
        $query = "SELECT amount FROM account WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $acc_id
        );
        
        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);

          if (! empty($result)) {
            foreach ($result as $k => $v) {

           return $result[$k]["amount"];

            }
        }
    }
}
?>