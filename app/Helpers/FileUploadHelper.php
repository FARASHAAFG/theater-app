<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Helpers\Core\Result;
use Exception;
use Psr\Http\Message\UploadedFileInterface;

class FileUploadHelper
{
    public static function upload(UploadedFileInterface $uploadedFile, array $config): Result
    {
        $directory = $config['directory'] ?? null;
        $allowedTypes = $config['allowedTypes'] ?? [];
        $maxSize = (int) ($config['maxSize'] ?? 0);
        $filenamePrefix = $config['filenamePrefix'] ?? 'upload_';

        if (empty($directory)) {
            return Result::failure('Upload directory not specified in configuration');
        }

        if (empty($allowedTypes)) {
            return Result::failure('Allowed file types not specified in configuration');
        }

        if ($maxSize <= 0) {
            return Result::failure('Maximum file size not specified in configuration');
        }

        $uploadError = $uploadedFile->getError();
        if ($uploadError !== UPLOAD_ERR_OK) {
            return Result::failure(self::uploadErrorMessage($uploadError));
        }

        $size = $uploadedFile->getSize();
        if ($size !== null && $size > $maxSize) {
            $maxMb = round($maxSize / (1024 * 1024), 1);

            return Result::failure("File is too large (maximum {$maxMb} MB).");
        }

        $mimeType = $uploadedFile->getClientMediaType();
        if ($mimeType === null || !in_array($mimeType, $allowedTypes, true)) {
            return Result::failure('File type is not allowed. Use JPEG, PNG, GIF, or WebP.');
        }

        $clientName = $uploadedFile->getClientFilename() ?? 'image';
        $extension = strtolower(pathinfo($clientName, PATHINFO_EXTENSION));
        if ($extension === '') {
            $extension = match ($mimeType) {
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
                default => 'jpg',
            };
        }

        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            return Result::failure('Could not create the upload directory.');
        }

        $filename = uniqid($filenamePrefix, true) . '.' . $extension;
        $destination = $directory . DIRECTORY_SEPARATOR . $filename;

        try {
            $uploadedFile->moveTo($destination);
        } catch (Exception $e) {
            return Result::failure('Failed to save uploaded file: ' . $e->getMessage());
        }

        return Result::success('File uploaded successfully', [
            'filename' => $filename,
        ]);
    }

    private static function uploadErrorMessage(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the maximum allowed size.',
            UPLOAD_ERR_PARTIAL => 'The file was only partially uploaded. Please try again.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Server is missing a temporary folder for uploads.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write the uploaded file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
            default => 'Error uploading file.',
        };
    }
}
