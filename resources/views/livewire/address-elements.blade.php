<div>
    <br>
    <select wire:model.live="provinceId">
        <option value="">Select Province</option>
        @foreach ($this->provinces as $province)
            @if ($province->region->name === $province->name)
                <option value="{{ $province->id }}">{{ $province->name }}</option>
            @else
                <option value="{{ $province->id }}">{{ $province->region->name }}, {{ $province->name }}</option>
            @endif 

        @endforeach
    </select>

    <br>

    <select wire:model="locationId">
        <option value="">Select Location</option>
        @foreach ($this->locations as $location)
            <option value="{{ $location->id }}">{{ $location->name }}</option>
        @endforeach
    </select>

</div>