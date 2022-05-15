<?php
    $request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
    $yon_ad = $request['yon_ad']; //get the date of birth from collected data above
    $yon_soyad = $request['yon_soyad']; //get the date of birth from collected data above
    $dep_id = $request['dep_id'];
    $email = $request['email'];
    $sifre = $request['sifre'];
    $cepTelefonu = $request['cepTelefonu'];
    $sabitTelefon = $request['sabitTelefon'];
    $adres = $request['adres'];

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
    $sql = "INSERT INTO yoneticiler (yon_ad, yon_soyad, dep_id, email, sifre, cepTelefonu, sabitTelefon, adres)
    VALUES ('".$yon_ad."', '".$yon_soyad."', '".$dep_id."', '".$email."', '".$sifre."', '".$cepTelefonu."', '".$sabitTelefon."', '".$adres."')";

    // Process the query so that we will save the date of birth
    if ($mysqli->query($sql)) {
        header("location:../index.php");
    } else {
      return "Error: " . $sql . "<br>" . $mysqli->error;
    }

    // Close the connection after using it
    $mysqli->close();
