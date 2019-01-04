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
    <title>Past Orders</title>

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
<p>

<h1>Your Past Orders</h1>

<?php	
	
	$db_file = './myDB/cellar.db';
	
	try	{
		//open connection
		$db = new PDO('sqlite:' . $db_file);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$userID = $_SESSION["user_ID"];
		
		$query_str = "select * from Order_form natural join menu where student_ID =".$userID.";";
		$result_set = $db->query($query_str);
		
		echo "
			<div class='col-md-6'>
				<table class='table'>
        		<thead>
        			<tr>
        				<th>Menu Item</th>
        				<th>Ingredients</th>
        				<th>Re-Order</th>
        			</tr>
        		</thead>
        		<tbody>		
        	";   
        	
        foreach($result_set as $tuple)	{

            $menu_item = $tuple["item_ID"];
            $order_ID = $tuple["order_ID"];

            $ingredient_str = "select ingredient_name from menu natural join menu_ingredient natural join stock where item_ID=".$menu_item.";";
            $ingredient_query = $db->query($ingredient_str);

        	
        	echo "
        			<tr>
        				<form action='pizzaOrderHandler.php' method='post'>
        				<td><input style ='border:none' type='text' name='old_order_ID' value='$tuple[item_name]' readonly></td>
        				<td>";
        	            foreach ($ingredient_query as $ingredient){
        	                echo "<input style ='border:none' type='text' name='old_order_time' value='$ingredient[ingredient_name]' readonly>";
        	            }
        	            echo "
        				</td>
        				<input type=\"hidden\" name=\"orderType\" value=\"reOrder\" >
        				<input type=\"hidden\" name=\"order_ID\" value=\"$order_ID\" >>
        				<td><input type='submit' name='update' value='Re-order' onclick='document.location.href=\"pizzaOrderHandler.php\"'></td>
        				";
			
			echo "
        		</form>
        		</tr>";	
        		
        		}	 
        
        
        echo	"
        	</tbody>
        	</table>
        	</div>";
        	
        	//disconnect from db
        $db = null;
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
    ?>
        

</p> 
</body>
</html>
		