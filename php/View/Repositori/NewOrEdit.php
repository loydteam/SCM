<?php

$Repositori = $Args['Repositori'];

?>

<section class="edit-repositori-data">

    <label for="Name">Name:<br/>
        <input type="text" name="Name" placeholder="Name" value="<?php echo $Repositori->Name; ?>" required>
        <label class="E"></label>
    </label><br/>

    <label for="Description">Description:<br/>
        <textarea rows="10" cols="45" name="Description"><?php echo $Repositori->Description; ?></textarea>
        <label class="E"></label>
    </label><br/>

    <button type="button" class="edit-categori-button">Edit</button>

    <label for="Id" style="visibility: hidden;">Id:<br/>
        <input type="Id" name="Id" placeholder="Id" value="<?php echo $Repositori->Id; ?>" required>
        <label class="E"></label>
    </label><br/> 
</section>