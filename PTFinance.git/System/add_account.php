<?php
require_once ("Class/DB.class.php");
require_once ("Class/Organisation.class.php");
require_once ("Class/accountType.class.php");
require_once ("Class/Account.class.php");
require_once ("DB.php");

if (isset($_POST['name'])) {

      $name =$_POST['name'];
      $acc_type=$_POST['accountType'];
      $org=$_POST['organisation'];
      $status="active";


      $time=time();
      $setup_date=date("Y-m-d",$time); 

      $account_no=uniqid();
      
      $account = new Account();
      $insertId = $account->addAccount($setup_date,$acc_type,$org,$account_no,$name,$status);

  }
 ?>