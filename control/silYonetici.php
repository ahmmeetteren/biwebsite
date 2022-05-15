<?php 

if ($_GET) 
{

$baglanti=mysqli_connect("localhost","root","","karardesteksistemleri");

    if(mysqli_connect_error())
    {
        echo mysqli_connect_error();
        exit;
    }


if ($baglanti) 
{
	$sorgu=mysqli_query($baglanti,"DELETE FROM yoneticiler WHERE yon_id =".(int)$_GET['id']);
	if($sorgu){
		header("location:../index.php");
	}
}
}
