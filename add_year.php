<?php

include ('DB.php');
require_once ("Class/DB.class.php");
require_once ("Class/FinancialYear.class.php");

if ($_POST["id"] != '') {

  $name =$_POST['name'];
  $desc=$_POST['desc'];
  $id=$_POST['id'];

  $financialYear = new FinancialYear();
  $insertId = $financialYear->editfinancialYear($name,$desc,$id);


}else{

  $name =$_POST['name'];
  $desc=$_POST['desc'];

  $time=time();
  $date2=date("Y-m-d",$time); 
  
  $financialYear = new FinancialYear();
  $insertId = $financialYear->addFinancialYear($date2,$name,$desc);

}
?>