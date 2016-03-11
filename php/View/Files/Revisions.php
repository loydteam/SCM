 <?php
 
 
                        ControllerPartial::Get('Files/FileList/'.$Args['id']);
                        var_dump($Args['data']);
                        
                        
                        
                        
                        ?>

<select multiple="">
    
<?php


foreach ($Args['data'] as $item) {
    
    
    ?>   
        <option  value="<?php echo $item->id; ?>" >
        <?php echo $item->version; ?></option>
        <?php
    }
    ?>
</select>