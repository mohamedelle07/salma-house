<?php

class Uploader
{
    private string $uploadDir;

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
    }

    public function upload(array $file): string
    {
        if (empty($file['name'])) {
            return "";
        }

        $fileName = time() . "_" . basename($file['name']);
        $targetPath = $this->uploadDir . $fileName;

        move_uploaded_file($file['tmp_name'], $targetPath);

        return $fileName;
    }
}