<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Cellar Order</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
<body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand px-2" href="cellarMock.php">
            <img src="uploads/cellar_logo.PNG" width="46" height="38" class="d-inline-block align-top" alt="">
            The Cellar
        </a>
        <form class="form-inline">
            <?php
            if ($_SESSION["user"] == "student" || $_SESSION["user"] == "employee"){
                echo "
                <a role=\"button\" class=\"btn btn-outline-light mx-1\" href=\"logout.php\">Log Out</a>
                ";
            } else {
                echo "
                <a role=\"button\" class=\"btn btn-outline-light mx-1\" href=\"login.html\">Login</a>
                <a role=\"button\" class=\"btn btn-outline-light mx-1\" href=\"createAccount.html\">Register</a>
                ";
            }
            ?>
            <button class="navbar-toggler mx-1" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </form>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <?php
                    if ($_SESSION["user"]=="student" || $_SESSION["user"]=="employee"){
                        echo "<a class=\"nav-item nav-link\" href=\"orderForm.php\">Order Form</a>";
                        echo "<a class=\"nav-item nav-link\" href=\"showPastOrders.php\">Past Orders</a>";
                    }
                    if ($_SESSION["employee_access"]==true){
                        echo "<a class=\"nav-item nav-link\" href=\"cellarOrderCards.php\">Order Queue</a>";
                    }
                if ($_SESSION["manager_access"]==true && $_SESSION["employee_access"]==true){
                    echo "<a class=\"nav-item nav-link\" href=\"managerHub.php\">Manager Hub</a>";
                    }
                ?>
            </div>
        </div>
    </nav>
</body>
</html>