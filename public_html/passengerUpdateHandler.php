<?php
        //path to the SQLite database file
        $db_file = './myDB/airport.db';
        $ssnErrMsg = "";
        $fNameErrMsg = "";
        $lNameErrMsg = "";
        if(!preg_match("(^\d{3}-?\d{2}-?\d{4}$)", $_POST['ssn'])){
            $ssnErrMsg="Input must be of the form 000-00-0000";
        }
        if(preg_match("(\d)", $_POST['f_name'])){
            $fNameErrMsg="no numbers in names";
        }
        if(preg_match("(\d)", $_POST['l_name'])){
        $lNameErrMsg="no numbers in names";
        }
        if($ssnErrMsg == "" && $fNameErrMsg == "" && $lNameErrMsg == "") {
            try {
                //open connection to the airport database file
                $db = new PDO('sqlite:' . $db_file);

                //set errormode to use exceptions
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //return all passengers, and store the result set
                $query_str = $db->prepare("update passengers 
                                                        set f_name = (:fName),
                                                            m_name = (:mName),
                                                            l_name = (:lName),
                                                            ssn = (:ssn)  
                                                        where
                                                            ssn == (:old_ssn)");
                //var_dump($query_str);
                $query_str->bindValue(':fName', $_POST['f_name']);
                $query_str->bindValue(':mName', $_POST['m_name']);
                $query_str->bindValue(':lName', $_POST['l_name']);
                $query_str->bindValue(':ssn', $_POST['ssn']);
                $query_str->bindValue(':old_ssn', $_POST['old_ssn']);
                $result = $query_str->execute();

                //disconnect from db
                $db = null;

            } catch (PDOException $e) {
                die('Exception : ' . $e->getMessage());
            }
            header("Location: showPassengers.php");
        }else {
            header("Location: passengerForm.php?get=true&fNameError=$fNameErrMsg&lNameError=$lNameErrMsg&ssnError=$ssnErrMsg");
        }
?>