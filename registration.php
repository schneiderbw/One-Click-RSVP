<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
  $regemail = $_GET["email"];
?>

<html>
  <head>
    <title><?php echo $companyname; ?> | <?php echo $eventname; ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/application.css"
  </head>
  <?php
    //Handle form submissions here
    if ($_GET["submit"] == "true") {
      if ($_GET["type"] == "tier1") {
        dbRowInsert("tier1_rsvp",$_POST);
      }
      if ($_GET["type"] == "diverse") {
        dbRowInsert("diverse_rsvp",$_POST);
      }
    }
  ?>
  <body>
    <?php if ($suppliertype == "tier1"): ?>
      <?php $companyname = mysqli_query($sql_conn, "SELECT company FROM tier1_invitations WHERE email = $regemail"); ?>
      <div class="header">
        <img src="<?php echo $headerlogo; ?>">
        <h1>Attendee Registration</h1>
        <h2>Tier 1 Suppliers</h2>
      </div>

      <div class="container">
        <h3>
          Attendees
          <small class="text-muted">Please let us know who will be in attendance. Minimum 1, Maximum 2.</small>
        </h3>
        <p>To access your schedule for this event, please submit your attendees first.</p>
        <form action="registration.php?submit=true&type=tier1" method="post">
          <div class="form-group">
            <h4>
              Attendee 1
              <small class="text-muted">Required</small>
            </h4>
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="First Name" name="attendee1_fname">
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Last Name" name="attendee1_lname">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Title" name="attendee1_title">
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="E-Mail Address" name="attendee1_email">
              </div>
            </div>
            <h4>Attendee 2</h4>
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="First Name" name="attendee2_fname">
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Last Name" name="attendee2_lname">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Title" name="attendee2_title">
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="E-Mail Address" name="attendee2_email">
              </div>
            </div>
            <input type="hidden" name="companyname" value="<?php echo $companyname; ?>">
            <input type="hidden" name="tier1_regemail" value="<?php echo $regemail; ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    <?php elseif ($suppliertype == "diverse"): ?>
      <div class="header">
        <img src="<?php echo $headerlogo; ?>">
        <h1>Attendee Registration</h1>
        <h2>Diverse Suppliers</h2>
      </div>

      <div class="container">
        <h3>
          Attendees
          <small class="text-muted">Please let us know who will be in attendance.</small>
        </h3>
        <p>To access your schedule for this event, please submit your attendee first.</p>
        <form action="registration.php?submit=true&type=tier1" method="post">
          <div class="form-group">
            <h4>
              Attendee
              <small class="text-muted">Required</small>
            </h4>
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="First Name" name="attendee1_fname">
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Last Name" name="attendee1_lname">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Title" name="attendee1_title">
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="E-Mail Address" name="attendee1_email">
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Company Name" name="companyname">
              </div>
            </div>
            <input type="hidden" name="diverse_regemail" value="<?php echo $regemail; ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </body>
</html>
