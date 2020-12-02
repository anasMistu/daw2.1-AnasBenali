<?php
$contrseña=password_hash("f", PASSWORD_BCRYPT);

$tr=password_verify("m", $contrseña);
if($tr){
    print_r("hola");
}
    print_r($contrseña);
