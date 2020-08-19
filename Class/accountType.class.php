<?php 
require_once ("Class/DB.class.php");

class AccountType
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DB();
    }
    
    function addAccountType($setup_date,$no,$name,$des) {

        $query = "INSERT INTO account_type(setup_date,no,name,des) VALUES (?, ?, ?, ?)";
        $paramType = "siss";
        $paramValue = array(
            $setup_date,
            $no,
            $name,
            $des
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);

        return $insertId;
    }
    
    function editAccountType($name,$des,$org_id) {
        $query = "UPDATE account_type SET name = ?,des = ? WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array(
            $name,
            $des,
            $org_id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function deleteAccountType($org_id) {
        $query = "DELETE FROM account_type WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $org_id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getAccountTypeById($acc_Type_id) {
        $query = "SELECT * FROM account_type WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $acc_Type_id
        );
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getSpecificAccountType($acc_Type_id,$con) {

        $sql = "SELECT * FROM account_type WHERE  id='$acc_Type_id'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data=$row["name"];
               echo $data;
            }
        } 
    }
    
    function getAllAccountTypes() {
        $sql = "SELECT * FROM account_type ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getAllAccountTypesForSelcetion() {
        $sql = "SELECT * FROM account_type ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);

          if (! empty($result)) {
            foreach ($result as $k => $v) {

           echo '<option value="'.$result[$k]["id"].'">'.$result[$k]["name"].'</option>';

            }
        }
    }
}
?>