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
	<h1>Cellar Employees</h1>

    <?php

    //path to the SQLite database file
    $db_file = './myDB/cellar.db';

    try {
        //open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);
        //set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //return all passengers, and store the result set
       $query_str = "select employee_ID, AVG(rating) as rat, COUNT(rating) as tot from Employee natural join Feedback group by employee_ID;";
        
        
        $result_set = $db->query($query_str);
                
                
        echo "
        	<div class='col-md-6'>
        		<table class='table'>
        		<thead>
        			<tr>
        				<th>Employee ID</th>
        				<th>Average Rating</th>
        				<th>Orders Completed</th>
        			</tr>
        		</thead>
        		<tbody>		
        	";           

        foreach($result_set as $tuple) {
        
        
           	echo "
           		<tr>
           			<form action='viewFeedback.php' method='post'>
           			<td><input style='border:none' type='text' name='old_ID' value='$tuple[employee_ID]' readonly></td>
           			<td><input style='border:none' type='text' name='old_rating' value='$tuple[rat]' readonly></td>
           			 <td><input style='border:none' type='text' name='old_rating' value='$tuple[tot]' readonly></td>

        		    <td><input type='submit' name='viewfeedback' value='View Feedback History' readonly></td>";
        		
        	echo "
        		</form>
        		</tr>";	    

                         
        }
        
        echo "
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
    
    
</body>
</html>