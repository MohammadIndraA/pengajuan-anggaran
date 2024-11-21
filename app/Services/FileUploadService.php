<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload multiple files and optionally process Excel files.
     *
     * @param array $files
     * @param string $storagePath
     * @param object $importClass
     * @param object|null $model
     * @return string
     */
    public function uploadMulti(array $files, string $storagePath, $importClass, $model = null): string
    {
        $fileNames = [];
        $filenamePrefix = date('YmdHi');

        foreach ($files as $file) {
            // Generate unique filename and store file
            $filename = $filenamePrefix . '_' . $file->getClientOriginalName();
            $file->storeAs($storagePath, $filename);
            $fileNames[] = $filename;

            // Check if file is an Excel file
            if (in_array($file->getClientOriginalExtension(), ['xls', 'xlsx'])) {
                // Perform import using provided import class
                if ($importClass) {
                    $import = new $importClass($model->id ?? null);
                    Excel::import($import, $file);

                    // Update model if provided and import has a `getTotal` method
                    if ($model && method_exists($importClass, 'getTotal')) {
                        $totalBudget = $import->getTotal();
                        $model->update(['budget' => $totalBudget]);
                    }
                }
            }
        }

        // Return formatted filenames
        return implode('|', $fileNames);
    }
}
