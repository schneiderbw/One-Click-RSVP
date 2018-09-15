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

if ($sql_conn->connect_error) {
  die("Connection failed: " . $sql_conn->connect_error);
}

if ($mysqli->ping()) {
    printf ("Our connection is ok!\n");
} else {
    printf ("Error: %s\n", $mysqli->error);
}

//mysql functions
function dbRowInsert($table_name, $form_data)
{
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);

    // build the query
    $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";

    // run and return the query result resource
    return mysqli_query($sql_conn, $sql);
}

 ?>
