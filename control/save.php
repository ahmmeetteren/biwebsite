<?php
    $request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
    $per_id = $request['per_id']; //get the date of birth from collected data above
    $dep_id = $request['dep_id']; //get the date of birth from collected data above
    $per_ad = $request['per_ad'];
    $per_soyad = $request['per_soyad'];
    $basarili_gorev = $request['basarili_gorev'];
    $basarisiz_gorev = $request['basarisiz_gorev'];
    $per_maas = $request['per_maas'];
    $calisilanGun = $request['calisilanGun'];

    $servername = "localhost"; //set the servername
    $username = "root"; //set the server username
    $password = ""; // set the server password (you must put password here if your using live server)
    $dbname = "karardesteksistemleri"; // set the table name

    $mysqli = new mysqli($servername, $username, $password, $dbname);
    $mysqli->set_charset("utf8");
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
      exit();
    }

    // Set the INSERT SQL data
    $sql = "INSERT INTO personel (per_id, dep_id, per_ad, per_soyad, basarili_gorev, basarisiz_gorev, per_maas, calisilanGun)
    VALUES ('".$per_id."', '".$dep_id."', '".$per_ad."', '".$per_soyad."', '".$basarili_gorev."', '".$basarisiz_gorev."', '".$per_maas."', '".$calisilanGun."')";

    // Process the query so that we will save the date of birth
    if ($mysqli->query($sql)) {
        header("location:../islemler.php");
    } else {
      return "Error: " . $sql . "<br>" . $mysqli->error;
    }

    // Close the connection after using it
    $mysqli->close();
