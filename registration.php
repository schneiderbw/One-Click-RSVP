<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
  $regemail = urldecode($_GET["email"]);
?>

<?php
  //Validate registration e-mail address
  if ($suppliertype == "tier1"){
    $validation_query = "SELECT * FROM tier1_invitations WHERE email = '$regemail';";
    if(mysqli_num_rows(mysqli_query($sql_conn,$validation_query)) > 0){
      $validation_check = "TRUE";
    } else {
      $validation_check = "FALSE";
    }
  }
  if ($suppliertype == "diverse"){
    $validation_query = "SELECT * FROM diverse_invitations WHERE email = '$regemail';";
    if(mysqli_num_rows(mysqli_query($sql_conn,$validation_query)) > 0){
      $validation_check = "TRUE";
    } else {
      $validation_check = "FALSE";
    }
  }

  // Check to see if the user has already registered
  if ($suppliertype == "tier1"){
    $existingrecord_query = "SELECT * FROM tier1_rsvp WHERE tier1_regemail = '$regemail';";
    if(mysqli_num_rows(mysqli_query($sql_conn,$existingrecord_query)) > 0){
      $existingrecord_check = "TRUE";
      $existingrecord = mysqli_fetch_assoc(mysqli_query($sql_conn,$existingrecord_query));
    } else {
      $existingrecord_check = "FALSE";
    }
  }
  if  ($suppliertype == "diverse"){
    $existingrecord_query = "SELECT * FROM diverse_rsvp WHERE diverse_regemail = '$regemail';";
    if(mysqli_num_rows(mysqli_query($sql_conn,$existingrecord_query)) > 0){
      $existingrecord_check = "TRUE";
      $existingrecord = mysqli_fetch_assoc(mysqli_query($sql_conn,$existingrecord_query));
    } else {
      $existingrecord_check = "FALSE";
    }
  }
?>

