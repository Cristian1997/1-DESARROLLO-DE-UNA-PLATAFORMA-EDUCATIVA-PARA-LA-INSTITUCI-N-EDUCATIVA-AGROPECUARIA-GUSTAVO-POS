<?php
// Ver el ejemplo de password_hash() para ver de dónde viene este hash.
$hash = '123456';

if (password_verify('123456', $hash)) {
    echo '¡La contraseña es válida!';
} else {
    echo 'La contraseña no es válida.';
}
?>