<?php


function tiekeju_sarasas()
  {
    include("../prekes_db_connect.php");

    $q = "select * from tiekejai";
    $query = mysqli_query($con,$q);
    
    $rows = array();
    while($row = mysqli_fetch_array($query)){
        array_push($rows, $row);
    }

    return $rows;
  }

  if(isset($_POST["prideti_tiekeja"])) 
    {
        include("../prekes_db_connect.php");

        $pavadinimas=$_POST['pavadinimas'];
        $adresas=$_POST['adresas'];
        $miestas=$_POST['miestas'];
        $epastas=$_POST['epastas'];

        $q="insert into tiekejai(pavadinimas, adresas,miestas,epastas)
        values('$pavadinimas','$adresas', '$miestas','$epastas')";

        mysqli_query($con,$q);
        header("location:tiekejai.php");
    }

    if(isset($_POST['redaguoti_tiekeja']))
    {
        include("../prekes_db_connect.php");

        $pavadinimas=$_POST['pavadinimas'];
		$adresas=$_POST['adresas'];
		$miestas=$_POST['miestas'];
		$epastas=$_POST['epastas'];
        $id = $_GET['id'];
        $q= "update tiekejai set pavadinimas='$pavadinimas', adresas='$adresas', 
        miestas='$miestas', epastas='$epastas' where id=$id";
        $query=mysqli_query($con,$q);
        header('location:tiekejai.php');
    } 

    function grazinti_tiekeja($id)
    {
        include("../prekes_db_connect.php");

        $q = "SELECT * FROM tiekejai WHERE Id='".$id."'";
        $query=mysqli_query($con,$q);
        $res= mysqli_fetch_array($query);
        return $res;
    }

    if(isset($_POST['salinti_tiekeja']))
    {
        include("../prekes_db_connect.php");

        $id = $_GET['id'];
        $q = "delete from tiekejai where Id = $id ";
        mysqli_query($con,$q);    
        header('location:tiekejai.php');
    }




?>