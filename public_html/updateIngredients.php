<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Order Queue</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        $(document).ready(function(){

            $('#nav').load("nav.php");

        });
    </script>
</head>
<body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<div id="nav"></div>

<?php   if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_GET['get'] == 'true'){
            echo "<form action = \"ingredientUpdateHandler.php\" method=\"post\" >";
        }
?>

<h1>Ingredient ID: <?php echo $_POST["old_ingredient_ID"];?></h1>
<h1>Ingredient Name: <?php echo $_POST["old_ingredient_name"];?> [ <?php echo $_POST["old_type"];?>]</h1>


 
<h3>Update Quantity:</h3>
<td><input type="text" name="new_quantity" value="<?php echo $_POST["old_quantity"];?>" required><?php echo"$_GET[quantityErrMsg]" ?> </td> 
    
    
    <input type="hidden" name="ing_ID" value="<?php echo $_POST["old_ingredient_ID"];?>">
    
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'|| $_GET['get'] == 'true'){
        echo "<input type='submit' value='Update' onclick=\"document.location.href=\"ingredientUpdateHandler.php\";\"/>";
    } 
    ?>
    
</form>
</body>
</html>