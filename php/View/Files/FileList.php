<?php
?>


<select class="file-list">
     <option  value="">Please select file</option>
<?php


foreach ($Args['data'] as $item) {
    
    
    ?>   
        <option  value="<?php echo $item->id; ?>" <?php echo $item->id==$Args['id']? 'selected':''; ?>>
        <?php echo $item->file_name; ?></option>
        <?php
    }
    ?>
</select>

