<?php
//var_dump($Args);
?>

<select>
<?php


foreach ($Args as $item) {
    
    var_dump($item->id);
    ?>   
        <option value="<?php echo $item->id; ?>">
        <?php echo $item->file_name; ?></option>
        <?php
    }
    ?>
</select>


