<?php

//path to the cellar DB
$db_file = './myDB/cellar.db';
$quantityErrMsg = "";
session_start();

require("/home/ubuntu/public_html/PHPMailer.php");
require("/home/ubuntu/public_html/Exception.php");
require("/home/ubuntu/public_html/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

try {
    //open connection to db file
    $db = new PDO('sqlite:' . $db_file);

    //set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $user_ID = $_GET["user"];
    $true = 1;

    $student_str = "select * from student where student_ID=" . $user_ID . ";";
    $student_result = $db->query($student_str);
    foreach ($student_result as $student) {
        if (isset($student["student_ID"])) {
            $query_str = $db->prepare("update employee set active = (:active) where employee_ID == (:employee_ID);");
            $query_str->bindParam(':active', $true);
            $query_str->bindParam(':employee_ID', $student["student_ID"]);
            $query_str->execute();

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
            $mail->Subject = "Cellar Employee Account";
            $mail->Body = "Your account has been verified";
            $mail->AddAddress($student["email"]);

            $mail->Send();
        }
    }
    header("Location: cellarMock.php");
}
catch (PDOException $e)	{
    die('Exception : ' . $e->getMessage() . ' Line: '. $e->getTraceAsString());
}



