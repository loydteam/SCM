<?php
//$Args;
//var_dump(User::$User);
?>

<center> 
    <h1>File Edit Properties:</h1><br/>

    <table style="width:30%">
        <tr>
            <td>

                <section class="edit-file-data">

                    <label for="error">
                        <label class="E"></label>
                    </label><br/>

                    <label for="file_name">File Name:<br/>
                        <input type="text" name="file_name" placeholder="file_name" value="<?php echo $Args->file_name; ?>" required>
                        <label class="E"></label>
                    </label><br/>

                    <label for="description">Description:<br/>
                        <textarea rows="10" cols="45" name="description"><?php echo $Args->description; ?></textarea>
                        <label class="E"></label>
                    </label><br/>      
                    
                    <button type="button" class="edit-file-button">Edit</button>

                    <label for="id" style="visibility: hidden;">id:<br/>
                        <input type="id" name="id" placeholder="id" value="<?php echo $Args->id; ?>" required>
                        <label class="E"></label>
                    </label><br/> 
                    
                </section>


            </td>
        </tr>
    </table>          

</center>