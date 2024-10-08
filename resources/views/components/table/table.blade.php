<table class="table table-hover table-sm">
    <thead>
        <tr>
            @foreach ($headers as $header)
                <th scope="col" class="{{ $header['classes'] }}">
                    {{ $header['name'] }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>