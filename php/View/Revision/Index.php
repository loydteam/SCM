<?php
if (isset($Args['file']) && $Args['file']) {
    //var_dump($Args);
    $F = new F_Help();
    $PagesA = $F->NewPager($Args['Page'], $Args['Pages'], $Args['url'], $this->GETurl);
    ?>

<!--    <center>-->
        <h1>File Revisions:</h1><br/>

        File Name: <?php echo $Args['file']->file_name; ?><br/>
        File Description: <?php echo $Args['file']->description; ?><br/><br/>

        File Revisions Count: <?php echo $Args['Count']; ?><br/>
        Page: <?php echo $Args['Page']; ?> Pages: <?php echo $Args['Pages']; ?><br/>
        <?php echo $PagesA; ?>

        <br/><a href="/revision/NewFile/<?php echo $Args['file']->id; ?>/?i=<?php echo $Args['file']->id; ?>">New Version File</a><br/>
        <br/>

        <?php
        foreach ($Args['revision'] as $val) {
            ?>  

            
            <b class="green">Version:</b> <?php echo $val->version; ?><br/>
            <b class="green">Comments:</b> <?php echo $val->comments; ?><br/>
            <b class="green">Update Time:</b> <?php echo $val->update_time; ?><br/>            

            <div class="edit_files">
                <a href="/Revision/GetFile/<?php echo $val->id; ?>?i=<?php echo $Args['file']->id; ?>">Download File</a><br/>
                <a href="/Revision/GetFileInfo/<?php echo $val->id; ?>?i=<?php echo $Args['file']->id; ?>">Get File</a><br/>
                <a href="/Revision/FileEdit/<?php echo $val->id; ?>/?i=<?php echo $Args['file']->id; ?>">Edit File</a><br/>
<!--            <button class="revision-file-delete new-file-button" value="<?php echo $val->id; ?>">FileDelete</button>-->
            </div>
            
            <br/>
            <?php
        }
        ?>

        <?php echo $PagesA; ?>

<!--    </center>  -->

    <?php
}
?>

