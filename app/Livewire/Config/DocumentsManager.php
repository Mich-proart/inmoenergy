<?php

namespace App\Livewire\Config;

use App\Domain\Program\Services\FileUploadigService;
use App\Exceptions\CustomException;
use App\Models\File;
use App\Models\Program;
use App\Models\Section;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;
use DB;
use Livewire\Attributes\On;


class DocumentsManager extends Component
{

    use WithFileUploads;

    public Collection $inputs;

    public $programs;

    private FileUploadigService $fileUploadigService;

    public File $selected_file_to_delete;

    public function render()
    {
        return view('livewire.config.documents-manager');
    }

    public function __construct()
    {
        $this->fileUploadigService = App::make(FileUploadigService::class);
    }

    public function mount()
    {
        $this->fill([
            'inputs' => collect([['programId' => '', 'file' => '']]),
        ]);

        $section = Section::where('name', 'documentación')->with('programs')->first();
        $this->programs = $section->programs;
    }

    public function requestDelete($id)
    {
        $this->selected_file_to_delete = File::find($id);

        if ($this->selected_file_to_delete) {
            $this->dispatch('delete-confirmation');
        }
    }

    #[On('deleteFile')]
    public function deleteFile()
    {
        DB::beginTransaction();

        try {

            $this->fileUploadigService->removeFile($this->selected_file_to_delete);

            DB::commit();
            return redirect()->route('admin.config.documents');

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }
    }


    public function addInput()
    {
        $this->inputs->push(['programId' => '', 'file' => '']);
    }

    public function removeInput($key)
    {
        $this->inputs->pull($key);
    }

    protected $rules = [
        'inputs.*.programId' => 'required|exists:program,id',
        'inputs.*.file' => 'required|mimes:pdf,doc,docx|max:5240',
    ];

    protected $messages = [
        'inputs.*.programId.required' => 'Selecione un programa.',
        'inputs.*.programId.exists' => 'El programa no existe.',
        'inputs.*.file.required' => 'Selecione un archivo.',
        'inputs.*.file.mimes' => 'El archivo debe ser un pdf, doc o docx.',
        'inputs.*.file.max' => 'El archivo debe ser menor a 5MB.',
    ];

    public function submit()
    {

        $this->validate();

        DB::beginTransaction();

        try {

            foreach ($this->inputs as $input) {
                $this->fileUploadigService
                    ->setModel(Program::find($input['programId']))
                    ->addFile($input['file'])
                    ->saveFile('documents');
            }


            DB::commit();
            return redirect()->route('admin.config.documents');

        } catch (\Throwable $th) {

            DB::rollBack();
            throw CustomException::badRequestException($th->getMessage());
        }

    }
}
