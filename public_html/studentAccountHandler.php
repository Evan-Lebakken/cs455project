<?php

//path to the cellar DB
$db_file = './myDB/cellar.db';
$quantityErrMsg = "";
try	{
    //open connection to db file
    $db = new PDO('sqlite:' . $db_file);

    //set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $first_name = $_POST["sFirstName"];
    $last_name = $_POST["sLastName"];
    $email = $_POST["sEmail"];
    $student_ID = $_POST["sStudent_ID"];
    $password = password_hash($_POST["sPassword"], PASSWORD_DEFAULT);

    $student_str = "select * from student where student_ID=".$student_ID.";";
    $student_result = $db->query($student_str);

    foreach ($student_result as $student){
        $_SESSION["redirect"] = "username";
        header("Location: cellarRedirect.php");
    }

    $insert_student = $db->prepare("insert into student values (:student_ID,:first_name,:last_name,:email,:password);");
    $insert_student->bindParam(':student_ID', $student_ID);
    $insert_student->bindParam(':first_name', $first_name);
    $insert_student->bindParam(':last_name', $last_name);
    $insert_student->bindParam(':email', $email);
    $insert_student->bindParam(':password', $password);
    $insert_student->execute();

    header("Location: login.html");
}
catch	(PDOException $e)	{
    die('Exception : ' . $e->getMessage() . " Line: " . $e->getLine());
}
