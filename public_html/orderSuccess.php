<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ingredients Form</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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
<div class="mx-4">
    <?php
    $db_file = './myDB/cellar.db';
    try {
        //open connection to cellar db
        $db = new PDO('sqlite:' . $db_file);

        //set errorMode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //return all menu items and store result
        $order_query = "with ordersINQueue as (SELECT Order_form.item_ID FROM Queue NATURAL JOIN Order_form) Select SUM(Menu.time) FROM ordersINQueue NATURAL JOIN Menu;";
        $result = $db->query($order_query);
        foreach ($result as $total){
            $totalTime = $total["SUM(Menu.time)"];
        }
        echo "<h4 class='my-3'>Order placed! Your order will be ready in $totalTime minutes</h4>";
    }
    catch (PDOException $e){
        die('Exception : '.$e->getMessage());
    }
    $db = null;
    ?>
</div>

