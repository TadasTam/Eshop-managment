<?php
    include("prekes_db_connect.php");
    $id = $_GET['id'];
	echo $id;
    $q = "delete from prekes where Id = $id ";
	$qq = "delete from inventorius where id = $id";
	try
	{
		    mysqli_query($con,$qq); 
    mysqli_query($con,$q);    
	}
	catch (Exception $e)
	{					session_start();
		$_SESSION["error"] = "!";
	}

	header('location:operacija1.php');
?>