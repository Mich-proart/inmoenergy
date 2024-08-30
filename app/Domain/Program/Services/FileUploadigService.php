<?php

namespace App\Domain\Program\Services;

use App\Models\Client;
use App\Models\FileConfig;
use App\Models\Formality;
use App\Models\Program;
use App\Models\User;



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
        $temp = explode('.', $this->file->getClientOriginalName())[0];

        $name = $temp . '_' . uniqid();
        $newFilename = $name . '.' . $this->file->getClientOriginalExtension();

        if ($this->file) {
            $this->model->files()->create([
                'name' => $name,
                'filename' => $newFilename,
                'mime_type' => $this->file->getMimeType(),
                'folder' => $folder,
                'config_id' => $this->configId ?? null
            ]);
            $this->file->storeAs('public/' . $folder, $newFilename);
        }
    }


}