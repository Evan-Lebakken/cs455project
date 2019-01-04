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
    <div class="mx-4">
        <div id="nav"></div>
        <h1 class="my-3">Confirm Ingredients!</h1>
        <?php
            $item = $_POST["item_ID"];
        ?>
        <form action="pizzaOrderHandler.php" method="post">
            <?php
            $db_file = './myDB/cellar.db';
            try {
                //open connection to cellar db
                $db = new PDO('sqlite:' . $db_file);

                //set errorMode to use exceptions
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //return all menu items and store result
                $item = $_POST["item_ID"];
                $size = $_POST["size"];
                $query_str = "SELECT stock.ingredient_name, ingredient_ID, type FROM Menu NATURAL JOIN(Menu_ingredient NATURAL JOIN Stock) WHERE Menu.item_ID =".$item.";" ;
                $result_set = $db->query($query_str);
                $getTimeQuery = "SELECT time FROM Menu WHERE item_ID =".$item.";";
                $timeResult = $db->query($getTimeQuery);
                $time = "";
                foreach($timeResult as $itemTime){
                    $time = $itemTime["time"];
                }
                $max_item_ID_str = "SELECT MAX(item_ID) FROM Menu;";
                $max_item_ids = $db->query($max_item_ID_str);
                $max_item_ID = "";
                foreach ($max_item_ids as $ID){
                    $max_item_ID = $ID["MAX(item_ID)"];
                }
                foreach ($result_set as $tuple) {
                    echo "<select name='ingredient_IDs[]'>";
                    $type = $tuple["type"];
                    $similarIngredients_query ="SELECT ingredient_name, ingredient_ID, ingredient_ID FROM stock WHERE quantity > 5 AND type =";
                    $similarIngredients_query = $similarIngredients_query."'$type'".";";
                    //echo "<b>$type</b>";
                    $similarIngredients = $db->query($similarIngredients_query);
                    foreach ($similarIngredients as $ingredient){
                        if($tuple["ingredient_ID"] == $ingredient["ingredient_ID"]){
                            echo "<option name='ingredient_ID' value='$ingredient[ingredient_ID]' selected='selected'>$ingredient[ingredient_name]</option>";

                        }
                        else{
                            echo "<option name='ingredient_ID' value='$ingredient[ingredient_ID]'>$ingredient[ingredient_name]</option><br>";
                        }

                        //echo"$ingredient[ingredient_name]";
                    }
                    echo"<option>(none)</option>";
                    echo "</select>";
                    echo "<input type='hidden' name='size' value='$size'>";
                    echo "<input type='hidden' name='submit' >";


                }
            }

            catch (PDOException $e){
                die('Exception : '.$e->getMessage());
            }
            $db = null;
            //echo"<b>$max_item_ID</b>";
            echo "<input type='hidden' name='item_ID' value='$max_item_ID'>";
            echo"<input type='hidden' name='item_Time' value='$time'>";
            echo"<input type='hidden' name='orderType' value='customMenuOrder'>";

            ?>
            <br>
            <input class="btn btn-secondary my-3" type="submit">
            <?php
                //echo"<b>stuff should be here $time</b>";
            ?>
        </form>
    </div>
</body>
</html>