<?php
    //path to the SQLite database file
    $db_file = './myDB/airport.db';
    $ssnErrMsg = "";
    if(!preg_match("(^\d{3}-?\d{2}-?\d{4}$)", $_POST['ssn'])){
        $ssnErrMsg="Input must be of the form 000-00-0000";
    }
    if(preg_match("(\d)", $_POST['f_name'])){
        $fNameErrMsg="no numbers in names";
    }
    if(preg_match("(\d)", $_POST['l_name'])){
        $lNameErrMsg="no numbers in names";
    }
    if($ssnErrMsg == "" && $fNameErrMsg == "" && $lNameErrMsg == ""){
        try {
            //open connection to the airport database file
            $db = new PDO('sqlite:' . $db_file);

            //set errormode to use exceptions
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //return all passengers, and store the result set
            //echo "$_POST[f_name]";
            $query_str = $db->prepare("insert into passengers values(:fName,:mName,:lName,:ssn);");
            $query_str->bindParam(':fName', $_POST['f_name']);
            $query_str->bindParam(':mName',$_POST['m_name']);
            $query_str->bindParam(':lName',$_POST['l_name']);
            $query_str->bindParam(':ssn',$_POST['ssn']);
            $query_str->execute();
            //disconnect from db
            $db = null;
            header("Location: showPassengers.php?status=success!");
        }
        catch(PDOException $e) {
            die('Exception : '.$e->getMessage());
        }
    } else {
        header("Location: passengerForm.php?get=false&fNameError=$fNameErrMsg&lNameError=$lNameErrMsg&ssnError=$ssnErrMsg");
    }

?>