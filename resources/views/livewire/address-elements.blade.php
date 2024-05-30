<div>
    <div class="row">
        <div class="col-md-3">
            <label for="inputState">Direccion: </label>
            <select wire:model.live="provinceId" class="form-control" required>
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
            <select class="form-control @error('locationId') is-invalid @enderror" name="locationId" required>
                <option value="">-- seleccione --</option>
                @foreach ($this->locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
            @error('locationId')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <label for="inputZip">Calle: </label>
            <select class="form-control @error('streetTypeId') is-invalid @enderror" name="streetTypeId" required>
                <option value="">-- seleccione --</option>
                @if (isset($streetTypes))
                    @foreach ($streetTypes as $streetType)
                        <option value="{{ $streetType->id }}">{{ $streetType->name }}</option>
                    @endforeach

                @endif
            </select>
            @error('streetTypeId')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-1">
            <label for="inputZip">N°: </label>
            <input type="text" class="form-control @error('streetNumber') is-invalid @enderror" id="inputZip"
                name="streetNumber" required>
            @error('streetNumber')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="inputZip">Calle Nombre: </label>
            <input type="text" class="form-control @error('streetName') is-invalid @enderror" id="inputZip"
                name="streetName" required>
            @error('streetName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <label for="inputZip">Codigo Postal: </label>
            <input type="text" class="form-control @error('zipCode') is-invalid @enderror" id="inputZip" name="zipCode"
                required>
            @error('zipCode')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
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