<?php

namespace App\Domain\Program\Services;

use App\Models\BusinessGroup;
use App\Models\Component;
use Illuminate\Database\Query\Builder;
use DB;

class ComponentService
{

    private function ComponentQuery(): Builder
    {
        return DB::table('component')
            ->select(
                'component.id as id',
                'component.name as component_name'
            );
    }
    private function businessGroupQuery(): Builder
    {
        return DB::table('business_group')
            ->select(
                'business_group.id as id',
                'business_group.name as name'
            );
    }

    public function getBusinessGroup()
    {
        $query = $this->businessGroupQuery();
        return $query->get();
    }
    public function officeByBusinessGroup(int $id)
    {
        return DB::table('office')
            ->where('business_group_id', '=', $id)
            ->select('office.id as id', 'office.name as name')
            ->get();
    }

    public function getAll()
    {
        $query = $this->ComponentQuery();
        return $query->get();
    }

    public function getOptionsByComponentBy(int $id)
    {
        return DB::table('component_option')
            ->leftJoin('component', 'component.id', '=', 'component_option.component_id')
            ->where('component.id', '=', $id)
            ->select('component_option.id as id', 'component_option.name as name')
            ->get();
    }

    public function getById($id)
    {
        $component = Component::find($id);
        return $component;
    }

    public function getBusinessById(int $id)
    {
        $business = BusinessGroup::find($id);
        return $business;
    }
}