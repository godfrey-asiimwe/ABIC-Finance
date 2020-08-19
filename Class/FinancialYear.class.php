<?php 
require_once ("Class/DB.class.php");

class FinancialYear
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DB();
    }
    
    function addFinancialYear($setup_date,$name,$des) {

        $query = "INSERT INTO financialYear(setup_date,name,des) VALUES (?, ?, ?)";
        $paramType = "sss";
        $paramValue = array(
            $setup_date,
            $name,
            $des
        );
        
        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);

        return $insertId;
    }
    
    function editfinancialYear($name,$des,$id) {
        $query = "UPDATE financialYear SET name = ?,des = ? WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array(
            $name,
            $des,
            $id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function deletefinancialYear($id) {
        $query = "DELETE FROM financialYear WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getfinancialYearById($id) {
        $query = "SELECT * FROM financialYear WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $id
        );
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getSpecificfinancialYear($id,$con) {

        $sql = "SELECT * FROM financialYear WHERE  id='$id'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data=$row["name"];
               echo $data;
            }
        } 
    }
    
    function getAllfinancialYears() {
        $sql = "SELECT * FROM financialYear ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getActiveFinancialYear($con) {
        $sql = "SELECT * FROM financialYear WHERE  status='active'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data=$row["id"];
               return $data;
            }
        } 
    }

    function getAllfinancialYearsForSelection() {
        $sql = "SELECT * FROM financialYear ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);

          if (! empty($result)) {
            foreach ($result as $k => $v) {

           echo '<option value="'.$result[$k]["id"].'">'.$result[$k]["name"].'</option>';

            }
        }
    }
}
?>