<?php

namespace App\Controllers;

class UploadController
{
    public function uploadFile(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $file = $_FILES['file'];
            $targetDir = __DIR__ . '/../../public_html/uploads/';
            $newFileName = uniqid() . '-' . basename($file['name']);
            $targetFile = $targetDir . $newFileName;

            // Allowed image extensions
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = mime_content_type($file['tmp_name']);

            if (!in_array($fileType, $allowedTypes)) {
                echo 'Invalid file type. Only JPEG, PNG, and GIF images are allowed.';
                return;
            }

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                echo 'File uploaded successfully';
                echo $targetFile;
            } else {
                echo 'Failed to upload file.';
            }
        }
    }
}
