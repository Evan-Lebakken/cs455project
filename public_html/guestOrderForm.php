<!DOCTYPE html>
<html>
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
<form action="pizzaOrderHandler.php" method="post">
    <label>
        <br><b>Select Menu Item</b>
        <select class="my-2" name="item_ID">

            <?php
            $db_file = './myDB/cellar.db';
            try {
                //open connection to cellar db
                $db = new PDO('sqlite:' . $db_file);

                //set errorMode to use exceptions
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //return all menu items and store result
                $query_str = "select * from Menu where time = 10;";
                $result_set = $db->query($query_str);
                foreach ($result_set as $tuple) {
                    echo "<option value='$tuple[item_ID]'>$tuple[item_name]</option>";
                }
            }
            catch (PDOException $e){
                die('Exception : '.$e->getMessage());
            }
            $db = null;

            ?>
        </select>
        <br>
        <b>Choose Size!</b>
        <select class="my-2" name="size">
            <option value="small">Small</option>
            <option value="medium">Medium</option>
            <option value="large">Large</option>
        </select>
    </label>
    <br>
    <input type="hidden" name="orderType" value="orderAsGuest" >
    <input type="submit" class="btn btn-secondary">
</form>
</body>
