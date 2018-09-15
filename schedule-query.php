<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
  $useremail = urldecode($_GET["email"]);

  if ($suppliertype == "tier1") {
    //Query table 'tier1_rsvp' for the $useremail variable and return with the tier1_regemail for us to query against the schedule
    $query_findregemail = "SELECT tier1_regemail FROM tier1_rsvp WHERE '$useremail' IN(attendee1_email,attendee2_email,tier1_regemail)";
    $findregemail = mysqli_query($sql_conn,$query_findregemail);
    $result_findregemail = mysqli_fetch_array($findregemail,MYSQLI_ASSOC);
    $regemail = $result_findregemail["tier1_regemail"];

    $query = "SELECT * FROM schedule WHERE tier1_email = '$regemail' ORDER BY meetingtime ASC;";
    $exec_query = mysqli_query($sql_conn,$query);
    $rows = array();
    while($r = mysqli_fetch_assoc($exec_query)){
      $rows[] = $r;
    }
    print json_encode($rows);
  } elseif ($suppliertype == "diverse") {
    //Query table 'tier1_rsvp' for the $useremail variable and return with the tier1_regemail for us to query against the schedule
    $query_findregemail = "SELECT diverse_regemail FROM diverse_rsvp WHERE '$useremail' IN(attendee1_email,diverse_regemail)";
    $findregemail = mysqli_query($sql_conn,$query_findregemail);
    $result_findregemail = mysqli_fetch_array($findregemail,MYSQLI_ASSOC);
    $regemail = $result_findregemail["diverse_regemail"];

    $query = "SELECT * FROM schedule WHERE diverse_email = '$regemail' ORDER BY meetingtime ASC;";
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
