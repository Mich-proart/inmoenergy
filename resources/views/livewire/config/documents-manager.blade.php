<div>
    <div class="card card-success card-outline">
        <div class="card-body table-responsive p-0">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Programa</th>
                                <th scope="col">Archivo</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($programs))
                                @foreach ($programs as $program)
                                    @foreach ($program->files as $file)
                                        <tr>
                                            <td>{{ucfirst($program->name)}}</td>
                                            <td>{{$file->name}}</td>
                                            <td>
                                                <a href="{{route('admin.documents.download', $file->id)}}">
                                                    <button class="btn btn-primary btn-sm">Descargar</button></a>
                                                <button wire:click="requestDelete({{$file->id}})" class="btn btn-danger btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card px-2">
                <div class="card-header">
                    <h3 class="card-title sm">Nuevos documentos</h3>
                </div>
                <div class="card-body">
                    @foreach($inputs as $key => $input)
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="inputState">Programa: </label>
                                <select wire:model.defer="inputs.{{$key}}.programId"
                                    class="form-control @error('inputs.' . $key . '.programId') is-invalid @enderror"
                                    id="input_{{$key}}_programId">
                                    <option value="">-- selecione --</option>
                                    @if (isset($programs))
                                        @foreach ($programs as $option)
                                            <option value="{{ $option->id }}">{{ ucfirst($option->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('inputs.' . $key . '.programId') <span
                                    class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputCity">Archivo</label>
                                <input wire:model.defer="inputs.{{$key}}.file" type="file"
                                    class="form-control @error('inputs.' . $key . '.file') is-invalid @enderror"
                                    id="input_{{$key}}_file">
                                @error('inputs.' . $key . '.file') <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                                <div wire:loading wire:target="inputs.{{$key}}.file">Subiendo archivo...</div>
                            </div>
                            @if($key > 0)
                                <div class=" form-group col-md-3" style="margin-top: 30px">
                                    <button class="btn btn-danger" type="button" wire:click="removeInput({{$key}})"><i
                                            class="far fa-trash-alt"></i></button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row no-print" style="margin-bottom: 20px">
                <div class="col-12">
                    <div style="margin-top: 50px; margin-bottom: 25px">
                        <button wire:click="submit" class="btn btn-success float-right"
                            style="margin-right: 20px">Guardar</button>
                        <button wire:click="addInput" class="btn btn-primary float-right" style="margin-right: 10px">+
                            Agregar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @script
    <script>

        $wire.on('delete-confirmation', (e) => {
            Swal.fire({
                title: "¿Seguro que quieres eliminar el archivo?",
                text: "Se eliminara permanentemente el archivo y su referencia en el programa.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "si",
                cancelButtonText: "no"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('deleteFile');
                }
            });
        });
    </script>
    @endscript
</div>