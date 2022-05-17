<?php
    $request = $_REQUEST; //a PHP Super Global variable which used to collect data after submitting it from the form
    $dep_id = $request['dep_id']; //get the date of birth from collected data above
    $hizmet_ad = $request['hizmet_ad'];
    $hizmet_gelir = $request['hizmet_gelir'];
    $hizmet_maliyet = $request['hizmet_maliyet'];

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
    $sql = "INSERT INTO hizmetler(dep_id, hizmet_ad, hizmet_gelir, hizmet_maliyet)
    VALUES ('".$dep_id."', '".$hizmet_ad."', '".$hizmet_gelir."', '".$hizmet_maliyet."')";

    // Process the query so that we will save the date of birth
    if ($mysqli->query($sql)) {
        header("location:../islemler.php");
    } else {
      return "Error: " . $sql . "<br>" . $mysqli->error;
    }

    // Close the connection after using it
    $mysqli->close();
