<?php

echo "
<form action ='feedbackForm.php' method='post'>
<input type='text' name='buforderid' value='echo $_GET['orderid']' readonly>
<input type='text' name='bufempid' value='<?php echo $_GET['empid'] ?>' readonly>";

header("Location: feedbackForm.php");

?>






