<?php

//path to the cellar DB
$db_file = './myDB/cellar.db';
$quantityErrMsg = "";

session_start();


try {
    //open connection to db file
    $db = new PDO('sqlite:' . $db_file);

    //set errormode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    $_SESSION["redirect"] = "no_user";

    $student_ID = $_POST["student_ID"];
    $password = $_POST["password"];
    $student_str = "select * from student where student_ID=" . $student_ID . ";";
    $student_result = $db->query($student_str);
    $result = false;
    foreach ($student_result as $student) {
        $result = true;
        if (isset($student["student_ID"])){
            $this_pass = trim($student["password"]);
            if (password_verify($password, $this_pass)) {

                $_SESSION["user"] = "student";
                $_SESSION["user_ID"] = $student_ID;
                $_SESSION["email"] = $student["email"];

                $employee_str = "select * from employee where employee_ID=" . $student_ID . ";";
                $employee_result = $db->query($employee_str);
                foreach ($employee_result as $employee) {
                    if (isset($employee["employee_ID"])) {

                        $_SESSION["user"] = "employee";
                        if ($employee["manager"] == true){
                            $_SESSION["manager_access"] = true;
                        }

                        if ($employee["active"] == true){
                            $_SESSION["employee_access"] = true;
                        }

                    }
                }

                header("Location: loggedIn.php");
            }
            else {
                $_SESSION["redirect"] = "wrong_pass";
                header("Location: cellarRedirect.php");
            }
        }
    }
    if (!$result){
        $_SESSION["redirect"] = "no_user";
        header("Location: cellarRedirect.php");
    }
}
catch (PDOException $e)	{
    die('Exception : ' . $e->getMessage() . $e->getLine());
}



//    header("Location: login.html");
