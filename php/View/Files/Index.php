<?php
if (isset($Args['files']) && $Args['files']) {

    $F = new F_Help();
    $PagesA = $F->NewPager($Args['Page'], $Args['Pages'], $Args['url']);
    ?>

<!--    <center>-->
        <h1>Files</h1>
        Files Count: <?php echo $Args['Count']; ?><br/>
        Page: <?php echo $Args['Page']; ?> Pages: <?php echo $Args['Pages']; ?><br/>
        

        <br/><a href="/Files/NewFile/">New File</a><br/>
        <br/>

        <?php
        foreach ($Args['files'] as $val) {
            ?>  

            <b class="green">Name:</b> <?php echo $val->file_name; ?><br/>
            <b class="green">Description:</b> <?php echo $val->description; ?><br/>
            <a href="/Revision/Index/<?php echo $val->id; ?>?i=<?php echo $val->id; ?>">Get All Revision File</a><br/>
            <a href="/Files/FileEdit/<?php echo $val->id; ?>">Edit File Properties</a><br/>
<!--            <button class="files-files-delete" value="<?php echo $val->id; ?>">Delete</button>-->
            <br/>
            <?php
        }
        ?>
            
        <?php echo $PagesA; ?>
            
<!--    </center>  -->

    <?php
} else if ($this->UserId) {
    ?>    


    <center>
        Files

        <br/><a href="/Files/NewFile/">New File</a><br/>
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

