<?php

	session_start();

	//path to the cellarDB
	$db_file = './myDB/cellar.db';
	
	//require("class.PHPMailer.php");
	
	require("/home/ubuntu/public_html/PHPMailer.php");
	require("/home/ubuntu/public_html/Exception.php");
	require("/home/ubuntu/public_html/SMTP.php");

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	
	$currentemail = $_SESSION["email"];
		
	$mail = new PHPMailer();
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465;
	$mail->IsHTML(true);
	$mail->Username = "pizzarobot2000@gmail.com";
	$mail->Password = "cellarbot123";
	$mail->SetFrom("pizzarobot2000@gmail.com");
	$mail->Subject = "Your Order is Ready!";
	$mail->Body = "Please give feedback on your order: 
	http://54.174.200.127/~ubuntu/feedbackForm.php?orderid=" . $_POST['old_order_ID'] . "&empid=" . $_POST['old_employee_ID'];
	$mail->AddAddress($currentemail);
	
	$mail->Send();
	
	
	try	{
		//open connection to db file
		$db = new PDO('sqlite:' . $db_file);
		
		//set errormode to use exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
		
		$query_str = $db->prepare("delete from Queue where order_ID = (:order_ID)");

		$query_str->bindValue(':order_ID', $_POST['old_order_ID']);
		
		$result = $query_str->execute();
		$db = null;
		
	}
	catch(PDOException $e)	{
		die('Exception : ' . $e->getMessage());
	}	 
	header("Location: cellarOrderCards.php");
	
?>	