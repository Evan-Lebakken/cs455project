<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#nav').load("nav.php");

        });
    </script>
</head>
<body>
    <div id="nav"></div>
    <div class="card">
        <div class="card-body m-auto">
            <h3>Welcome! You are logged in.</h3>
            <?php
                if($_SESSION["user"] == "employee" && $_SESSION["employee_access"] == true){
                    echo "<p>Welcome employee! your account has been verified. All functionality should be available.</p>";
                } elseif ($_SESSION["user"] == "employee" && $_SESSION["employee_access"] == false) {
                    echo "<p>Hello employee, your account has not been verified. Only student functionality will be available.</p>";
                }
            ?>
            <a role="button" class="btn btn-primary" href="cellarMock.php">Home</a>
        </div>
    </div>
</body>
</html>