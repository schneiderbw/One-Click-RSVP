<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
  $regemail = $_GET["email"];

  if ($suppliertype == "tier1") {
    $query = "SELECT * FROM schedule WHERE tier1_email = $regemail";
    $exec_query = mysqli_query($sql_conn,$query);
    $rows = array();
    while($r = mysqli_fetch_assoc($exec_query)){
      $rows[] = $r;
    }
    print json_encode($rows);
  } elseif {
    $query = "SELECT * FROM schedule WHERE diverse_email = $regemail";
    $exec_query = mysqli_query($sql_conn,$query);
    $rows = array();
    while($r = mysqli_fetch_assoc($exec_query)){
      $rows[] = $r;
    }
    print json_encode($rows);
  } else {
    throw new Exception('No supplier type was supplied in the query.  Unable to fetch schedule');
  }

?>
