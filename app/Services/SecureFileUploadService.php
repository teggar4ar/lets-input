<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class SecureFileUploadService
{
    /**
     * The list of allowed file extensions
     * @var array
     */
    protected $allowedExtensions = [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'pdf',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'txt',
        'csv'
    ];

    /**
     * Maximum allowed file size in MB
     * @var int
     */
    protected $maxSize = 10;

    /**
     * Allowed mime types with extensions
     * @var array
     */
    protected $allowedMimeTypes = [
        'jpg' => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png' => ['image/png'],
        'gif' => ['image/gif'],
        'pdf' => ['application/pdf'],
        'doc' => ['application/msword'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        'xls' => ['application/vnd.ms-excel'],
        'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
        'txt' => ['text/plain'],
        'csv' => ['text/csv', 'text/plain'],
    ];

    /**
     * Upload a file securely with validation
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param array $options
     * @return array
     */
    public function upload(UploadedFile $file, string $directory, array $options = []): array
    {
        // Merge default options with provided options
        $options = array_merge([
            'disk' => 'public',
            'generateRandomName' => true,
            'maxSize' => $this->maxSize, // In MB
            'allowedExtensions' => $this->allowedExtensions,
            'allowedMimeTypes' => $this->allowedMimeTypes,
        ], $options);

        // Validate the file
        $this->validateFile($file, $options);

        // Generate a secure filename
        $filename = $this->generateSecureFilename($file, $options['generateRandomName']);        // Store the file
        $path = $file->storeAs($directory, $filename, ['disk' => $options['disk']]);

        // Get the public URL or storage path
        $fullPath = '';
        if ($options['disk'] === 'public') {
            $fullPath = URL::to('storage/' . str_replace('public/', '', $path));
        } else {
            $fullPath = storage_path('app/' . $path);
        }

        // Create file meta data
        $meta = [
            'original_name' => $file->getClientOriginalName(),
            'filename' => $filename,
            'path' => $path,
            'full_path' => $fullPath,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'extension' => $file->getClientOriginalExtension(),
        ];

        return $meta;
    }

    /**
     * Validate uploaded file
     *
     * @param UploadedFile $file
     * @param array $options
     * @return void
     * @throws \Exception
     */
    protected function validateFile(UploadedFile $file, array $options): void
    {
        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $options['allowedExtensions'])) {
            throw new \Exception('The file type is not allowed.');
        }

        // Validate file size
        $sizeInMB = $file->getSize() / 1048576; // Convert bytes to MB
        if ($sizeInMB > $options['maxSize']) {
            throw new \Exception("File size exceeds the maximum allowed size of {$options['maxSize']}MB.");
        }

        // Validate file content type with extension
        $mimeType = $file->getMimeType();
        if (!isset($options['allowedMimeTypes'][$extension]) || !in_array($mimeType, $options['allowedMimeTypes'][$extension])) {
            throw new \Exception('The file content does not match its extension.');
        }

        // Scan for malicious content
        $this->scanForMaliciousContent($file, $extension);
    }

    /**
     * Generate a secure filename for the uploaded file
     *
     * @param UploadedFile $file
     * @param bool $randomize
     * @return string
     */
    protected function generateSecureFilename(UploadedFile $file, bool $randomize = true): string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if ($randomize) {
            // Generate a random 40-character filename
            return Str::random(40) . '.' . $extension;
        }

        // Sanitize the original filename
        $originalName = $file->getClientOriginalName();
        $sanitizedName = preg_replace('/[^a-zA-Z0-9_.-]/', '', pathinfo($originalName, PATHINFO_FILENAME));

        // Add a timestamp to prevent overwriting files
        return $sanitizedName . '_' . time() . '.' . $extension;
    }

    /**
     * Scan file for potentially malicious content
     *
     * @param UploadedFile $file
     * @param string $extension
     * @return void
     * @throws \Exception
     */
    protected function scanForMaliciousContent(UploadedFile $file, string $extension): void
    {
        // Read the first 4096 bytes of the file
        $handle = fopen($file->getPathname(), 'r');
        $content = fread($handle, 4096);
        fclose($handle);

        // Check for PHP code in files that shouldn't contain it
        if (!in_array($extension, ['php', 'phtml'])) {
            if (preg_match('/<\?php|<\?=|eval\s*\(|system\s*\(|exec\s*\(|passthru|shell_exec|phpinfo|base64_decode|chmod|mkdir|fopen|fclose|readfile|edoced_46esab/i', $content)) {
                throw new \Exception('The file contains potentially malicious content.');
            }
        }

        // Check for malicious scripts in images
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (preg_match('/<script|javascript:|<iframe|<img|onerror=|onload=|<body|<html|alert\s*\(|document\.cookie|window\.location/i', $content)) {
                throw new \Exception('The file contains potentially malicious content.');
            }
        }
    }
}
