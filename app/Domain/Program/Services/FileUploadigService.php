<?php

namespace App\Domain\Program\Services;

use App\Models\Program;
use App\Models\User;



class FileUploadigService
{
    public User|Program|null $model = null;
    public $file = null;


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

    public function saveFile(string $folder, string $name)
    {
        $newFilename = $name . '.' . $this->file->getClientOriginalExtension();

        if ($this->file) {
            $this->model->files()->create([
                'name' => $name,
                'filename' => $newFilename,
                'mime_type' => $this->file->getMimeType(),
                'folder' => $folder
            ]);
            $this->file->storeAs('public/' . $folder, $newFilename);
        }
    }


}