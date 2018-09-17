<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
  $email = $_GET["email"];

  //Get the Company Name from the RSVP registration so we can use it later.
  if($suppliertype == "tier1"){
    $email_decoded = urldecode($email);
    $query = "SELECT companyname FROM tier1_rsvp WHERE (tier1_regemail = '$email_decoded' OR attendee1_email = '$email_decoded' OR attendee2_email = '$email_decoded');";
    $result = mysqli_fetch_array(mysqli_query($sql_conn, $query),MYSQLI_ASSOC);
    $usercompany = $result["companyname"];
  }
  if($suppliertype == "diverse"){
    $email_decoded = urldecode($email);
    $query = "SELECT companyname FROM diverse_rsvp WHERE (diverse_regemail = '$email_decoded' OR attendee1_email = '$email_decoded');";
    $result = mysqli_fetch_array(mysqli_query($sql_conn, $query),MYSQLI_ASSOC);
    $usercompany = $result["companyname"];
  }

?>

<html>
  <head>
    <title><?php echo $companyname; ?> | <?php echo $eventname; ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-9ralMzdK1QYsk4yBY680hmsb4/hJ98xK3w0TIaJ3ll4POWpWUYaA2bRjGGujGT8w" crossorigin="anonymous">
    <link rel="stylesheet" href="css/application.css"></link>
  </head>
  <body>
    <div class="header">
      <img src="<?php echo $headerlogo; ?>">
      <h1>Opportunity Matching Schedule</h1>
    <?php if($suppliertype == "tier1"): ?>
      <h2>Tier 1 Suppliers</h2>
    </div>
    <?php elseif($suppliertype == "diverse"): ?>
      <h2>Diverse Suppliers</h2>
    </div>
    <?php else: ?>
      <h2>Please select the type of vendor you are.</h2>
    </div>
    <div class="container">
      <div class="row">
        <div class="col">
          <a href="./schedule.php?type=tier1" type="button" class="btn btn-primary btn-lg btn-block">Tier 1 Suppliers</a>
        </div>
        <div class="col">
          <a href="./schedule.php?type=diverse" type=button class="btn btn-primary btn-lg btn-block">Diverse Suppliers</a>
        </div>
      </div>
    </div>
    <?php exit; ?>
    <?php endif; ?>
    <?php if($suppliertype == "tier1"): ?>
      <?php if(empty($email)): ?>
    <div class="container">
      <form action="schedule.php?type=tier1" method="get" class="needs-validation" novalidate>
        <h4>Please enter your e-mail address</h3>
        <div class="form-group">
          <div class="form-row justify-content-center">
            <input type="email" class="form-control" placeholder="E-Mail Address" id="email" name="email" required>
            <input type="hidden" name="type" value="<?php echo $suppliertype?>">
            <div class="invalid-feedback">
              A valid e-mail address is required to proceed.
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
    </div>
      <?php elseif($email): ?>
    <div class="container">
      <div class="header">
        <h3>Welcome <?php echo $usercompany; ?></h3>
      </div>
      <div class="header" id="loadscreen">
        <h3><i class="fas fa-spinner-third spin"></i> Please wait while we gather your schedule...</h3>
      </div>
      <table class="table table-bordered table-striped hidden" id="schedule_table">
        <tr>
          <th>Time</th>
          <th>Company</th>
          <th>Website</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>E-Mail</th>
          <th>Opportunity Type</th>
        </tr>
      </table>
    </div>
      <?php endif; ?>
    <?php elseif($suppliertype == "diverse"): ?>
      <?php if(empty($email)): ?>
        <div class="container">
          <form action="schedule.php?type=tier1" method="get" class="needs-validation" novalidate>
            <h4>Please enter your e-mail address</h3>
            <div class="form-group">
              <div class="form-row justify-content-center">
                <input type="email" class="form-control" placeholder="E-Mail Address" id="email" name="email" required>
                <input type="hidden" name="type" value="<?php echo $suppliertype?>">
                <div class="invalid-feedback">
                  A valid e-mail address is required to proceed.
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      <?php elseif($email): ?>
    <div class="container">
      <div class="header">
        <h3>Welcome <?php echo $usercompany; ?></h3>
      </div>
      <div class="header" id="loadscreen">
          <h3><i class="fas fa-spinner-third spin"></i> Please wait while we gather your schedule...</h3>
      </div>
      <table class="table table-bordered table-striped hidden" id="schedule_table">
        <tr>
          <th>Time</th>
          <th>Company</th>
          <th>Website</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>E-Mail</th>
          <th>Opportunity Type</th>
        </tr>
      </table>
    </div>
      <?php endif; ?>
    <?php endif; ?>
    </div>
  </body>
  <script type="text/javascript">
    function tConvert (intime) {
      //Remove the last three characters from the string
      newtime = intime.slice(0,-3);

      // Check correct time format and split into components
      time = newtime.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

      if (time.length > 1) { // If time format correct
        time = time.slice (1);  // Remove full string match value
        time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
        time[0] = +time[0] % 12 || 12; // Adjust hours
      }
      return time.join (''); // return adjusted time or original string
    }
    $(document).ready(function(){
      $("div#loadscreen").addClass("hidden");
      $("table#schedule_table").removeClass("hidden");
    });
  </script>
  <?php if($suppliertype == "tier1"): ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $.getJSON("schedule-query.php?type=<?php echo $suppliertype; ?>&email=<?php echo $email; ?>", function(data){
        var meeting_data = '';
        $.each(data, function(key, value){
          meeting_data += '<tr>';
          meeting_data += '<td>'+tConvert(value.meetingtime)+'</td>';
          meeting_data += '<td>'+value.diverse_company+'</td>';
          meeting_data += '<td><a href="'+value.diverse_website+'" target="_blank">'+value.diverse_website+'</a></td>';
          meeting_data += '<td>'+value.diverse_fname+'</td>';
          meeting_data += '<td>'+value.diverse_lname+'</td>';
          meeting_data += '<td>'+value.diverse_email+'</td>';
          meeting_data += '<td>'+value.capability+'</td>';
        });
        $('#schedule_table').append(meeting_data);
      });
    });
  </script>
  <?php elseif($suppliertype == "diverse"): ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $.getJSON("schedule-query.php?type=<?php echo $suppliertype; ?>&email=<?php echo $email; ?>", function(data){
        var meeting_data = '';
        $.each(data, function(key, value){
          meeting_data += '<tr>';
          meeting_data += '<td>'+tConvert(value.meetingtime)+'</td>';
          meeting_data += '<td>'+value.tier1_company+'</td>';
          meeting_data += '<td><a href="'+value.tier1_website+'" target="_blank">'+value.tier1_website+'</a></td>';
          meeting_data += '<td>'+value.tier1_fname+'</td>';
          meeting_data += '<td>'+value.tier1_lname+'</td>';
          meeting_data += '<td>'+value.tier1_email+'</td>';
          meeting_data += '<td>'+value.capability+'</td>';
        });
        $('#schedule_table').append(meeting_data);
      });
    });
  </script>
  <?php endif; ?>
</html>
