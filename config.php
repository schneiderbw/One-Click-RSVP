<?php

//Registration Closed/Open
$diversereg_closed = "TRUE";
$tier1reg_closed = "FALSE";

// MySQL Connection Information
$sql_servername = "localhost";
$sql_dbname = "hondarsvp2018";
$sql_username = "hondarsvp2018";
$sql_password = "l8ovo>11Zb?p'c_pXO1RCGbo|]jP5njp8)N<XB-\TU+U9ZOL";

// *****DON'T MODIFY UNDER THIS LINE*****

//Make SQL Connection
include_once 'mysql.php';

// Fetch config table as array for configuration variables
$config_query = "SELECT configname, configproperty FROM config;";
$config = mysqli_fetch_assoc(mysqli_query($sql_conn,$config_query));

// Mailtrain API information (backwards compatibility)
$mailtrain_url = $config['mt_url']; // Full addres of the Mailtrain API including trailing slash
$mailtrain_accesstoken = $config['mt_apikey']; //API Access Token

//Application Information
$companyname = $config['companyname'];
$eventname = $config['eventname'];
$eventdatestring = $config['eventdatestring'];
$eventlocation = $config['eventlocation'];
$headerlogo = $config['headerlogo'];

 ?>
