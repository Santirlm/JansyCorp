<?php

namespace dwes\app\utils;

use dwes\app\exceptions\FileException;

class File
{
    private array  $file;
    private string $fileName = '';

    public function __construct(string $fieldName, array $allowedTypes)
    {
        if (!isset($_FILES[$fieldName])) {
            throw new FileException("No se ha encontrado el fichero en el formulario");
        }

        $this->file = $_FILES[$fieldName];

        if ($this->file['error'] !== UPLOAD_ERR_OK) {
            match ($this->file['error']) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => throw new FileException("El fichero es demasiado grande"),
                UPLOAD_ERR_PARTIAL => throw new FileException("El fichero no se subió completamente"),
                default            => throw new FileException("Error al subir el fichero"),
            };
        }

        if (!in_array($this->file['type'], $allowedTypes)) {
            throw new FileException("Tipo de fichero no permitido: " . $this->file['type']);
        }
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function saveUploadFile(string $destPath): void
    {
        if (!is_uploaded_file($this->file['tmp_name'])) {
            throw new FileException("El archivo no fue subido mediante formulario");
        }

        $this->fileName = $this->file['name'];
        $ruta = $destPath . $this->fileName;

        if (file_exists($ruta)) {
            $this->fileName = time() . '_' . $this->fileName;
            $ruta = $destPath . $this->fileName;
        }

        if (!move_uploaded_file($this->file['tmp_name'], $ruta)) {
            throw new FileException("No se pudo mover el fichero al destino");
        }
    }

    public function copyFile(string $srcPath, string $destPath): void
    {
        $origen  = $srcPath . $this->fileName;
        $destino = $destPath . 'miniatura_' . $this->fileName;

        if (!file_exists($origen)) throw new FileException("El fichero origen no existe");
        if (file_exists($destino)) throw new FileException("El fichero destino ya existe");
        if (!copy($origen, $destino))  throw new FileException("No se pudo copiar el fichero");
    }
}
