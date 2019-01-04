<?php
session_start();
//path to the cellarDB
$db_file = './myDB/cellar.db';

require("/home/ubuntu/public_html/Exception.php");

try	{
    //open connection to db file
    $db = new PDO('sqlite:' . $db_file);

    //set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $employee_ID = $_SESSION["user_ID"];
    $query_str = $db->prepare("update Queue set employee_ID = $employee_ID where order_ID = (:order_ID)");

    $query_str->bindValue(':order_ID', $_POST['old_order_ID']);

    $result = $query_str->execute();
    $db = null;



}
catch(PDOException $e)	{
    die('Exception : ' . $e->getMessage());
}
header("Location: cellarOrderCards.php");

?>