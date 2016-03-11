<?php



if (isset($Args['files']) && $Args['files']) {
    
?>
  
dsfsdf dfsdf 


<?php
} else if (isset($_SESSION['Id'])) {
    ?>    


    <center>
        Files

        <br/><a href="/Files/NewOrEdit/">New File</a><br/>
        <br/>No File
    </center>    


    <?php
} else {
    ?>   
    <center><h3>
            Please login in scm
        </h3>
    </center>

    <?php
}
?>

