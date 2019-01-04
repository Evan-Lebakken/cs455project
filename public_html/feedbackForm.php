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


<?php   if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_GET['get'] == 'true'){
            echo "<form action = \"feedbackInsertHandler.php\" method=\"post\" >";
        }
?>
<div class='mx-4'>
		
		<form action='feedbackInsertHandler.php' method='post'>

		<h3 class='my-3'>Order ID: <input style='border:none' type='text' name='orderid' value='<?php echo $_GET['orderid']  ?>' readonly></h3>
		<h3 class='my-3'>Employee ID: <input style='border:none' type='text' name='empid' value='<?php echo $_GET['empid']  ?>' readonly></h3>
		
		
 
		<h3 class='my-3'>Give Comments on your Order:</h3>

		<input type='text' name='feedbacktxt'>
		
		<h3 class='my-3'>Give a Rating for your Order:</h3>
		<input type='radio' name='r' value='1'> 1<br>
		<input type='radio' name='r' value='2'> 2<br>
		<input type='radio' name='r' value='3'> 3<br>
		<input type='radio' name='r' value='4'> 4<br>
		<input type='radio' name='r' value='5'> 5<br><br>
		
		<input type='submit' value='Submit Feedback' onclick=\"document.location.href=\"feedbackInsertHandler.php\";\"/>

    
    	<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'|| $_GET['get'] == 'true'){
        	echo "<input type='submit' value='Submit' onclick=\"document.location.href=\"feedbackInsertHandler.php\";\"/>";
    	} 
    	?>
</div>  
    
</form>
</body>
</html>