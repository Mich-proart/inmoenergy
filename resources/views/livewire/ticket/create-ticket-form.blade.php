<div>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <form wire:submit.prevent="save">
                @csrf
                <div class="container" style="margin-left: 0px; margin-right: 0px">
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col">
                                    <div class="form-outline" data-mdb-input-init>
                                        <input wire:model.live="search" type="search" id="search" class="form-control"
                                            placeholder="Nombre cliente" aria-label="Search" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <input wire:model.live="search_street" type="search" id="search_street"
                                        class="form-control" placeholder="Nombre calle" aria-label="Search" />
                                </div>
                            </div>
                            <div class="container" style="margin-top: 5px; margin-left: 5px">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($formalities as $item)
                                            <tr>
                                                <td><input wire:model="formalityId" class="form-check-input" type="radio"
                                                        id="" name="formalityId" value="{{ $item->id }}" required></td>
                                                <td>
                                                    {{ $item->client ? ucfirst($item->client->name) . ' ' . ucfirst($item->client->first_last_name) . ' ' . ucfirst($item->client->second_last_name) : "" }}
                                                </td>
                                                <td>{{$item->service ? $item->service->name : ""}}</td>
                                                <td>{{$item->address ? $item->address->fullAddress() : ""}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    @if (count($formalities) > 0)
                                        {{ $formalities->links('components.pagination') }}

                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row" style="margin-bottom: 3px">
                                        <span style="font-size: 23px;"><i class="fas fa-file-invoice"></i>
                                            Datos del ticket
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputZip">Título: </label>
                                        <input wire:model="title" type="text"
                                            class="form-control @error('title') is-invalid @enderror" name="title"
                                            id="title">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="inputZip">Tipo: </label>
                                        @if (isset($this->types))
                                            @foreach ($this->types as $item)
                                                <div class="form-check form-check-inline">
                                                    <input wire:model="ticketTypeId" class="form-check-input" type="radio" id=""
                                                        name="ticketTypeId" value="{{ $item->id }}">
                                                    <label class="form-check-label" for="">{{ ucfirst($item->name) }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div style="margin-top: 50px; margin-bottom: 25px">
                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Descripción</label>
                                            <textarea wire:model="description"
                                                class="form-control  @error('description') is-invalid @enderror"
                                                id="exampleFormControlTextarea1" rows="3" name="observation"></textarea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row no-print">
                                        <div class="col-12">
                                            <div style="margin-top: 50px; margin-bottom: 25px">
                                                <button type="submit" class="btn btn-success float-right"><i
                                                        class="far fa-save"></i>
                                                    Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    @script
    <script>

        $wire.on('checks', (e) => {
            console.log(e);
            Swal.fire({
                confirmButtonColor: '#004a99',
                icon: "error",
                title: e.title,
                text: e.error,
            });
        });

        $wire.on('load', () => {
            // document.querySelector('.spinner-wrapper').style.display = 'block';
        })
    </script>
    @endscript
</div>