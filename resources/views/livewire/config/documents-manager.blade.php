<div>
    <div class="card card-primary card-outline">
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
</div>