<?php
  //Handle form submissions here
  if ($_GET["submit"] == "true") {
    if ($suppliertype == "tier1") {
      $query = "INSERT INTO tier1_rsvp (attendee1_fname,attendee1_lname,attendee1_title,attendee1_email,attendee2_fname,attendee2_lname,attendee2_title,attendee2_email,companyname,tier1_regemail) VALUES ('".$_POST['attendee1_fname']."','".$_POST['attendee1_lname']."','".$_POST['attendee1_title']."','".$_POST['attendee1_email']."','".$_POST['attendee2_fname']."','".$_POST['attendee2_lname']."','".$_POST['attendee2_title']."','".$_POST['attendee2_email']."','".$_POST['companyname']."','".$_POST['tier1_regemail']."');";
      if(mysqli_query($sql_conn,$query)) {
        $sqlsuccessful = "True";
        $mailtrain_listid = "B16uVTdW";
        $mailtrain_fullurl = $mailtrain_url . "subscribe/" . $mailtrain_listid . "?access_token=" . $mailtrain_accesstoken;
        $attendee1_fields = array(
          'EMAIL' => $_POST['attendee1_email'],
          'FIRST_NAME' => $_POST['attendee1_fname'],
          'LAST_NAME' => $_POST['attendee1_lname'],
          'MERGE_COMPANY' => $_POST['companyname'],
          'FORCE_SUBSCRIBE' => "yes",
          'REQUIRE_CONFIRMATION' => "no",
        );
        $attendee1_postvars = http_build_query($attendee1_fields);

        $attendee1_ch = curl_init();
        curl_setopt($attendee1_ch, CURLOPT_URL, $mailtrain_fullurl);
        curl_setopt($attendee1_ch, CURLOPT_POST, count($attendee1_fields));
        curl_setopt($attendee1_ch, CURLOPT_POSTFIELDS, $attendee1_postvars);

        $attendee1_curlresult = curl_exec($attendee1_ch);
        curl_close($attendee1_ch);

        if(!empty($_POST['attendee2_email'])){
          $attendee2_fields = array(
            'EMAIL' => $_POST['attendee2_email'],
            'FIRST_NAME' => $_POST['attendee2_fname'],
            'LAST_NAME' => $_POST['attendee2_lname'],
            'MERGE_COMPANY' => $_POST['companyname'],
            'FORCE_SUBSCRIBE' => "yes",
            'REQUIRE_CONFIRMATION' => "no",
          );
          $attendee2_postvars = http_build_query($attendee2_fields);

          $attendee2_ch = curl_init();

          curl_setopt($attendee2_ch, CURLOPT_URL, $mailtrain_fullurl);
          curl_setopt($attendee2_ch, CURLOPT_POST, count($attendee2_fields));
          curl_setopt($attendee2_ch, CURLOPT_POSTFIELDS, $attendee2_postvars);

          $attendee2_curlresult = curl_exec($attendee2_ch);
          curl_close($attendee2_ch);
        }
      }
    }
    if ($suppliertype == "diverse") {
      $query = "INSERT INTO diverse_rsvp (attendee1_fname,attendee1_lname,attendee1_title,attendee1_email,companyname,diverse_regemail) VALUES ('".$_POST['attendee1_fname']."','".$_POST['attendee1_lname']."','".$_POST['attendee1_title']."','".$_POST['attendee1_email']."','".$_POST['companyname']."','".$_POST['diverse_regemail']."');";
      if(mysqli_query($sql_conn,$query)) {
        $sqlsuccessful = "True";
        $mailtrain_listid = "B16uVTdW";
        $mailtrain_fullurl = $mailtrain_url . "subscribe/" . $mailtrain_listid . "?access_token=" . $mailtrain_accesstoken;
        $attendee1_fields = array(
          'EMAIL' => $_POST['attendee1_email'],
          'FIRST_NAME' => $_POST['attendee1_fname'],
          'LAST_NAME' => $_POST['attendee1_lname'],
          'MERGE_COMPANY' => $_POST['companyname'],
          'FORCE_SUBSCRIBE' => "yes",
          'REQUIRE_CONFIRMATION' => "no",
        );
        $attendee1_postvars = http_build_query($attendee1_fields);

        $attendee1_ch = curl_init();
        curl_setopt($attendee1_ch, CURLOPT_URL, $mailtrain_fullurl);
        curl_setopt($attendee1_ch, CURLOPT_POST, count($attendee1_fields));
        curl_setopt($attendee1_ch, CURLOPT_POSTFIELDS, $attendee1_postvars);

        $attendee1_curlresult = curl_exec($attendee1_ch);
        curl_close($attendee1_ch);
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
    <?php if($suppliertype == "diverse"): ?>
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
        $.getJSON("schedule-query.php?preview=yes&type=<?php echo $suppliertype; ?>&email=<?php echo urlencode($regemail); ?>", function(data){
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
        <h4>Welcome <?php echo $usercompany; ?></h4>
      </div>
      <?php if($sqlsuccessful): ?>
      <h3 class="text-center"><i class="fas fa-spinner-third spin"></i> Thank you for your submission!  Please wait while we get you your schedule.</h3>
      <script>
        window.location.href = "./schedule.php?type=tier1&email=<?php echo urlencode($_POST['tier1_regemail']); ?>";
      </script>
      <?php exit; endif; ?>
      <?php if($validation_check == "FALSE"): ?>
        <div class="container">
          <div class="alert alert-danger" role="alert">
            <h3 class="alert-heading">Uh oh! Something went wrong!</h3>
            <p>We apologize, something went wrong when we were validating your invitation.  Please click the link in your e-mail again.</p>
            <hr>
            <p>If you have already re-tried the link, please contact Donna Hansee at <a class="alert-link" href="mailto:dhansee@techsoftsystems.com&subject=Honda%20Registration%20Issue%20-%20Tier%201%20Supplier">dhansee@techsoftsystems.com</a> for assistance.</p>
            <p><em>We apologize for any inconvenience.</em></p>
          </div>
        </div>
      <?php exit; endif; ?>
      <?php if($existingrecord_check == "TRUE"): ?>
        <div class="container">
          <div class="alert alert-success" role="alert">
            <h3 class="alert-heading">You are already registered!</h3>
            <p>It appears that your organization, <?php echo $usercompany; ?>, has already registered for this event.  If you need your schedule, <a class="alert-link" href="./schedule.php?type=tier1">click here!</a></p>
            <hr>
            <p>If you don't believe you have registered yet, please contact Donna Hansee at <a class="alert-link" href="mailto:dhansee@techsoftsystems.com&subject=Honda%20Registration%20Issue%20-%20Tier%201%20Supplier">dhansee@techsoftsystems.com</a> for assistance.</p>
            <p><em>Thank you!</em></p>
          </div>
        </div>
        <div class="container">
          <h4>Attendee 1</h4>
          <table class="table table-bordered table-striped">
            <tr width="50%">
              <th>First Name</th>
              <td><?php echo $existingrecord["attendee1_fname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Last Name</th>
              <td><?php echo $existingrecord["attendee1_lname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Title</th>
              <td><?php echo $existingrecord["attendee1_title"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Company</th>
              <td><?php echo $existingrecord["companyname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>E-Mail Address</th>
              <td><?php echo $existingrecord["attendee1_email"]; ?></td>
            </tr>
          </table>
          <h4>Attendee 2</h4>
          <table class="table table-bordered table-striped">
            <tr width="50%">
              <th>First Name</th>
              <td><?php echo $existingrecord["attendee2_fname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Last Name</th>
              <td><?php echo $existingrecord["attendee2_lname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Title</th>
              <td><?php echo $existingrecord["attendee2_title"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Company</th>
              <td><?php echo $existingrecord["companyname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>E-Mail Address</th>
              <td><?php echo $existingrecord["attendee2_email"]; ?></td>
            </tr>
          </table>
        </div>
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
      <?php
        $query = "SELECT company FROM diverse_invitations WHERE email = '$regemail';";
        $result = mysqli_fetch_array(mysqli_query($sql_conn, $query),MYSQLI_ASSOC);
        $usercompany = $result["company"];
      ?>
      <div class="header">
        <img src="<?php echo $headerlogo; ?>">
        <h1>Attendee Registration</h1>
        <h2>Diverse Suppliers</h2>
        <h4>Welcome <?php echo $usercompany; ?>
      </div>
      <?php if($sqlsuccessful): ?>
      <h3 class="text-center">Thank you for your submission!  Please wait while we get you your schedule.</h3>
      <script>
        window.location.href = "./schedule.php?type=diverse&email=<?php echo urlencode($_POST['diverse_regemail']); ?>";
      </script>
      <?php exit; endif; ?>
      <?php if($validation_check == "FALSE"): ?>
      <div class="container">
        <div class="alert alert-danger" role="alert">
          <h3 class="alert-heading">Uh oh! Something went wrong!</h3>
          <p>We apologize, something went wrong when we were validating your invitation.  Please click the link in your e-mail again.</p>
          <hr>
          <p>If you have already re-tried the link, please contact Donna Hansee at <a class="alert-link" href="mailto:dhansee@techsoftsystems.com&subject=Honda%20Registration%20Issue%20-%20Diverse%20Supplier">dhansee@techsoftsystems.com</a> for assistance.</p>
          <p><em>We apologize for any inconvenience</em></p>
        </div>
      </div>
      <?php exit; endif; ?>
      <?php if($existingrecord_check == "TRUE"): ?>
        <div class="container">
          <div class="alert alert-success" role="alert">
            <h3 class="alert-heading">You are already registered!</h3>
            <p>It appears that your organization, <?php echo $usercompany; ?>, has already registered for this event.  If you need your schedule, <a class="alert-link" href="./schedule.php?type=diverse">click here!</a></p>
            <hr>
            <p>If you don't believe you have registered yet, please contact Donna Hansee at <a class="alert-link" href="mailto:dhansee@techsoftsystems.com&subject=Honda%20Registration%20Issue%20-%20Diverse%20Supplier">dhansee@techsoftsystems.com</a> for assistance.</p>
            <p><em>Thank you!</em></p>
          </div>
        </div>
        <div class="container">
          <h4>Attendee 1</h4>
          <table class="table table-bordered table-striped">
            <tr width="50%">
              <th>First Name</th>
              <td><?php echo $existingrecord["attendee1_fname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Last Name</th>
              <td><?php echo $existingrecord["attendee1_lname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Title</th>
              <td><?php echo $existingrecord["attendee1_title"]; ?></td>
            </tr>
            <tr width="50%">
              <th>Company</th>
              <td><?php echo $existingrecord["companyname"]; ?></td>
            </tr>
            <tr width="50%">
              <th>E-Mail Address</th>
              <td><?php echo $existingrecord["attendee1_email"]; ?></td>
            </tr>
          </table>
        </div>
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
            <th>Website</th>
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
                  <option value="Schedule Conflict">Schedule Conflict</option>
                  <option value="Not enough meetings">Not enough meetings</option>
                  <option value="Too late of notification/invitation">Too late of notification/invitation</option>
                  <option value="Inconvenient location">Inconvenient location</option>
                  <option value="Travel expense">Travel expense</option>
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
