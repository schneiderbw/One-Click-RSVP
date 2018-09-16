<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
  $email = $_GET["email"];

?>

<html>
  <head>
    <title><?php echo $companyname; ?> | <?php echo $eventname; ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/application.css"></link>
  </head>
  <body>
    <div class="header">
      <img src="<?php echo $headerlogo; ?>">
      <h1>Opportunity Matching Schedule</h1>
    <?php if($suppliertype == "tier1"): ?>
      <h2>Tier 1 Suppliers</h2>
    <?php elseif($suppliertype == "diverse"): ?>
      <h2>Diverse Suppliers</h2>
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
      <table class="table table-bordered table-striped" id="schedule_table">
        <tr>
          <th>Time</th>
          <th>Company</th>
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
      <table class="table table-bordered table-striped" id="schedule_table">
        <tr>
          <th>Time</th>
          <th>Company</th>
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
  <?php if($suppliertype == "tier1"): ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $.getJSON("schedule-query.php?type=<?php echo $suppliertype; ?>&email=<?php echo $email; ?>", function(data){
        var meeting_data = '';
        $.each(data, function(key, value){
          meeting_data += '<tr>';
          meeting_data += '<td>'+value.meetingtime+'</td>';
          meeting_data += '<td>'+value.diverse_company+'</td>';
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
          meeting_data += '<td>'+value.meetingtime+'</td>';
          meeting_data += '<td>'+value.tier1_company+'</td>';
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
