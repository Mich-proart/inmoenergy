<div>
    <div class="card card-primary card-outline">
        <div class="mt-3 mr-3">
            <div class="col-12 ">
                <h4 class=" card-title">{{Auth::user()->name}}</h4>
            </div>
        </div>
        <div class="card-body">
            <section>
                <div class="form-group">
                    <form wire:submit.prevent="update">
                        <div class="form-group">
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    <label for="">Nombre rol: </label>
                                    <input wire:model="roleName" type="text"
                                        class="form-control @error('roleName') is-invalid @enderror" id="inputCity"
                                        name="name">
                                    @error('roleName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            @if (isset($sections))

                                @foreach ($sections as $section)
                                    @if ($section->programs->count() > 0)
                                        <hr>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ ucfirst($section->name) }}</h6>
                                        @foreach ($section->programs as $program)
                                            <div class="form-check">
                                                <input wire:model="programIds" class="form-check-input" type="checkbox"
                                                    value="{{ $program->id }}" name="programIds[]" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    {{ ucfirst($program->name) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach

                            @endif

                        </div>

                        <div class="row no-print">
                            <div class="col-12">
                                <div style="margin-top: 50px; margin-bottom: 25px">
                                    <a href="{{route('admin.roles.index')}}">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                    </a>
                                    <button type="submit" class="btn btn-success float-right"><i
                                            class="far fa-save"></i>
                                        Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </div>
    </div>
</div>