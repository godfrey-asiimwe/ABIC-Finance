<?php 
require_once ("Class/DB.class.php");

class Organisation
{
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DB();
    }
    
    function addOrganisation($setup_date,$no,$name,$des) {

        $query = "INSERT INTO organisation(setup_date,no,name,des) VALUES (?, ?, ?, ?)";
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
    
    function editOrganisation($name,$des,$org_id) {
        $query = "UPDATE organisation SET name = ?,des = ? WHERE id = ?";
        $paramType = "ssi";
        $paramValue = array(
            $name,
            $des,
            $org_id
        );
        
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function deleteOrganisation($org_id) {
        $query = "DELETE FROM organisation WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $org_id
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }
    
    function getOrganisationById($org_id) {
        $query = "SELECT * FROM organisation WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $org_id
        );
        
        $result = $this->db_handle->runBaseQuery($query);
        return $result;
    }

    function getSpecificOrganisation($org_id,$con) {

        $sql = "SELECT * FROM organisation WHERE  id='$org_id'";

        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $data=$row["name"];
               echo $data;
            }
        } 
    }
    
    function getAllOrganisation() {
        $sql = "SELECT * FROM organisation ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }

    function getAllOrganisationForSelcetion() {
        $sql = "SELECT * FROM organisation ORDER BY id";
        $result = $this->db_handle->runBaseQuery($sql);

          if (! empty($result)) {
            foreach ($result as $k => $v) {

           echo '<option value="'.$result[$k]["id"].'">'.$result[$k]["name"].'</option>';

            }
        }
    }
    
}
?>