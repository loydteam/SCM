<?php
//$Args;

//var_dump(User::$User);
?>

<center> 
    <h1>Edit File</h1><br/>

    <table style="width:30%">
        <tr>
            <td>


                <section class="edit-file-data">

                    <label for="file_name">file_name:<br/>
                        <input type="text" name="file_name" placeholder="file_name" value="<?php echo $f->file_name; ?>" required>
                        <label class="E"></label>
                    </label><br/>

                    <label for="description">Description:<br/>
                        <input type="text" name="description" placeholder="description" required>
                        <label class="E"></label>
                    </label><br/>      
 
                    <button type="button" class="edit-file-button">Edit</button>

                    <label for="id" style="visibility: hidden;">Id:<br/>
                        <input type="id" name="id" placeholder="id" value="<?php echo $f->id; ?>" required>
                        <label class="E"></label>
                    </label><br/> 
                </section>


            </td>
        </tr>
    </table>          

</center>