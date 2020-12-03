<?php
$contrseña=password_hash("m", PASSWORD_BCRYPT);

$tr=password_verify("n", $contrseña);
if($tr){
    print_r("hola");
}else{
    print_r($contrseña);

}
