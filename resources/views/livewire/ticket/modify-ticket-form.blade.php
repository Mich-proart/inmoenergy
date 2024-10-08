<div>
    <section>
        <div class="container my-5">
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <div class="card text-body">
                        <div class="card-body p-4">
                            <h4 class="mb-0">Comentarios</h4>
                        </div>
                        <div class="d-flex justify-content-center">
                            <hr class="my-0" width="1100px" />

                        </div>

                        @foreach ($comments as $comment)
                            <div class="card-body p-4">
                                <div class="d-flex flex-start">
                                    <div width="35" height="35">
                                        <svg class="rounded-circle shadow-1-strong me-3" xmlns="http://www.w3.org/2000/svg"
                                            width="35" height="35" fill="currentColor" class="bi bi-person-circle"
                                            viewBox="0 0 16 16">
                                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                            <path fill-rule="evenodd"
                                                d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                        </svg>

                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ucfirst($comment->user->name . ' ' . $comment->user->first_last_name . ' ' . $comment->user->second_last_name)}}
                                        </h6>
                                        <div class="d-flex align-items-center mb-3">
                                            <p class="mb-0">
                                                {{$comment->created_at->diffForHumans()}}
                                            </p>
                                            <a href="#!" class="link-muted"><i class="fas fa-pencil-alt ms-2"></i></a>
                                        </div>
                                        <p class="mb-0">
                                            {{$comment->body}}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <hr class="my-0" width="1100px" />
                            </div>

                        @endforeach

                        <div>
                            @if (count(value: $comments) > 0)
                                {{ $comments->links('components.pagination') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($ticket->status->name != 'pendiente de cliente')
        <section>
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col">
                        <div class="card text-body">
                            <div class="card-body p-4">
                                <h4 class="mb-0">Nuevo Comentario</h4>
                            </div>
                            <hr class="my-0" />
                            <div class="card-body">
                                <div class="">
                                    <div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1"
                                                class="form-label ml-2">Comentario</label>
                                            <textarea wire:model="body"
                                                class="form-control @error('body') is-invalid @enderror"
                                                id="exampleFormControlTextarea1" rows="3"></textarea>
                                            @error('body')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4" style="margin-bottom: 25px">
                                                <div class="form-check form-switch">
                                                    <input wire:model="isResolved" wire:change="setIsResolved()"
                                                        class="form-check-input" type="checkbox" role="switch"
                                                        id="isRenewable">
                                                    <label class="form-check-label" for="isRenewable">Renovación</label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($isResolved)
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label ml-2">Comentario
                                                    de resolución</label>
                                                <textarea wire:model="resolution_comment_body"
                                                    class="form-control @error('resolution_comment_body') is-invalid @enderror"
                                                    id="exampleFormControlTextarea1" rows="3"></textarea>
                                                @error('resolution_comment_body')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row no-print px-3">
            <div class="col-12">
                <div style="margin-top: 50px; margin-bottom: 25px">
                    <button class="btn btn-secondary">cerrado</button>
                    <button wire:click="requestClient" class="btn btn-primary">Petición a cliente</button>

                    <button wire:click="save" type="button" class="btn btn-success float-right"
                        style="margin-right: 10px"><i class="far fa-save"></i>
                        Guardar datos</button>
                </div>
            </div>
        </div>
    @else
        <div class="row no-print px-3">
            <div class="col-12">
                <div style="margin-top: 50px; margin-bottom: 25px">
                    <button class="btn btn-secondary">cerrado</button>
                    @if ($ticket->status->name == 'pendiente de cliente')
                        <button wire:click="backToInProgress" class="btn btn-warning">Volver a "En curso"</button>
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>
</div>