<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
  $regemail = $_GET["email"];
?>

<?php
  //Handle form submissions here
  if ($_GET["submit"] == "true") {
    if ($_GET["type"] == "tier1") {
      $query = "INSERT INTO tier1_rsvp (attendee1_fname,attendee1_lname,attendee1_title,attendee1_email,attendee2_fname,attendee2_lname,attendee2_title,attendee2_email,companyname,tier1_regemail) VALUES ('".$_POST['attendee1_fname']."','".$_POST['attendee1_lname']."','".$_POST['attendee1_title']."','".$_POST['attendee1_email']."','".$_POST['attendee2_fname']."','".$_POST['attendee2_lname']."','".$_POST['attendee2_title']."','".$_POST['attendee2_email']."','".$_POST['companyname']."','".$_POST['tier1_regemail']."');";
      if(mysqli_query($sql_conn,$query)) {
        $sqlsuccessful = True;
      }
    }
    if ($_GET["type"] == "diverse") {
      $query = "INSERT INTO diverse_rsvp (attendee1_fname,attendee1_lname,attendee1_title,attendee1_email,companyname,tier1_regemail) VALUES ('".$_POST['attendee1_fname']."','".$_POST['attendee1_lname']."','".$_POST['attendee1_title']."','".$_POST['attendee1_email']."','".$_POST['companyname']."','".$_POST['tier1_regemail']."');";
      if(mysqli_query($sql_conn,$query)) {
        $sqlsuccessful = True;
      }
    }
  }
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

      <?php if($sqlsuccessful): ?>
      <h3 class="text-center">Thank you for your submission!  Please wait while we get you your schedule.</h3>
      <script>
        window.location.href = "./schedule.php?type=tier1&email=<?php echo $_POST['tier1_regemail']; ?>";
      </script>
      <?php exit; endif; ?>

      <div class="container">
        <h3>
          Attendees
          <small class="text-muted">Please let us know who will be in attendance. Minimum 1, Maximum 2.</small>
        </h3>
        <p>To access your schedule for this event, please submit your attendees first.</p>
        <form action="registration.php?submit=true&type=tier1" method="post" class="needs-validation" novalidate>
          <div class="form-group">
            <h4>
              Attendee 1
              <small class="text-muted">Required</small>
            </h4>
            <div class="form-row">
              <div class="col">
                <label for="attendee1_fname">First Name</label>
                <input type="text" class="form-control" placeholder="First Name" id="attendee1_fname"  name="attendee1_fname" required>
                <div class="invalid-feedback">
                  First Name is required.
                </div>
              </div>
              <div class="col">
                <label for="attendee1_lname">Last Name</label>
                <input type="text" class="form-control" placeholder="Last Name" id="attendee1_lname" name="attendee1_lname" required>
                <div class="invalid-feedback">
                  Last Name is required.
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="attendee1_title">Title</label>
                <input type="text" class="form-control" placeholder="Title" id="attendee1_title" name="attendee1_title" required>
                <div class="invalid-feedback">
                  Title is required.
                </div>
              </div>
              <div class="col">
                <label for="attendee1_email">E-Mail Address</label>
                <input type="email" class="form-control" placeholder="E-Mail Address" id="attendee1_email" name="attendee1_email" required>
                <div class="invalid-feedback">
                  E-Mail Address is required.
                </div>
              </div>
            </div>
            <h4>Attendee 2</h4>
            <div class="form-row">
              <div class="col">
                <label for="attendee2_fname">First Name</label>
                <input type="text" class="form-control" placeholder="First Name" id="attendee2_fname" name="attendee2_fname">
                <div class="invalid-feedback">
                  First Name is required.
                </div>
              </div>
              <div class="col">
                <label for="attendee2_lname">Last Name</label>
                <input type="text" class="form-control" placeholder="Last Name" id="attendee2_lname" name="attendee2_lname">
                <div class="invalid-feedback">
                  Last Name is required.
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="attendee2_title">Title</label>
                <input type="text" class="form-control" placeholder="Title" id="attendee2_title" name="attendee2_title">
                <div class="invalid-feedback">
                  Title is required.
                </div>
              </div>
              <div class="col">
                <label for="attendee2_email">E-Mail Address</label>
                <input type="email" class="form-control" placeholder="E-Mail Address" id="attendee2_email" name="attendee2_email">
                <div class="invalid-feedback">
                  E-Mail Address is required.
                </div>
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

      <?php if($sqlsuccessful): ?>
      <h3 class="text-center">Thank you for your submission!  Please wait while we get you your schedule.</h3>
      <script>
        window.location.href = "./schedule.php?type=tier1&email=<?php echo $_POST['diverse_regemail']; ?>";
      </script>
      <?php exit; endif; ?>

      <div class="container">
        <h3>
          Attendees
          <small class="text-muted">Please let us know who will be in attendance.</small>
        </h3>
        <p>To access your schedule for this event, please submit your attendee first.</p>
        <form action="registration.php?submit=true&type=tier1" method="post" class="needs-validation" novalidate>
          <div class="form-group">
            <h4>
              Attendee
              <small class="text-muted">Required</small>
            </h4>
            <div class="form-row">
              <div class="col">
                <label for="attendee1_fname">First Name</label>
                <input type="text" class="form-control" placeholder="First Name" id="attendee1_fname"  name="attendee1_fname" required>
                <div class="invalid-feedback">
                  First Name is required.
                </div>
              </div>
              <div class="col">
                <label for="attendee1_lname">Last Name</label>
                <input type="text" class="form-control" placeholder="Last Name" id="attendee1_lname" name="attendee1_lname" required>
                <div class="invalid-feedback">
                  Last Name is required.
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="attendee1_title">Title</label>
                <input type="text" class="form-control" placeholder="Title" id="attendee1_title" name="attendee1_title" required>
                <div class="invalid-feedback">
                  Title is required.
                </div>
              </div>
              <div class="col">
                <label for="attendee1_email">E-Mail Address</label>
                <input type="email" class="form-control" placeholder="E-Mail Address" id="attendee1_email" name="attendee1_email" required>
                <div class="invalid-feedback">
                  E-Mail Address is required.
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <label for="companyname">Company Name</label>
                <input type="text" class="form-control" placeholder="Company Name" id="companyname" name="companyname">
                <div class="invalid-feedback">
                  Company Name is required.
                </div>
              </div>
            </div>
            <input type="hidden" name="diverse_regemail" value="<?php echo $regemail; ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    <?php endif; ?>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
