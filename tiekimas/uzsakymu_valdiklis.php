<?php

function uzsakymu_sarasas()
{
    include("../prekes_db_connect.php");
  
    $q= "select uzsakymas.*, tiekejai.pavadinimas, statusai.statusas, users.username from uzsakymas
    LEFT JOIN tiekejai ON uzsakymas.fk_tiekejas = tiekejai.id
    LEFT JOIN statusai ON uzsakymas.fk_statusas = statusai.id
    LEFT JOIN users ON uzsakymas.fk_darbuotojas_id = users.userid";
    $query=mysqli_query($con,$q);

    $rows = array();
    while($row = mysqli_fetch_array($query)){
        array_push($rows, $row);
    }

    return $rows;
}

function uzsakymo_prekes($id)
{
    include("../prekes_db_connect.php");
  
    $q= "select * from uzsakymo_preke LEFT JOIN prekes ON prekes.id=uzsakymo_preke.fk_preke WHERE uzsakymo_preke.fk_uzsakymas = $id";
    $query=mysqli_query($con,$q);

    $rows = array();
    while($row = mysqli_fetch_array($query)){
        array_push($rows, $row);
    }

    return $rows;
}

function prekiu_sarasas()
{
    include("../prekes_db_connect.php");
  
    $q= "select * from prekes";
    $query=mysqli_query($con,$q);

    $rows = array();
    while($row = mysqli_fetch_array($query)){
        array_push($rows, $row);
    }

    return $rows;
}

if(isset($_POST['salinti_uzsakyma']))
    {
        include("../prekes_db_connect.php");

        $id = $_GET['id'];
        $q = "delete from uzsakymas where Id = $id ";
        mysqli_query($con,$q);    
        header('location:uzsakymai.php');
    }

if(isset($_POST['pakeisti_busena']))
    {
        include("../prekes_db_connect.php");
	
        $id = $_GET['id'];
        $statusas = 3;
        
        $q1 = "select fk_statusas from uzsakymas where id=$id";
        $query=mysqli_query($con,$q1);
        $qq1=mysqli_fetch_array($query);
        if ($qq1['fk_statusas']==3) { $statusas = 1; }
        
        $q2 = "update uzsakymas set fk_statusas='$statusas' where id=$id";
        mysqli_query($con,$q2);    
        header('location:uzsakymai.php');
    }

function grazinti_uzsakyma($id)
    {
        include("../prekes_db_connect.php");

        $q = "SELECT * FROM uzsakymas WHERE Id='".$id."'";
        $query=mysqli_query($con,$q);
        $res= mysqli_fetch_array($query);
        return $res;
    }

if(isset($_POST['redaguoti_uzsakyma']))
    {
        session_start();
        include("../prekes_db_connect.php");

        $sudaryta=$_POST['sudaryta'];
		$pristatyta=$_POST['pristatyta'];
		$suma=0;
		$pristatymo_kaina=$_POST['kaina'];
		$fk_darbuotojas_id=$_SESSION['userid'];
		$fk_statusas='1';
        $id = $_GET['id'];
        $q= "update uzsakymas set sudaryta='$sudaryta', pristatyta='$pristatyta', suma='$suma', pristatymo_kaina='$pristatymo_kaina', fk_darbuotojas_id='$fk_darbuotojas_id'
		where id=$id";
        $query=mysqli_query($con,$q);
        header('location:uzsakymai.php');
    } 

