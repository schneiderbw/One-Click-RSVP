<?php

require 'config.php';

//Redefine the variables we're getting from config.php
$servername = $sql_servername;
$username = $sql_username;
$password = $sql_password;
$dbname = $sql_dbname;

//Create MySQL Connection

$sql_conn = mysqli_connect($servername, $username, $password, $dbname);

//Check connection

if ($_GET["testing"] == "1") {
  if ($sql_conn->ping()) {
      printf ("Our connection is ok!\n");
  } else {
      printf ("Error: %s\n", $sql_conn->error);
  }
}

 ?>
