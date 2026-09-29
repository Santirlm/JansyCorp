<?php
function dibujarCodigo(GdImage $imagen, int $color, string $codigo): void
{
    $font   = 5;
    $letras = str_split($codigo);
    $posX   = 15;
    $posY   = 20;

    foreach ($letras as $letra) {
        imagestring($imagen, $font, $posX, $posY, $letra, $color);
        $posX += 30;
        $posY += 12;
        imageline($imagen, 10, 10, $posX + 25, $posY + 60, $color);
    }
}

$codigo = $_GET['codigo'] ?? 'error';
$alto   = 200;
$ancho  = 280;

$imagen = imagecreatetruecolor($ancho, $alto);
$blanco = imagecolorallocate($imagen, 255, 255, 255);
$azul   = imagecolorallocate($imagen,   0,   0,  64);

imagefilledrectangle($imagen, 0, 0, $ancho, $alto, $azul);

dibujarCodigo($imagen, $blanco, $codigo);

header('Content-Type: image/png');
header('Cache-Control: no-store, no-cache');
imagepng($imagen);
imagedestroy($imagen);