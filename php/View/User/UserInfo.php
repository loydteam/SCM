<?php
    $user = User::$User;  
?>

<b><?php echo $user->FirstName ?></b>
<b><?php echo $user->LastName ?></b>
<br/>
<b>User Id: <?php echo $user->Id ?></b>
<br/>
<input id="logout-button" class="button" type="submit" value="logout" />