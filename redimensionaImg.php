<?php
function resize($image_path, $filename) {

    header('Content-Type: image/jpeg');
    $thumb = imagecreatetruecolor(350, 350);
    $source = imagecreatefromjpeg($image_path);

    list($width, $height) = getimagesize($image_path);

    imagecopyresized($thumb, $source, 0, 0, 0, 0, 350, 350, $width, $height);

    imagejpeg($thumb, $filename.".jpg",90);
}
?>