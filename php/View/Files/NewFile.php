<?php
//$Args;
//var_dump(User::$User);
?>

<center> 
    <h1>New File</h1><br/>

    <table style="width:30%">
        <tr>
            <td>


                <section class="new-file-data">

                    <label for="error">
                        <label class="E"></label>
                    </label><br/>

                    <label for="file_name">File Name:<br/>
                        <input type="text" name="file_name" placeholder="enter file name" value="" required>
                        <label class="E"></label>
                    </label><br/>

                    <label for="description">Description:<br/>
                        <textarea rows="10" cols="45" name="description"></textarea>
                        <label class="E"></label>
                    </label><br/>      

                    <label for="File">File:
                        <input type="File" name="File" multiple />
                        <label class="E"></label>
                    </label><br/>

                    <label for="comments">Comments Revision:
                        <input type="text" name="comments" placeholder="comments" value="" required>
                        <label class="E"></label>
                    </label><br/>
                    
                    <button type="button" class="new-file-button">New</button>

                </section>


            </td>
        </tr>
    </table>          

</center>