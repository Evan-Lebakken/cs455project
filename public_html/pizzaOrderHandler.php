<?php
$db_file = './myDB/cellar.db';
session_start();
try {
    $db = new PDO('sqlite:' . $db_file);

    //set errorMode to use exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $orderType = $_POST["orderType"];
    $user_ID = $_SESSION["user_ID"];
    if($orderType == "customMenuOrder" || $orderType == "customOrder"){
        $ingredient_IDs = $_POST["ingredient_IDs"];
        $ingredient_IDs = array_diff($ingredient_IDs,["(none)"]);
        //var_dump($ingredient_IDs);
        if(count($ingredient_IDs) == 0){
            header("Location: orderForm.php?error='Pizza must contain at least 1 ingredient!'");
        }
    }
    
    //var_dump($_POST);
    if($orderType == "menuOrder"){
        $max_order_ID_str = "SELECT MAX(order_ID) FROM Order_form;";
        $max_order_ids = $db->query($max_order_ID_str);
        $max_order_ID;
        foreach ($max_order_ids as $ID){
            $max_order_ID = $ID["MAX(order_ID)"];
        }
        $max_order_ID+=1;
        $item_ID = $_POST["item_ID"];
        $size = $_POST["size"];
        $insertOrderMenuItemStatement="INSERT INTO Order_form (order_ID, student_ID, item_ID, size) VALUES(".$max_order_ID.", ".$user_ID.", ".$item_ID.", '".$size."');";
        $db->query($insertOrderMenuItemStatement);

    }
    else if($orderType == "customMenuOrder"){
        $item_ID = $_POST["item_ID"];
        $item_ID = $item_ID+1;

        $max_order_ID_str = "SELECT MAX(order_ID) FROM Order_form;";
        $max_order_ids = $db->query($max_order_ID_str);
        $max_order_ID;
        foreach ($max_order_ids as $ID){
            $max_order_ID = $ID["MAX(order_ID)"];
        }
        $max_order_ID+=1;
        $size = $_POST["size"];
        $insert_into_orderQueue = "INSERT INTO Order_form (order_ID, student_ID, item_ID, size) VALUES (".$max_order_ID.", ".$user_ID.", ".$item_ID.", '".$size."');";
        //echo "$insert_into_orderQueue";
        $db->query($insert_into_orderQueue);
        //$ingredient_IDs = $_POST["ingredient_IDs"];

        $item_time = $_POST["item_Time"];
        //echo"$item_time";
        $insert_into_menu = "INSERT INTO Menu VALUES(".$item_ID.", "."'Custom item #".$item_ID."', ".$item_time.");";
        //echo"$insert_into_menu";
        $db->query($insert_into_menu);

        foreach( $ingredient_IDs as $ingredient_ID){
            $insert_into_menuItem = "INSERT INTO Menu_ingredient VALUES(".$item_ID.", ".$ingredient_ID.");";
            $db->query($insert_into_menuItem);
        }
    }
    else if($orderType == "customOrder"){

        $max_order_ID_str = "SELECT MAX(order_ID) FROM Order_form;";
        $max_order_ids = $db->query($max_order_ID_str);
        $max_order_ID;
        foreach ($max_order_ids as $ID){
            $max_order_ID = $ID["MAX(order_ID)"];
        }
        $max_order_ID+=1;
//        echo"$max_order_ID";
        $max_item_ID_str = "SELECT MAX(item_ID) FROM Menu;";
        $max_item_ids = $db->query($max_item_ID_str);
        $max_item_ID = "";
        foreach ($max_item_ids as $ID){
            $max_item_ID = $ID["MAX(item_ID)"];
        }
        $max_item_ID+=1;
        $size = $_POST["size"];
        $insertCustomOrder = "INSERT INTO Order_form (order_ID, student_ID, item_ID, size) VALUES(".$max_order_ID.", ".$user_ID.",".$max_item_ID.", '".$size."');";
        $db->query($insertCustomOrder);
        $insert_into_menu = "INSERT INTO MENU VALUES(".$max_item_ID.", "."'Custom item #".$max_item_ID."', 10);";
        $db->query($insert_into_menu);
        foreach( $ingredient_IDs as $ingredient_ID){
            $insert_into_menuItem = "INSERT INTO Menu_ingredient VALUES(".$max_item_ID.", ".$ingredient_ID.");";
            $db->query($insert_into_menuItem);
        }
    }else if($orderType == "feelingLucky"){
        $max_order_ID_str = "SELECT MAX(order_ID), MIN(order_ID) FROM Order_form;";
        $max_order_ids = $db->query($max_order_ID_str);
        $max_order_ID;
        $min_order_ID;
        foreach ($max_order_ids as $ID){
            $max_order_ID = $ID["MAX(order_ID)"];
            $min_order_ID = $ID["MIN(order_ID"];
        }
        $luckyOrder_ID = rand($min_order_ID, $max_order_ID);
        $getLuckyOrder = "SELECT * FROM Order_form WHERE order_ID = ".$luckyOrder_ID.";";
        $luckyOrder = $db->query($getLuckyOrder);
        $itemID;
        $size;
        foreach ($luckyOrder as $result){
            $itemID = $result["item_ID"];
            $size = $result["size"];
        }
        $max_order_ID+=1;
        $insertLuckyOrder = "INSERT INTO Order_form (order_ID, student_ID, item_ID, size) VALUES(".$max_order_ID.", ".$user_ID.", ".$itemID.", '".$size."');";
        //echo"$insertLuckyOrder";
        $db->query($insertLuckyOrder);

    }
    else if($orderType == "orderAsGuest"){
        $max_order_ID_str = "SELECT MAX(order_ID) FROM Order_form;";
        $max_order_ids = $db->query($max_order_ID_str);
        $max_order_ID;
        foreach ($max_order_ids as $ID){
            $max_order_ID = $ID["MAX(order_ID)"];
        }
        $max_order_ID+=1;
        $item_ID = $_POST["item_ID"];
        $size = $_POST["size"];
        $insertOrderMenuItemStatement="INSERT INTO Order_form (order_ID, student_ID, item_ID, size) VALUES(".$max_order_ID.", 1, ".$item_ID.", '".$size."');";
        $db->query($insertOrderMenuItemStatement);
    }
    else if($orderType == "reOrder"){
        $max_order_ID_str = "SELECT MAX(order_ID) FROM Order_form;";
        $max_order_ids = $db->query($max_order_ID_str);
        $max_order_ID;
        foreach ($max_order_ids as $ID){
            $max_order_ID = $ID["MAX(order_ID)"];
        }
        $max_order_ID+=1;
        $getPastOrder = "SELECT * FROM Order_form WHERE order_ID = ".$_POST["order_ID"].";";
        $pastOrder = $db->query($getPastOrder);
        $itemID;
        $size;
        foreach ($pastOrder as $result){
            $itemID = $result["item_ID"];
            $size = $result["size"];
        }
        $insertOrderMenuItemStatement="INSERT INTO Order_form (order_ID, student_ID, item_ID, size) VALUES(".$max_order_ID.", ".$user_ID.", ".$itemID.", '".$size."');";
        $db->query($insertOrderMenuItemStatement);
    }

    //open connection to cellar db

    //return all menu items and store result


    header("Location: orderSuccess.php");
    }
    catch (PDOException $e){
//        echo "'.$max_order_ID.', '.$user_ID', '.$itemID.', '.$size.'";
        die('Exception : '.$e->getMessage() . " line: ". $e->getTraceAsString());
    }
    $db = null;

    header("Location: orderSuccess.php");

?>