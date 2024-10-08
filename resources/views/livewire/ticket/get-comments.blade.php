<div>
    <section>
        @empty(!$resolution_comment)
            <div class="container my-5">
                <div class="row d-flex justify-content-center">
                    <div class="col">
                        <div class="card text-body">
                            <div class="card-body p-4">
                                <h5 class="mb-0">Comentarios de resolución</h5>
                            </div>
                            <div class="d-flex justify-content-center">
                                <hr class="my-0" width="1100px" />
                            </div>
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
                                            {{ucfirst($resolution_comment->user->name . ' ' . $resolution_comment->user->first_last_name . ' ' . $resolution_comment->user->second_last_name)}}
                                        </h6>
                                        <div class="d-flex align-items-center mb-3">
                                            <p class="mb-0">
                                                {{$resolution_comment->created_at->diffForHumans()}}
                                            </p>
                                        </div>
                                        <p class="mb-0">
                                            {{$resolution_comment->body}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endempty
    </section>
    <section>
        <div class="container my-5">
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <div class="card text-body">
                        <div class="card-body p-4">
                            <h5 class="mb-0">Comentarios</h5>
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
</div>