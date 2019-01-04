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
<h2>Unfilled Orders</h2>
<p><a class="btn btn-lg btn-success" href="claimForm.php" role="button">Claim Responsibility!</a></p>
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
        $query_str = "with ordersINQueue as ( select order_time, student_ID, order_ID,item_ID, employee_ID from Order_form NATURAL JOIN Queue)
        select * from ordersINQueue, Menu WHERE ordersINQueue.item_ID = Menu.item_ID; ";
//        $query_str = "select * from Queue;";
        $result_set = $db->query($query_str);

        //loop through each tuple in result set and print out the data
        //ssn will be shown in blue (see below)
        echo "<div class='card-deck mx-2 '>";
        foreach($result_set as $tuple) {
            $time = $tuple['order_time'];
            $order_id = $tuple['order_ID'];
            $student_id = $tuple['student_ID'];
            $item_name = $tuple['item_name'];
            $employee_id = $tuple['employee_ID'];

            $ingredient_str = "select ingredient_name from menu natural join menu_ingredient natural join stock where item_ID=".$tuple['item_ID'].";";
            $ingredient_query = $db->query($ingredient_str);

            echo "
                      
                         <card class='my-2 mx-2 border border-secondary rounded' method='post'>
                             <card-body>
                                <form action='QueueHandler.php' method='post'>
                                <div class='px-2'>
                                   <p>Order Time: $time</p>
                                   <p>Order ID: <input style ='border:none' type='text' name='old_order_ID' value= '$order_id' readonly></p>
                                   <p>Order Student ID: $student_id</p>
                                   <p>Item: $item_name</p>
                                   <p>Ingredients: ";
                                        foreach ($ingredient_query as $ingredient){
                                            echo "$ingredient[ingredient_name], ";
                                        }
                                    echo "</p>
                                    
                                   <p>Employee: $employee_id</p>
                                   <input type='hidden' name='old_employee_ID' value='$employee_id' readonly>
                                </div>";
                                
                                if(!$tuple['employee_ID'] == NULL)	{
                               echo" <input type='submit' name='update' value='Finished!' onclick='document.location.href=\"QueueHandler.php\"'>
                                ";
                                }
                                echo"
                                </form>
                             </card-body>
                         </card>
                         ";
                         
                    
        }
        echo"</div>";

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


