<div>
    <div class="row">
        <div class="col">
            <lable>Usuarios</lable>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="width: 150px">
                    @if(empty($selectedAssigneds))
                        -- seleccione --
                    @elseif($allAssigned)
                        Todos
                    @elseif(!empty($selectedAssigneds))
                        Opciones ({{count($selectedAssigneds)}})
                    @endif
                </button>
                <ul wire:ignore class="dropdown-menu">
                    <li>
                        <div class="dropdown-item">
                            <input wire:model="allAssigned" wire:click="selectAllAssigned" type="checkbox">
                            Todos
                        </div>
                    </li>
                    @foreach ($workers as $worker)
                        <li>
                            <div class="dropdown-item">
                                <input wire:model.live="selectedAssigneds" wire:change="isAllCheckAssigned"
                                       type="checkbox" name="" id=""
                                       value="{{ $worker->id }}">
                                {{ ucfirst($worker->name) . ' ' . ucfirst($worker->first_last_name) . ' ' . ucfirst($worker->second_last_name) }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col">
            <lable>Suministros</lable>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false" style="width: 150px">
                    @if(empty($selectedServices))
                        -- seleccione --
                    @elseif($allService)
                        Todos
                    @elseif(!empty($selectedServices))
                        Opciones ({{count($selectedServices)}})
                    @endif
                </button>
                <ul wire:ignore class="dropdown-menu">
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
            <input wire:model.live="from" type="date" name="from" id="from" wire:change="onParamsChange">
            <input wire:model.live="to" type="date" name="to" id="to" wire:change="onParamsChange">
        </div>

        <div class="col">
            <select wire:model="selectedFrequency" wire:change="onParamsChange" name="frequency" id="">
                <option value="">-- selecione --</option>
                @foreach($this->frequencyOpt as $options)
                    <option value="{{$options}}">{{ucfirst($options)}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
