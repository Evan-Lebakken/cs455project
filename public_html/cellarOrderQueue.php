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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <div id="nav"></div>

    <p>
        <?php

        //path to the SQLite database file
        $db_file = './myDB/cellar.db';

        try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);
            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //return all passengers, and store the result set
            $query_str = "with ordersINQueue as ( select order_time, student_ID, order_ID,item_ID from Order_form NATURAL JOIN Queue)
            select * from ordersINQueue, Menu WHERE ordersINQueue.item_ID = Menu.item_ID; ";
    //        $query_str = "select * from Queue;";
            $result_set = $db->query($query_str);

            //loop through each tuple in result set and print out the data
            
            echo "
            	 <div class='col-md-6'>
        		<table class='table'>
        		<thead>
        			<tr>
        				<th>Time</th>
        				<th>Order ID</th>
        				<th>Student ID</th>
        				<th>Item</th>
        			</tr>
        		</thead>
        		<tbody>
        	";

            foreach($result_set as $tuple) {

            	echo "
        			<tr>
        				<form action='QueueHandler.php' method='post'>
        				<td><input style ='border:none' type='text' name='old_order_time' value='$tuple[order_time]' readonly></td>
        				<td><input style ='border:none' type='text' name='old_order_ID' value='$tuple[order_ID]' readonly></td>
        				<td><input style ='border:none' type='text' name='old_student_ID' value='$tuple[student_ID]' readonly></td>
        				<td><input style ='border:none' type='text' name='old_item_name' value='$tuple[item_name]' readonly></td>
        				<td><input type='submit' name='update' value='Remove From Queue' onclick='document.location.href=\"QueueHandler.php\"'></td>
        				";

                  echo "
        		</form>
        		</tr>";
            }

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