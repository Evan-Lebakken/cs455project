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
<?php
if ($_SESSION["redirect"] == "username") {
    echo "
        <div class=\"card\">
        <div class=\"card-body m-auto\">
            <h3>Sorry, that username is taken!</h3>
            <a role=\"button\" class=\"btn btn-primary\" href=\"createAccount.html\">Back</a>
        </div>

    </div>
    ";
}
elseif ($_SESSION["redirect"] == "wrong_pass"){
    echo "
        <div class=\"card\">
        <div class=\"card-body m-auto\">
            <h3>Sorry, your password is incorrect!</h3>
            <a role=\"button\" class=\"btn btn-primary\" href=\"login.html\">Back</a>
        </div>

    </div>
    ";
}
elseif ($_SESSION["redirect"] == "no_user"){
    echo "
        <div class=\"card\">
        <div class=\"card-body m-auto\">
            <h3>Sorry, we don't have a account associated with that student ID!</h3>
            <a role=\"button\" class=\"btn btn-primary\" href=\"login.html\">Back</a>
        </div>

    </div>
    ";
}
?>
</body>
</html>


