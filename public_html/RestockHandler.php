<?php
//path to the cellarDB
$db_file = './myDB/cellar.db';

//require("class.PHPMailer.php");


require("/home/ubuntu/public_html/Exception.php");
require("/home/ubuntu/public_html/SMTP.php");



try	{
    //open connection to db file
    $db = new PDO('sqlite:' . $db_file);

    //set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    $query_str = $db->prepare("update Stock set quantity = quantity + 100 where ingredient_ID = (:ingredient_ID)");

    $query_str->bindValue(':ingredient_ID', $_POST['old_ingredient_ID']);

    $result = $query_str->execute();
    $db = null;


    //$mail = new PHPMailer();

    //$mail->IsSMTP();
    //$mail->Host = "54.174.200.127";
    //$mail->SMTPAuth = "true";
    //$mail->Username = "ubuntu";
    //$mail->Password = "memes";

    //$mail->From = "900";
    //$mail->FromName = "Mailer";
    //$mail->AddAddress("wiggerpt@gmail.com");

    //$mail->Subject = "here is the subject";
    //$mail->Body = "YA YEET";

    //if(!$mail->Send())	{
    //	echo "dam";
    //}






}
catch(PDOException $e)	{
    die('Exception : ' . $e->getMessage());
}
header("Location: cellarStock.php");

?>