<?php
//$Args;
//var_dump(User::$User);
?>

<center> 
    <h1>New Version File</h1><br/>

    <table style="width:30%">
        <tr>
            <td>


                <section class="new-version-file-data">

                    <label for="error">
                        <label class="E"></label>
                    </label><br/>

                    <label for="File">File:
                        <input type="File" name="File" multiple />
                        <label class="E"></label>
                    </label><br/>

                    <label for="comments">Comments:
                        <input type="text" name="comments" placeholder="comments" value="" required>
                        <label class="E"></label>
                    </label><br/>
                                        
                    <button type="button" class="new-version-file-button">New</button>

                    <label for="id" style="visibility: hidden;">id:<br/>
                        <input type="text" name="id" placeholder="id" value="<?php echo $Args->id; ?>" required>
                        <label class="E"></label>
                    </label><br/> 
                    
                </section>


            </td>
        </tr>
    </table>          

</center>