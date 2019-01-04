<?php
/**
// * Created by PhpStorm.
// * User: Nalinpr
// * Date: 10/18/2018
// * Time: 8:31 PM
// * @param $delimiters
// * @param $string
// * @return array
// */

function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

//path to the SQLite database file
$db_file = './myDB/cellar.db';

    try {
        //open connection to the airport database file
        $db = new PDO('sqlite:' . $db_file);

        //set errormode to use exceptions
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //return all passengers, and store the result set
        $query_str = $_POST["sql_statement"];
        $lower_query_str = strtolower($query_str);
        $query_array = multiexplode(array(" ",",",";"),$lower_query_str);

        $start_index;
        $end_index;
        for ($i = 0; $i < count($query_array); $i++) {
            if ($query_array[$i] == "select") $start_index = $i+1;
            if ($query_array[$i] == "from") {
                $end_index = $i;
                break;
            }
        }
        $attribute_list = array_slice($query_array, $start_index, $end_index-$start_index);
        //parse query

//        var_dump($query_str);
        $result_set = $db->query($query_str);


//        foreach ($result_set as $tuple) {
//            var_dump($tuple);
//            echo "\n";
//            $string = "";
//            foreach ($tuple as $entry) {
//                $string .= "$entry ";
//            }
//            echo "$string<br>\n";
//        }

        if (in_array('*', $attribute_list)) {
            foreach($result_set as $tuple) {
                $no_dup_tuple = array_unique($tuple);
                $string = "";
                foreach ($no_dup_tuple as $entry) {
                    $string .= "$entry ";
                }
                $string .= "<br>";
                echo "$string ";
            }
        } else {
            foreach($result_set as $tuple) {
                $string = "";
                for ($i = 0; $i < count($attribute_list); $i++) {
                    $string .= "$tuple[$i] ";
                }
                $string .= "<br>\n";
                echo "$string ";
            }
        }

        //disconnect from db
        $db = null;
    }
    catch(PDOException $e) {
        die('Exception : '.$e->getMessage());
    }
