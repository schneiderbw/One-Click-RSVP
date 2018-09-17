<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
  $regemail = urldecode($_GET["email"]);
?>

<?php
  //Handle form submissions here
  if ($_GET["submit"] == "true") {
    if ($suppliertype == "tier1") {
      $query = "INSERT INTO tier1_rsvp (attendee1_fname,attendee1_lname,attendee1_title,attendee1_email,attendee2_fname,attendee2_lname,attendee2_title,attendee2_email,companyname,tier1_regemail) VALUES ('".$_POST['attendee1_fname']."','".$_POST['attendee1_lname']."','".$_POST['attendee1_title']."','".$_POST['attendee1_email']."','".$_POST['attendee2_fname']."','".$_POST['attendee2_lname']."','".$_POST['attendee2_title']."','".$_POST['attendee2_email']."','".$_POST['companyname']."','".$_POST['tier1_regemail']."');";
      if(mysqli_query($sql_conn,$query)) {
        $sqlsuccessful = True;
      }
    }
    if ($suppliertype == "diverse") {
      $query = "INSERT INTO diverse_rsvp (attendee1_fname,attendee1_lname,attendee1_title,attendee1_email,companyname,diverse_regemail) VALUES ('".$_POST['attendee1_fname']."','".$_POST['attendee1_lname']."','".$_POST['attendee1_title']."','".$_POST['attendee1_email']."','".$_POST['companyname']."','".$_POST['diverse_regemail']."');";
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-9ralMzdK1QYsk4yBY680hmsb4/hJ98xK3w0TIaJ3ll4POWpWUYaA2bRjGGujGT8w" crossorigin="anonymous">
    <link rel="stylesheet" href="css/application.css"></link>
    <?php elseif($suppliertype == "diverse"): ?>
    <script type="text/javascript">
      $(document).ready(function(){
        $.getJSON("schedule-query.php?type=<?php echo $suppliertype; ?>&email=<?php echo $email; ?>", function(data){
          var meeting_data = '';
          $.each(data, function(key, value){
            meeting_data += '<tr>';
            meeting_data += '<td>'+tConvert(value.meetingtime)+'</td>';
            meeting_data += '<td>'+value.tier1_company+'</td>';
            meeting_data += '<td>'+value.tier1_fname+'</td>';
            meeting_data += '<td>'+value.tier1_lname+'</td>';
            meeting_data += '<td>'+value.tier1_email+'</td>';
            meeting_data += '<td>'+value.capability+'</td>';
          });
          $('#schedule_table').append(meeting_data);
        });
      });
      $(document).ready(function(){
        $("div#loadscreen").addClass("hidden");
        $("table#schedule_table").removeClass("hidden");
      });
    </script>
    <?php endif; ?>
  </head>
  <body>
    <?php if ($suppliertype == "tier1"): ?>
      <?php
        $query = "SELECT company FROM tier1_invitations WHERE email = '$regemail';";
        $result = mysqli_fetch_array(mysqli_query($sql_conn, $query),MYSQLI_ASSOC);
        $usercompany = $result["company"];
      ?>
      <div class="header">
        <img src="<?php echo $headerlogo; ?>">
        <h1>Attendee Registration</h1>
        <h2>Tier 1 Suppliers</h2>
      </div>

      <?php if($sqlsuccessful): ?>
      <h3 class="text-center"><i class="fas fa-spinner-third spin"></i> Thank you for your submission!  Please wait while we get you your schedule.</h3>
      <script>
        window.location.href = "./schedule.php?type=tier1&email=<?php echo urlencode($_POST['tier1_regemail']); ?>";
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
            <input type="hidden" name="companyname" value="<?php echo $usercompany; ?>">
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
        window.location.href = "./schedule.php?type=diverse&email=<?php echo urlencode($_POST['diverse_regemail']); ?>";
      </script>
      <?php exit; endif; ?>

      <div class="container">
        <div class="container" id="loadscreen">
          <div class="header">
              <h3><i class="fas fa-spinner-third spin"></i> Please wait while we gather your schedule...</h3>
          </div>
        </div>
        <table class="table table-bordered table-striped hidden" id="schedule_table">
          <tr>
            <th>Time</th>
            <th>Company</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>E-Mail</th>
            <th>Opportunity Type</th>
          </tr>
        </table>
        <div class="container" id="rsvp_response_widget">
          <h3>Will you be in attendance?</h3>
          <div class="form-check-inline">
            <div class="row">
              <div class="col">
                <input class="form-check-input" type="radio" name="rsvp_response" id="rsvp_response1" value="yes" required>
                <label class="form-check-label" for="rsvp_response1">
                  Yes. I will be in attendance.
                </label>
              </div>
              <div>
                <input class="form-check-input" type="radio" name="rsvp_response" id="rsvp_response2" value="no" required>
                <label class="form-check-label" for="rsvp_response1">
                  No. I will not be in attendance.
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="container hidden" id="declineresponse_data">
          <form action="registration.php?submit=true&type=diverse" method="post" class="needs-validation" novalidate>
            <div class="form-row">
              <div class="col">
                <label for="declineselector">Please select a reason you chose not to attend.</label>
                <select class="custom-select" name="declinereason" id="declinereason">
                  <option disabled selected>Please select a reason.</option>
                  <option value="I have another priority">I have another priority</option>
                </input>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <input type="hidden" name="diverse_regemail" value="<?php echo $regemail; ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
        <div class="container hidden" id="attendee_data">
          <h3>
            Attendees
            <small class="text-muted">Please let us know who will be in attendance.</small>
          </h3>
          <p>To access your schedule for this event, please submit your attendee first.</p>
          <form action="registration.php?submit=true&type=diverse" method="post" class="needs-validation" novalidate>
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

      // Allows either the attendees submission form to appear, or decline reason form to appear
      $('input:radio[name="rsvp_response"]').change(
      	function(){
        	if ($(this).val() == 'yes') {
            $("div#declineresponse_data").addClass("hidden");
            $("div#attendee_data").removeClass("hidden");
          } else if ($(this).val() == 'no') {
            $("div#declineresponse_data").removeClass("hidden");
            $("div#attendee_data").addClass("hidden");
          }
        });
    </script>
  </body>
</html>
