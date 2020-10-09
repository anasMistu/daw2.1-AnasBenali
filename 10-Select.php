<?php
$ciudades = array("Barcelona", "Madrid", "Shenzen", "Valencia", "Malaga", "Las Vegas", "Los Angelos");
$limite= count($ciudades);
?>
<!DOCTYPE html>
<html>
<body>
<label for="ciudades">Elige una ciudad:</label>
<select name="<?=$ciudades?>">
    <?php
    for($i=0;$i<$limite;$i++){?>
        <option value="<?=$i;?>"><?=$ciudades[$i];?></option>
        <?php
    }
    ?>
</select>
</body>
</html>