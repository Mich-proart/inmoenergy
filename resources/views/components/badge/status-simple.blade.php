<div class="d-flex justify-content-center">
    @isset($status)
        @if ($status->name === 'pendiente asignación' || $status->name === 'asignado')
            <span class="custom-badge assigned">{{ ucfirst($status->name) }}</span>
        @elseif ($status->name === 'K.O.')
            <span class="custom-badge ko">{{ ucfirst($status->name) }}</span>
        @elseif ($status->name === 'baja')
            <span class="custom-badge down">{{ ucfirst($status->name) }}</span>
        @elseif ($status->name === 'en curso' || $status->name === 'pendiente de cliente')
            <span class="custom-badge inprogress">{{ ucfirst($status->name) }}</span>
        @elseif ($status->name === 'tramitado' || $status->name === 'pendiente validación')
            <span class="custom-badge processed">{{ ucfirst($status->name) }}</span>
        @elseif ($status->name === 'finalizado')
            <span class="custom-badge down">{{ ucfirst($status->name) }}</span>
        @elseif ($status->name === 'en vigor' || $status->name === 'resuelto')
            <span class="custom-badge operative">{{ ucfirst($status->name) }}</span>
        @else
            {{''}}
        @endif
    @endisset
</div>