<?php
    include 'core/init.php';
    if($getFromU->loggedIn() === true){
        header('Location: home.php');
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alliance | Get Started</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

</head>
<body>
    <div class="container pt-5">
      <p class='text-primary'>Get Started with Alliance</p>
    </div>
</body>
</html>
