My Files:
<select class="my-files-list">
    <option value="0">---</option>
<?php 
    foreach ($Args['files'] as $val) {
        
        $selected = '';
        if ($this->Id_int == $val->id) {
            $selected = ' selected';
        }        
        echo '<option value="'.$val->id.'"'.$selected.'>'.$val->file_name.'</option>';
    }   
?>
 </select>