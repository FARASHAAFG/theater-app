<?php

namespace App\Helpers;

use App\Helpers\Core\Result;
use Exception;
use Psr\Http\Message\UploadedFileInterface;

class FileUploadHelper
{
    /**
     * Upload a file with validation and return a Result.
     *
     * @param UploadedFileInterface $uploadedFile The uploaded file from the request
     * @param array $config Configuration options:
     *   - 'directory' (string): Upload directory path (required)
     *   - 'allowedTypes' (array): Array of allowed media types (required)
     *   - 'maxSize' (int): Maximum file size in bytes (required)
     *   - 'filenamePrefix' (string): Prefix for generated filenames (default: 'upload_')
     * @return Result Success with filename, or failure with error message
     */

    public static function upload(UploadedFileInterface $uploadedFile, array $config): Result
    {
        // You'll implement the method body in the following steps

        $directory = $config['directory'] ?? null;
        $allowedTypes = $config['allowedTypes'] ?? [];
        $maxSize = $config['maxSize'] ?? 0;
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
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return Result::failure('Error uploading file');
        }
        if ($maxSize < ($uploadedFile->getSize())) {
            $maxSize = round($maxSize / (1024 * 1024), 1);
            return Result::failure('Error, max size file reached');
        }

        $uploadfiles = $uploadedFile->getClientMediaType();

        if (!(in_array($uploadfiles, $allowedTypes))) {
            FlashMessage::error('The type is not accepted');
            return Result::failure('Error, type is not accepted');
        }

        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        $filename = uniqid($filenamePrefix) . '.' . $extension;

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
                return Result::failure('Could not create the directory');
            }
        }

        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return Result::failure('Error uploading file');
        }

        if ($uploadedFile->getSize() > $maxSize) {
            return Result::failure('File is too large (max allowed size exceeded)');
        }

        $mimeType = $uploadedFile->getClientMediaType();

        if (!in_array($mimeType, $allowedTypes)) {
            return Result::failure('Error, type is not accepted');
        }

        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        $filename = uniqid($filenamePrefix) . '.' . $extension;

        $destination = $directory . DIRECTORY_SEPARATOR . $filename;

        try {
            $uploadedFile->moveTo($destination);
        } catch (Exception $e) {
            return Result::failure('Failed to save uploaded file: ' . $e->getMessage());
        }

        return Result::success('File uploaded successfully', [
            'filename' => $filename
        ]);

        $destination = $directory . DIRECTORY_SEPARATOR . $filename;

        try {
            $uploadedFile->moveTo($destination);
        } catch (Exception $e) {
            return Result::failure('Failed to save uploaded file: ' . $e->getMessage());
        }

        return Result::success('File uploaded successfully', ['filename' => $filename]);
    }
}
