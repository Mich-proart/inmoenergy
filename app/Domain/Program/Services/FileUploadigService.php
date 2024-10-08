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
        $newFilename = $name . '.' . $this->file->getClientOriginalExtension();

        if ($this->file) {
            if ($this->model != null) {
                $this->model->files()->create([
                    'name' => $name,
                    'filename' => $newFilename,
                    'mime_type' => $this->file->getMimeType(),
                    'folder' => $folder,
                    'config_id' => $this->configId ?? null
                ]);
            }
            $this->file->storeAs('public/' . $folder, $newFilename);
            return $folder . '/' . $newFilename;
        }
    }

    public function force_replace(File $file_reference)
    {
        if ($this->file) {

            if ($this->deleteFile($file_reference->folder, $file_reference->filename)) {
                // $temp = explode('.', $this->file->getClientOriginalName())[0];

                $name = uniqid() . uniqid(); // $temp . '_' . uniqid() . uniqid();
                $newFilename = $name . '.' . $this->file->getClientOriginalExtension();

                $file_reference->update([
                    'name' => $name,
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