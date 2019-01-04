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
		
	<a type ='button' class='btn btn-lg btn-default' href='cellarOrderCards.php'>Order Queue</a>
	<a type ='button' class='btn btn-lg btn-default' href='showEmployees.php'>View Employees</a>
	
	<h1>View Ingredients</h1></br>

    <?php
    
    if($_GET['status'] == 'success!'){
    	echo "success!!";
    }	

    //path to the SQLite database file
    $db_file = './myDB/cellar.db';

    try {
        //open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);
        //set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query_str = "select * from Stock order by quantity";
        $result_set = $db->query($query_str);

        //loop through each tuple in result set and print out the data
                
        echo "
        	<div class='col-md-6'>
        		<table class='table'>
        		<thead>
        			<tr>
        				<th>Ingredient ID</th>
        				<th>Ingredient Name</th>
        				<th>Quantity</th>
        				<th>Ingredient Type</th>
        				<th></th>
        				<th>Notifications</th>
        			</tr>
        		</thead>
        		<tbody>		
        	";   
        	
        foreach($result_set as $tuple)	{
        
			$quantity = $tuple['quantity'];
			
        	echo "
        			<tr>
        				<form action='updateIngredients.php' method='post'>
        				<td><input style ='border:none' type='text' name='old_ingredient_ID' value='$tuple[ingredient_ID]' readonly></td>
        				<td><input style ='border:none' type='text' name='old_ingredient_name' value='$tuple[ingredient_name]' readonly></td>
        				<td><input style ='border:none' type='text' name='old_quantity' value='$tuple[quantity]' readonly></td>
        				<td><input style ='border:none' type='text' name='old_type' value='$tuple[type]' readonly></td>
        				<td><input type='submit' name='update' value='Update Quantity' onclick='document.location.href=\"updateIngredients.php\"'></td>
        				";
        	
        	if($quantity < 5)	{
        		echo "
        			<td><input style ='border:none' type='text' name='noti' value='Disabled From Menu' readonly></td>";
        	}		
        	else	{
        		//echo "
        		//	<td><input style ='border:none' type='text' name='old_type' value='good' readonly></td>";
        	}	
        			
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