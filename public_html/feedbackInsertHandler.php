<?php

		//path to db
		$db_file = './myDB/cellar.db';
		
		try	{
			$db = new PDO('sqlite:' . $db_file);
			
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$query_str = $db->prepare("insert into Feedback 
			values(:order_ID, :employee_ID, :feedback_text, 
			:rating);");
			$query_str->bindParam(':order_ID',$_POST['orderid']);
			$query_str->bindParam(':employee_ID',$_POST['empid']);
			$query_str->bindParam(':feedback_text',$_POST['feedbacktxt']);
			$query_str->bindParam(':rating',$_POST['r']);
			$query_str->execute();
			$db = null;
			header("Location: cellarMock.php");
			
			}
		catch(PDOException $e)	{
			die('Exception : '.$e->getMessage());
		}	
			
?>			