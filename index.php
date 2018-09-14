<?php
  include 'config.php';
  include 'mysql.php';

  //Let's make the GET information friendlier to access
  $suppliertype = $_GET["type"];
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
      <div class="header">
        <img src="<?php echo $headerlogo; ?>">
        <h1>hello world</h1>
      </div>
    <?php endif; ?>
  </body>
</html>
