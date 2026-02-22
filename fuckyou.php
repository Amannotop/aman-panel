
<?php
$configtFilePath = '/home/botfiles/cheatbot/config.plist'; 

if (file_exists($configFilePath)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($configFilePath) . '"');
    header('Content-Length: ' . filesize($configFilePath));
    readfile($configFilePath);
} else {
    echo 'Antiban file not found.';
}
?>