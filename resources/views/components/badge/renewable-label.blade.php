<div>
    <label for="">Renovación:</label>
    @isset($isRenewable)
        @if ($isRenewable)
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check2-circle"
                viewBox="0 0 16 16" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Trámite renovable">
                <path
                    d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
            </svg>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ban"
                viewBox="0 0 16 16" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Trámite no renovable">
                <path
                    d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0" />
            </svg>
        @endif
    @endisset
</div>