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
    </div>
  </body>
</html>
