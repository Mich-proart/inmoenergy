@props(['name'])

<div>
    <select class="form-control" name="{{ $name }}">
        <option value="">-- selecione --</option>
        @if (isset($options))
            @foreach ($options as $option)
                <option value="{{ $option->id }}">{{ $option->name }}</option>
            @endforeach
        @endif
    </select>
    @error('{{ $name }}')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>