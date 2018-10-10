<?php
  include 'config.php';
  include 'mysql.php';
  require_once('./lib/tcpdf/tcpdf.php');

  $suppliertype = $_GET["type"];
  $email = $_GET["email"];

  if($suppliertype == "tier1"){
    $tier1_query = "SELECT tier1_regemail FROM tier1_rsvp;";
    $exec_tier1_query = mysqli_query($sql_conn,$tier1_query);
    $array_tier1 = mysqli_fetch_assoc($exec_tier1_query);
    $schedules = array();
    foreach($array_tier1 as $tier1_reg){
      $query = "SELECT * FROM v_scheduledata_testing WHERE tier1_regemail = '$tier1_reg' ORDER BY meetingtime ASC;";
      $schedules[$tier1_reg] = mysqli_fetch_assoc(mysqli_query($sql_conn,$query));
    }
  } elseif ($suppliertype == "diverse"){
    $diverse_query = "SELECT diverse_regemail FROM diverse_rsvp;";
    $exec_diverse_query = mysqli_query($sql_conn,$diverse_query);
    $array_diverse = mysqli_fetch_assoc($exec_diverse_query);

  }



?>
