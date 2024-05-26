<div>
    <div class="row">
        <div class="col-md-3">
            <label for="inputState">Direccion: </label>
            <select wire:model.live="provinceId" class="form-control">
                <option value="">-- seleccione --</option>
                @foreach ($this->provinces as $province)
                    @if ($province->region->name === $province->name)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @else
                        <option value="{{ $province->id }}">{{ $province->region->name }}, {{ $province->name }}</option>
                    @endif 

                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="inputState">Poblacion: </label>
            <select class="form-control" name="locationId">
                <option value="">-- seleccione --</option>
                @foreach ($this->locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputZip">Calle: </label>
            <input type="text" class="form-control" id="inputZip" name="secondLastName">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label for="inputZip">Calle: </label>
            <select class="form-control" name="streetTypeId">
                <option value="">-- seleccione --</option>
                @if (isset($streetTypes))
                    @foreach ($streetTypes as $streetType)
                        <option value="{{ $streetType->id }}">{{ $streetType->name }}</option>
                    @endforeach

                @endif
            </select>
        </div>
        <div class="col-md-1">
            <label for="inputZip">N°: </label>
            <input type="text" class="form-control" id="inputZip" name="streetNumber">
        </div>
        <div class="col-md-3">
            <label for="inputZip">Nombre: </label>
            <input type="text" class="form-control" id="inputZip" name="streetName">
        </div>
        <div class="col-md-2">
            <label for="inputZip">Codigo Postal: </label>
            <input type="text" class="form-control" id="inputZip" name="zipCode">
        </div>
        <div class="col-md-1">
            <label for="inputZip">Bloq: </label>
            <input type="text" class="form-control" id="inputZip" name="block">
        </div>
        <div class="col-md-1">
            <label for="inputZip">Escal: </label>
            <input type="text" class="form-control" id="inputZip" name="blockstaircase">
        </div>
        <div class="col-md-1">
            <label for="inputZip">Piso: </label>
            <input type="text" class="form-control" id="inputZip" name="floor">
        </div>
        <div class="col-md-1">
            <label for="inputZip">Puerta: </label>
            <input type="text" class="form-control" id="inputZip" name="door">
        </div>
    </div>
</div>