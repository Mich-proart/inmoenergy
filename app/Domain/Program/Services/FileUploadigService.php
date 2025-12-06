<?php

namespace App\Domain\Program\Services;

use App\Models\Client;
use App\Models\File;
use App\Models\FileConfig;
use App\Models\Formality;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Storage;



class FileUploadigService
{
    public Client|Formality|User|Program|null $model = null;
    public $file = null;
    public int|null $configId = null;


    public function __construct()
    {
    }

    public function addFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function setConfigId($configId)
    {
        $this->configId = $configId;
        return $this;
    }

    public function saveFile(string $folder)
    {
        //$temp = explode('.', $this->file->getClientOriginalName())[0];

        $name = uniqid() . uniqid(); //$temp . '_' . uniqid() . uniqid();
        $tempName = $name . '.' . $this->file->getClientOriginalExtension();

        // Generate display name
        $fileName = $this->generateDisplayName($tempName);

        $nameWithNoExtension = pathinfo($fileName, PATHINFO_FILENAME);

        if ($this->file) {
            if ($this->model != null) {
                $this->model->files()->create([
                    'name' => $nameWithNoExtension,
                    'filename' => $fileName,
                    'mime_type' => $this->file->getMimeType(),
                    'folder' => $folder,
                    'config_id' => $this->configId ?? null
                ]);
            }
            $this->file->storeAs('public/' . $folder, $fileName);
            return $folder . '/' . $fileName;
        }
    }

    /**
     * Generate a meaningful display name for the file based on document type and client info
     */
    private function generateDisplayName(string $filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Get the file config name
        $configName = '';
        if ($this->configId) {
            $fileConfig = FileConfig::find($this->configId);
            if ($fileConfig) {
                $configName = $fileConfig->name;
            }
        }

        // Get client name
        $clientName = $this->getClientName();

        // Generate display name based on document type
        $displayName = $this->buildDisplayName($configName, $clientName, $extension);

        return $displayName;
    }

    /**
     * Get client name from the model
     */
    private function getClientName(): string
    {
        if (!$this->model) {
            return 'sin_nombre';
        }

        // Handle Client model
        if ($this->model instanceof Client) {
            $name = $this->model->name ?? '';
            $firstLastName = $this->model->first_last_name ?? '';
            $secondLastName = $this->model->second_last_name ?? '';

            $fullName = trim("$name $firstLastName $secondLastName");
            return $this->sanitizeFilename($fullName);
        }

        // Handle Formality model - get client from formality
        if ($this->model instanceof Formality) {
            $client = $this->model->client;
            if ($client) {
                $name = $client->name ?? '';
                $firstLastName = $client->first_last_name ?? '';
                $secondLastName = $client->second_last_name ?? '';

                $fullName = trim("$name $firstLastName $secondLastName");
                return $this->sanitizeFilename($fullName);
            }
        }

        return 'sin_nombre';
    }

    /**
     * Build the display name based on document type
     */
    private function buildDisplayName(string $configName, string $clientName, string $extension): string
    {
        // Normalize config name for comparison
        $normalizedConfig = strtolower(trim($configName));

        // Map document types to display names
        if (str_contains($normalizedConfig, 'dni')) {
            return "DNI_{$clientName}.{$extension}";
        }

        if (str_contains($normalizedConfig, 'cif')) {
            return "CIF_{$clientName}.{$extension}";
        }

        if (str_contains($normalizedConfig, 'escritura')) {
            return "Escritura_empresa_{$clientName}.{$extension}";
        }

        if (str_contains($normalizedConfig, 'alquiler') || str_contains($normalizedConfig, 'compraventa')) {
            return "Contrato_alquiler_o_compraventa_{$clientName}.{$extension}";
        }

        if (str_contains($normalizedConfig, 'autorización') || str_contains($normalizedConfig, 'autorizacion')) {
            return "Autorizacion_firmada_{$clientName}.{$extension}";
        }

        if (str_contains($normalizedConfig, 'contrato_del_suministro') || str_contains($normalizedConfig, 'suministro')) {
            // Try to get service type from config
            $serviceType = $this->getServiceType();
            if ($serviceType) {
                return "Contrato_suministro_{$serviceType}_{$clientName}.{$extension}";
            }
            return "Contrato_suministro_{$clientName}.{$extension}";
        }

        // For application manuals or unknown types, use the original config name
        if (!empty($configName)) {
            $sanitizedConfig = $this->sanitizeFilename($configName);
            return "{$sanitizedConfig}_{$clientName}.{$extension}";
        }

        // Fallback
        return "documento_{$clientName}.{$extension}";
    }

    /**
     * Get service type from FileConfig
     */
    private function getServiceType(): ?string
    {
        if (!$this->configId) {
            return null;
        }

        $fileConfig = FileConfig::find($this->configId);
        if ($fileConfig && $fileConfig->component_option_id) {
            $componentOption = $fileConfig->componentOption;
            if ($componentOption) {
                return $this->sanitizeFilename($componentOption->name);
            }
        }

        return null;
    }

    /**
     * Sanitize filename by removing special characters
     */
    private function sanitizeFilename(string $filename): string
    {
        // Replace spaces with underscores
        $filename = str_replace(' ', '_', $filename);

        // Remove accents and special characters
        $filename = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $filename);

        // Remove any remaining non-alphanumeric characters except underscores and hyphens
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '', $filename);

        // Remove multiple consecutive underscores
        $filename = preg_replace('/_+/', '_', $filename);

        // Trim underscores from start and end
        $filename = trim($filename, '_');

        return $filename ?: 'sin_nombre';
    }

    public function force_replace(File $file_reference)
    {
        if ($this->file) {

            if ($this->deleteFile($file_reference->folder, $file_reference->filename)) {
                // $temp = explode('.', $this->file->getClientOriginalName())[0];

                $name = uniqid() . uniqid(); // $temp . '_' . uniqid() . uniqid();
                $newFilename = $name . '.' . $this->file->getClientOriginalExtension();

                // Generate display name
                $displayName = $this->generateDisplayName($newFilename);

                $file_reference->update([
                    'name' => $displayName,
                    'filename' => $newFilename,
                    'mime_type' => $this->file->getMimeType(),
                    'config_id' => $this->configId ?? null
                ]);

                $this->file->storeAs('public/' . $file_reference->folder, $newFilename);
                return $file_reference->folder . '/' . $newFilename;
            }
        }

    }


    private function deleteFile($folder, $filename): bool
    {
        if (is_dir(storage_path('app/public/' . $folder))) {
            return unlink(storage_path('app/public/' . $folder . '/' . $filename));
        } else {
            return false;
        }
    }


    public function addExistingFile($file_reference)
    {
        $this->model->files()->attach($file_reference);
    }

    public function removeFile(File $file_reference)
    {
        $programs = $file_reference->programs()->get();

        foreach ($programs as $program) {
            $program->files()->detach($file_reference);
        }
        if ($this->deleteFile($file_reference->folder, $file_reference->filename)) {
            $file_reference->delete() ? true : false;
        } else {
            return false;
        }
    }

}