<?php
$baglanti=mysqli_connect("localhost","root","","karardesteksistemleri");

if($baglanti){
    $sorgu=mysqli_query($baglanti,"SELECT SUM(basariliGorevSayi) FROM gorev_ay");
    $sonuc=mysqli_fetch_array($sorgu);
	echo $sonuc[0];
	mysqli_close($baglanti);
}else{
	die("Bağlantı sorunu.");
};