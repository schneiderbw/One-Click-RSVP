<?php
  include 'config.php';
  include 'mysql.php';
  require_once('./lib/tcpdf/tcpdf.php');

  $suppliertype = $_GET["type"];
  $email = $_GET["email"];

  if($suppliertype == "tier1"){
    $tier1_query = "SELECT * FROM tier1_rsvp;";
    $exec_tier1_query = mysqli_query($sql_conn,$tier1_query);
    $array_tier1 = array();
    while($row = mysqli_fetch_row($exec_tier1_query)){
	$array_tier1[] = $row;
    } 
    $schedules = array();
    foreach($array_tier1 as $tier1_reg){
      $query = "SELECT * FROM v_scheduledata_testing WHERE tier1_regemail = '$tier1_reg' ORDER BY meetingtime ASC;";
      $preschedules = mysqli_fetch_row(mysqli_query($sql_conn,$query));
      while($row = $preschedules){
	$schedules[$tier1_reg][] = $row;
      }
    }
  } elseif ($suppliertype == "diverse"){
    $diverse_query = "SELECT diverse_regemail FROM diverse_rsvp;";
    $exec_diverse_query = mysqli_query($sql_conn,$diverse_query);
    $array_diverse = mysqli_fetch_assoc($exec_diverse_query);

  }
print "<pre>";
print_r($schedules);
print "</pre>";

?>
