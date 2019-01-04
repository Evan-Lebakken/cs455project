<?php

	//path to the cellar DB
	$db_file = './myDB/cellar.db';
	$quantityErrMsg = "";
	
	//todo add error
	
	try	{
		//open connection to db file
		$db = new PDO('sqlite:' . $db_file);
		
		//set errormode to use exceptions
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$query_str = $db->prepare("update Stock set quantity = (:quantity) where ingredient_ID == (:old_ingredient_ID)");
		
		$query_str->bindValue(':quantity', $_POST['new_quantity']);
		$query_str->bindValue(':old_ingredient_ID', $_POST['ing_ID']);
		$result = $query_str->execute();
		
		$db = null;
		
	}
	catch	(PDOException $e)	{
		die('Exception : ' . $e->getMessage());
	}
	header("Location: viewIngredients.php");
			