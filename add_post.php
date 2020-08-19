<?php

include ('DB.php');
require_once ("Class/DB.class.php");
require_once ("Class/Organisation.class.php");

if($_POST["id"] != ''){

	$name =$_POST['name'];
	$desc=$_POST['desc'];
	$org_id =$_POST['id'];

	$organisation = new Organisation();
	$insertId = $organisation->editOrganisation($name,$desc,$org_id);	


}else{

	$name =$_POST['name'];
	$desc=$_POST['desc'];

	$time=time();
	$date2=date("Y-m-d",$time);

	$no=uniqid();

	$organisation = new Organisation();
	$insertId = $organisation->addOrganisation($date2,$no,$name,$desc);

}
?>		
