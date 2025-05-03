<?php
$file = '/var/www/html/kcet_project/db.php';
if (is_writable($file)) {
    echo 'File is writable';
} else {
    echo 'File is not writable';
}
?>
