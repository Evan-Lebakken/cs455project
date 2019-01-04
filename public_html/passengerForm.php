<html>
<head>
    <meta charset="UTF-8">
    <title>Passenger form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php   if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_GET['get'] == 'true'){
            echo "<form action = \"passengerUpdateHandler.php\" method=\"post\" >";
        }
        else {
            echo "<form action = \"passengerInsertHandler.php\" method=\"post\" >";
        }
?>
    <table>
        <col width="130">
        <col width="80">
        <tr>
            <th>Social:</th>
            <td><input type="text" name="ssn" value="<?php echo $_POST["old_ssn"];?>" required><?php echo"$_GET[ssnError]" ?> </td>
        </tr>
        <tr>
            <th>First name:</th>
            <td><input type="text" name="f_name" value="<?php echo $_POST["old_fName"];?>" required><?php echo"$_GET[fNameError]" ?></td>
        </tr>
        <tr>
            <th>Middle name:</th>
            <td><input type="text" name="m_name" value="<?php echo $_POST["old_mName"];?>"></td>
        </tr>
        <tr>
            <th>Last name:</th>
            <td><input type="text" name="l_name" value="<?php echo $_POST["old_lName"];?>" required><?php echo"$_GET[lNameError]" ?></td>
        </tr>
    </table>
    <input type="hidden" name="old_ssn" value="<?php echo $_POST["old_ssn"];?>">
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'|| $_GET['get'] == 'true'){
        echo "<input type='submit' value='update!' onclick=\"document.location.href=\"showPassengers.php\";\"/>";
    } else{
        echo "<input type='submit' value='submit!' onclick=\"document.location.href=\"showPassengers.php\";\"/>";
    } ?>
</form>
</body>
</html>