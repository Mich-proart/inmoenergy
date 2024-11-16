<div>
    <div class="card card-primary">
        <div class="card-body">
            <div class="container text-center">
                <div class="row align-items-center">
                    <div class="col-2">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="width: 150px">
                                @if(empty($selectedUsers))
                                    {{$searchBasedOn === "user_assigned_id" ? "Usuarios" : "Clientes"}}
                                @elseif($allUsers)
                                    Todos
                                @elseif(!empty($selectedUsers))
                                    Opciones ({{count($selectedUsers)}})
                                @endif
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model="allUsers" wire:click="selectAllUsers" type="checkbox">
                                        Todos
                                    </div>
                                </li>
                                @foreach ($users as $user)
                                    <li>
                                        <div class="dropdown-item">
                                            <input wire:model.live="selectedUsers" wire:change="isAllCheckUsers"
                                                   type="checkbox" name="" id=""
                                                   value="{{ $user->id }}">
                                            {{ ucfirst($user->name) . ' ' . ucfirst($user->first_last_name) . ' ' . ucfirst($user->second_last_name) }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" style="width: 150px">
                                @if(empty($selectedServices))
                                    Suministros
                                @elseif($allService)
                                    Todos
                                @elseif(!empty($selectedServices))
                                    Opciones ({{count($selectedServices)}})
                                @endif
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="dropdown-item">
                                        <input wire:model="allService" wire:click="selectAllService" type="checkbox">
                                        Todos
                                    </div>
                                </li>
                                @foreach ($services as $service)
                                    <li>
                                        <div class="dropdown-item">
                                            <input wire:model.live="selectedServices" wire:change="isAllcheckService"
                                                   type="checkbox" name="" id=""
                                                   value="{{ $service->id }}">
                                            {{ ucfirst($service->name) }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col">
                        <div class="container text-center">
                            <div class="row align-items-center">
                                <div class="col">
                                    <input wire:model.live="from" class="form-control" type="date" name="from" id="from"
                                           wire:change="onParamsChange">
                                </div>
                                <div class="col">
                                    <input wire:model.live="to" class="form-control" type="date" name="to" id="to"
                                           wire:change="onParamsChange">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        <select wire:model="selectedFrequency" wire:change="onParamsChange" name="frequency"
                                id="frequencySet"
                                class="form-control">
                            <option value="">Frecuencia</option>
                            @foreach($this->frequencyOpt as $options)
                                <option value="{{$options}}">{{ucfirst($options)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @assets
    <script src="/vendor/jquery/jquery.min.js"></script>
    @endassets

    @script
    <script>
        $("#from").on("change", function () {
            console.log('test')
            setTimeout(function () {
                $("#frequencySet").val("");
            }, 200);

        });
        $("#to").on("change", function () {
            setTimeout(function () {
                $("#frequencySet").val("");
            }, 200);

        });
    </script>
    @endscript
</div>
