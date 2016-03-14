<?php
//$Args;
//var_dump(User::$User);
?>

<center> 
    <h1>Edit File</h1><br/>

    <table style="width:30%">
        <tr>
            <td>


                <section class="revision-file-edit-data">

                    <label for="error">
                        <label class="E"></label>
                    </label><br/>

                    <label for="file">File:<br/>
                        <textarea rows="10" cols="45" name="file"><?php echo $Args['FileData']; ?></textarea>
                        <label class="E"></label>
                    </label><br/>      
                    
                    <label for="comments">Comments:
                        <input type="text" name="comments" placeholder="comments" value="<?php echo $Args['comments']; ?>" required>
                        <label class="E"></label>
                    </label><br/>
                    
                    <button type="button" class="revision-file-edit-button new-file-button">Edit</button>

                    <label for="id" style="visibility: hidden;">id:<br/>
                        <input type="text" name="id" placeholder="id" value="<?php echo $Args['id']; ?>" required>
                        <label class="E"></label>
                    </label><br/>                    
                    
                    <label for="file_id" style="visibility: hidden;">file_id:<br/>
                        <input type="text" name="file_id" placeholder="file_id" value="<?php echo $Args['file_id']; ?>" required>
                        <label class="E"></label>
                    </label><br/>   
                    
                </section>

            </td>
        </tr>
    </table>          

</center>

