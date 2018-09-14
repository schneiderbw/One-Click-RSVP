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
  <body>
    <?php if ($suppliertype == "tier1"): ?>
      <?php $companyname = mysqli_query($sql_conn, "SELECT company FROM tier1_invitations WHERE email = $regemail"); ?>
      <div class="header">
        <img src="<?php echo $headerlogo; ?>">
        <h1>Attendee Registration</h1>
        <h2>Tier 1 Suppliers</h2>
      </div>

      <h3>
        Attendees
        <small class="text-muted">Please let us know who will be in attendance. Minimum 1, Maximum 2.</small>
      </h3>
      <form>
        <div class="form-group">
          <h4>Attendee 1<small class="text-muted">Required</small></h4>
          <div class="form-row">
            <div class="col">
              <input type="text" class="form-control" placeholder="First Name" name="attendee1_fname">
            </div>
            <div class="col">
              <input type="text" class="form-control" placehoder="Last Name" name="attendee1_lname">
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <input type="text" class="form-control" placeholder="Title" name="attendee1_title">
            </div>
            <div class="form-row">
              <input type="text" class="form-control" placeholder="E-Mail Address" name="attendee1_email">
            </div>
          </div>
          <h4>Attendee 2</h4>
          <div class="form-row">
            <div class="col">
              <input type="text" class="form-control" placeholder="First Name" name="attendee2_fname">
            </div>
            <div class="col">
              <input type="text" class="form-control" placehoder="Last Name" name="attendee2_lname">
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <input type="text" class="form-control" placeholder="Title" name="attendee2_title">
            </div>
            <div class="form-row">
              <input type="text" class="form-control" placeholder="E-Mail Address" name="attendee2_email">
            </div>
            <input type="hidden" name="company" value="<?php echo $companyname; ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </body>
</html>
