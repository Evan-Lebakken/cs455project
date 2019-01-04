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
<?php
    $errorMessage = $_GET['error'];
    echo"<div><b>$errorMessage</b></div>";
?>
<div id="nav"></div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="menuOrder-tab" data-toggle="tab" href="#menuOrder" role="tab" aria-controls="menuOrder" aria-selected="true">Order From Menu</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="customMenuOrder-tab" data-toggle="tab" href="#customMenuOrder" role="tab" aria-controls="customMenuOrder" aria-selected="false">Customize Menu Item</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="customOrder-tab" data-toggle="tab" href="#customOrder" role="tab" aria-controls="customOrder" aria-selected="false">Custom Order</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="feelingLucky-tab" data-toggle="tab" href="#feelingLucky" role="tab" aria-controls="feelingLucky" aria-selected="false">Feeling Lucky?</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="menuOrder" role="tabpanel" aria-labelledby="menuOrder-tab">
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
            <input type="hidden" name="orderType" value="menuOrder" >
            <input type="submit" class="btn btn-secondary">
        </form>
    </div>
    <div class="tab-pane fade" id="customMenuOrder" role="tabpanel" aria-labelledby="customMenuOrder-tab">
        <form action="ingredientsForm.php" method="post">
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
            <input type="hidden" name="orderType" value="menuOrder" >
            <input type="submit" class="btn btn-secondary">
        </form>
    </div>
    <div class="tab-pane fade" id="customOrder" role="tabpanel" aria-labelledby="customOrder-tab">
        <form action="pizzaOrderHandler.php" method="post">
            <b>Choose Size</b>
            <select class="my-2" name="size">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
            <br><b>Select Sauce</b>
            <select class="my-2" name="ingredient_IDs[]">
                <?php
                $db_file = './myDB/cellar.db';
                try{
                    $db = new PDO('sqlite:' . $db_file);
                    //set errorMode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $saucesQuery = "SELECT * FROM Stock WHERE ingredient_ID < 104;";
                    $sauces = $db->query($saucesQuery);
                    foreach ($sauces as $sauce){
                        echo"<option name='ingredient_ID' value='$sauce[ingredient_ID]'>$sauce[ingredient_name]</option><br>";
                    }
                }
                catch (PDOException $e){
                    die('Exception : '.$e->getMessage());
                }
                ?>
                <option>(none)</option>;
            </select>
            <br><b>Select Cheese</b>
            <select name="ingredient_IDs[]">
                <?php
                $db_file = './myDB/cellar.db';
                try{
                    $db = new PDO('sqlite:' . $db_file);
                    //set errorMode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $cheesesQuery = "SELECT * FROM Stock WHERE type = 'Cheese';";
                    $cheeses = $db->query($cheesesQuery);
                    foreach ($cheeses as $cheese){
                        echo"<option name='ingredient_ID' value='$cheese[ingredient_ID]'>$cheese[ingredient_name]</option><br>";
                    }
                }
                catch (PDOException $e){
                    die('Exception : '.$e->getMessage());
                }
                ?>
                <option>(none)</option>;
            </select>
            <br><b>Select Cheese</b>
            <select name="ingredient_IDs[]">
                <?php
                $db_file = './myDB/cellar.db';
                try{
                    $db = new PDO('sqlite:' . $db_file);
                    //set errorMode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $cheesesQuery = "SELECT * FROM Stock WHERE type = 'Cheese';";
                    $cheeses = $db->query($cheesesQuery);
                    foreach ($cheeses as $cheese){
                        echo"<option name='ingredient_ID' value='$cheese[ingredient_ID]'>$cheese[ingredient_name]</option><br>";
                    }
                }
                catch (PDOException $e){
                    die('Exception : '.$e->getMessage());
                }
                ?>
                <option>(none)</option>;
            </select>
            <br><b>Select Topping</b>
            <select name="ingredient_IDs[]">
                <?php
                $db_file = './myDB/cellar.db';
                try{
                    $db = new PDO('sqlite:' . $db_file);
                    //set errorMode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $toppingsQuery = "SELECT * FROM stock WHERE type = 'Veggies' OR type = 'Meat';";
                    $toppings = $db->query($toppingsQuery);
                    foreach ($toppings as $topping){
                        echo"<option name='ingredient_ID' value='$topping[ingredient_ID]'>$topping[ingredient_name]</option><br>";
                    }
                }
                catch (PDOException $e){
                    die('Exception : '.$e->getMessage());
                }
                ?>
                <option>(none)</option>;
            </select>
            <br><b>Select Topping</b>
            <select name="ingredient_IDs[]">
                <?php
                $db_file = './myDB/cellar.db';
                try{
                    $db = new PDO('sqlite:' . $db_file);
                    //set errorMode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $toppingsQuery = "SELECT * FROM stock WHERE type = 'Veggies' OR type = 'Meat';";
                    $toppings = $db->query($toppingsQuery);
                    foreach ($toppings as $topping){
                        echo"<option name='ingredient_ID' value='$topping[ingredient_ID]'>$topping[ingredient_name]</option><br>";
                    }
                }
                catch (PDOException $e){
                    die('Exception : '.$e->getMessage());
                }
                ?>
                <option>(none)</option>;
            </select>
            <br><b>Select Topping</b>
            <select name="ingredient_IDs[]">
                <?php
                $db_file = './myDB/cellar.db';
                try{
                    $db = new PDO('sqlite:' . $db_file);
                    //set errorMode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $toppingsQuery = "SELECT * FROM stock WHERE type = 'Veggies' OR type = 'Meat';";
                    $toppings = $db->query($toppingsQuery);
                    foreach ($toppings as $topping){
                        echo"<option name='ingredient_ID' value='$topping[ingredient_ID]'>$topping[ingredient_name]</option><br>";
                    }
                }
                catch (PDOException $e){
                    die('Exception : '.$e->getMessage());
                }
                ?>
                <option>(none)</option>;
            </select>
            <br><b>Select Pizza Glaze</b>
            <select name="ingredient_IDs[]">
                <?php
                $db_file = './myDB/cellar.db';
                try{
                    $db = new PDO('sqlite:' . $db_file);
                    //set errorMode to use exceptions
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $toppingsQuery = "SELECT * FROM stock WHERE type = 'Sauce' AND ingredient_ID > 103;";
                    $toppings = $db->query($toppingsQuery);
                    foreach ($toppings as $topping){
                        echo"<option name='ingredient_ID' value='$topping[ingredient_ID]'>$topping[ingredient_name]</option><br>";
                    }
                }
                catch (PDOException $e){
                    die('Exception : '.$e->getMessage());
                }
                ?>
                <option>(none)</option>;
            </select>
            <br>
            <input type="hidden" name="orderType" value="customOrder">
            <input type="submit" value="Submit!">

        </form>
    </div>
    <div class="tab-pane fade" id="feelingLucky" role="tabpanel" aria-labelledby="feelingLucky-tab">
        <div class="jumbotron">
            <h1>Felling Lucky???</h1>
            <p>
                <form action="pizzaOrderHandler.php" method="post">
                    <input type="hidden" name="orderType" value="feelingLucky">
                    <input type="submit" value="Submit!">
                </form>
            </p>
        </div>
    </div>
</div>

</body>
</html>