if(isset($_POST["prideti_uzsakyma"])) 
    {
        if(isset($_POST['prideti_preke']))
        {
            $id = $_POST['id'];
            $kiekis = $_POST['kiekis'];
            $kaina = $_POST['kaina'];
            $pkaina = $_POST['pkaina'];
    
            $prekes = $_SESSION['prekes'];
            $kiekiai = $_SESSION['prekesK'];
            $kainos = $_SESSION['prekesKA'];
    
            if ($kiekis != ""){
                $new = true;
                $length = count($prekes);
                for ($i = 0; $i < $length; $i++) {
                    if($prekes[$i]==$id)
                    {
                        $kainos[$i] = ($kiekiai[$i]*$kainos[$i] + $kiekis*$kaina)/($kiekis+$kiekiai[$i]);
                        $kiekiai[$i] = $kiekiai[$i] + $kiekis;
                        $new = false;
                        break;
                    }
                }
    
                if ($new == true)
                {
                    array_push($prekes, $id);
                    array_push($kiekiai, $kiekis);
                    array_push($kainos, $kaina);
                }
                
            }
    
            $suma = (float)$pkaina;
            $length = count($prekes);
            for ($i = 0; $i < $length; $i++) {
                $suma = $suma + $kiekiai[$i]*$kainos[$i];
            }
            
            $_SESSION['prekes']=$prekes;
            $_SESSION['prekesK']=$kiekiai;
            $_SESSION['prekesKA']=$kainos;
            
            $_SESSION['sudarymas']=$_POST['sudaryta'];
            $_SESSION['pristatymas']=$_POST['pristatyta'];
            $_SESSION['pkaina']=$_POST['pkaina'];
            $_SESSION['tiekejas']=$_POST['tiekejas'];
        }

        
        session_start();
        if (count($_SESSION['prekes']) == 0)
        {
            // klaidos pranesimas
            echo "<script type='text/javascript'>alert('Klaida: neužsakyta jokių prekių');</script>";
            header("location:uzsakymai.php");
            exit;
        }

        include("../prekes_db_connect.php");

        $sudaryta=$_SESSION['sudarymas'];
        $pristatyta=$_SESSION['pristatymas'];
        // $suma=0;
        $pristatymo_kaina=$_SESSION['pkaina'];
        $fk_darbuotojas_id=$_SESSION['userid'];
        $fk_statusas='1';
        $fk_tiekejas=$_SESSION['tiekejas'];
        
        $prekes = $_SESSION['prekes'];
        $kiekiai = $_SESSION['prekesK'];
        $kainos = $_SESSION['prekesKA'];

        $suma = (float)$pristatymo_kaina;
        $length = count($prekes);
        for ($i = 0; $i < $length; $i++) {
            $suma = $suma + $kiekiai[$i]*$kainos[$i];
        }

        $q="insert into uzsakymas(sudaryta,
        pristatyta,suma,pristatymo_kaina, fk_darbuotojas_id, fk_statusas, fk_tiekejas)
        values('$sudaryta','$pristatyta','$suma','$pristatymo_kaina','$fk_darbuotojas_id','$fk_statusas','$fk_tiekejas')";

        mysqli_query($con,$q);
        $gid = mysqli_insert_id($con);

        
        $length = count($prekes);
            for ($i = 0; $i < $length; $i++) {
                $kiekis = $kiekiai[$i];
                $kaina = $kainos[$i];
                $id = $prekes[$i];

                $q="insert into uzsakymo_preke(kiekis, vieneto_kaina, fk_uzsakymas, fk_preke)
                values('$kiekis', '$kaina', '$gid', '$id');";
                mysqli_query($con,$q);
            }

        header("location:uzsakymai.php");


        // session_start();
        // include("../prekes_db_connect.php");
        // $sudaryta=$_POST['sudaryta'];
        // $pristatyta=$_POST['pristatyta'];
        // $suma=0;
        // $pristatymo_kaina=$_POST['kaina'];
        // $fk_darbuotojas_id=$_SESSION['userid'];
        // $fk_statusas='1';
        // $fk_tiekejas=$_POST['tiekejas'];

        // $q="insert into uzsakymas(sudaryta,
        // pristatyta,suma,pristatymo_kaina, fk_darbuotojas_id, fk_statusas, fk_tiekejas)
        // values('$sudaryta','$pristatyta','$suma','$pristatymo_kaina','$fk_darbuotojas_id','$fk_statusas','$fk_tiekejas')";

        // mysqli_query($con,$q);
        // header("location:uzsakymai.php");
    }

    function pavadinimas($id)
    {
        include("../prekes_db_connect.php");

        $q= "select pavadinimas from prekes where id=$id;";
        $query=mysqli_query($con,$q);
        return mysqli_fetch_array($query)['pavadinimas'];
    }

    function tiekejas($id)
    {
        include("../prekes_db_connect.php");

        $q= "select pavadinimas from tiekejai where id=$id;";
        $query=mysqli_query($con,$q);
        return mysqli_fetch_array($query)['pavadinimas'];
    }

?>