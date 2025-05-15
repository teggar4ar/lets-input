<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateFileUploads
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
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */    public function handle(Request $request, Closure $next): Response
    {
        // Check if there are any files in the request
        if (count($request->allFiles()) > 0) {
            foreach ($request->allFiles() as $files) {
                // Handle both single files and file arrays
                if (is_array($files)) {
                    foreach ($files as $file) {
                        $this->validateFile($file);
                    }
                } else {
                    $this->validateFile($files);
                }
            }
        }

        return $next($request);
    }

    /**
     * Validate a single file
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return void
     */
    protected function validateFile($file): void
    {
        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $this->allowedExtensions)) {
            abort(422, 'The file type is not allowed.');
        }

        // Validate file size
        $sizeInMB = $file->getSize() / 1048576; // Convert bytes to MB
        if ($sizeInMB > $this->maxSize) {
            abort(422, "File size exceeds the maximum allowed size of {$this->maxSize}MB.");
        }

        // Validate file content type with extension
        $this->validateMimeType($file, $extension);

        // Scan for malicious content
        $this->scanForMaliciousContent($file);
    }

    /**
     * Validate that the mime type matches the extension
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $extension
     * @return void
     */
    protected function validateMimeType($file, $extension): void
    {
        $mimeType = $file->getMimeType();

        $allowedMimeTypes = [
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

        if (!isset($allowedMimeTypes[$extension]) || !in_array($mimeType, $allowedMimeTypes[$extension])) {
            abort(422, 'The file content does not match its extension.');
        }
    }

    /**
     * Scan file for potentially malicious content
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return void
     */
    protected function scanForMaliciousContent($file): void
    {
        // Read the first 4096 bytes of the file
        $handle = fopen($file->getPathname(), 'r');
        $content = fread($handle, 4096);
        fclose($handle);

        // Check for PHP code in files that shouldn't contain it
        if (!in_array($file->getClientOriginalExtension(), ['php', 'phtml'])) {
            if (preg_match('/<\?php|<\?=|eval\s*\(|system\s*\(|exec\s*\(|passthru|shell_exec|phpinfo|base64_decode|chmod|mkdir|fopen|fclose|readfile|edoced_46esab/i', $content)) {
                abort(422, 'The file contains potentially malicious content.');
            }
        }

        // Check for malicious scripts in images
        if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
            if (preg_match('/<script|javascript:|<iframe|<img|onerror=|onload=|<body|<html|alert\s*\(|document\.cookie|window\.location/i', $content)) {
                abort(422, 'The file contains potentially malicious content.');
            }
        }
    }
}
