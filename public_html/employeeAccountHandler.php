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

try	{
    //open connection to db file
    $db = new PDO('sqlite:' . $db_file);

    //set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $first_name = $_POST["eFirstName"];
    $last_name = $_POST["eLastName"];
    $email = $_POST["eEmail"];
    $student_ID = $_POST["eStudent_ID"];
    $password = password_hash($_POST["ePassword"], PASSWORD_DEFAULT);
    if(isset($_POST["manager"])){
        $manager = true;
    }
    else{
        $manager = false;
    }
    $active = false;

    $student_str = "select * from student where student_ID=".$student_ID.";";
    $student_result = $db->query($student_str);
    foreach ($student_result as $student){
        $_SESSION["redirect"] = "username";
        header("Location: cellarRedirect.php");
    }

    $employee_ID = $student_ID;

    $insert_student = $db->prepare("insert into student values (:student_ID,:first_name,:last_name,:email,:password);");
    $insert_student->bindParam(':student_ID', $student_ID);
    $insert_student->bindParam(':first_name', $first_name);
    $insert_student->bindParam(':last_name', $last_name);
    $insert_student->bindParam(':email', $email);
    $insert_student->bindParam(':password', $password);
    $insert_student->execute();

    $insert_employee = $db->prepare("insert into employee values (:employee_ID,:manager,:active);");
    $insert_employee->bindParam(':employee_ID', $employee_ID);
    $insert_employee->bindParam(':manager', $manager);
    $insert_employee->bindParam(':active', $active);
    $insert_employee->execute();

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
    $mail->Subject = "Cellar Employee Verification";
    $mail->Body = "
        Hello. A new employee has just registered.
        First Name: ".$first_name."
        Last Name: ".$last_name."
        
        If this person is a real employee please verify their account using the link below:
        http://54.174.200.127/~ubuntu/verify?user=".$student_ID."&hash=".$password.".php
                        ";
    $mail->AddAddress("upscellarmanager@gmail.com");

    $mail->Send();

    header("Location: login.html");
}
catch	(PDOException $e)	{
    die('Exception : ' . $e->getMessage());
}
