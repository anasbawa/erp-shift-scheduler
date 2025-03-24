<?php

namespace App\Repositories\Shift;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Collection;

class ShiftRepository implements ShiftRepositoryInterface
{
    public function all(): Collection
    {
        return Shift::all();
    }

    public function find(int $id): ?Shift
    {
        return Shift::find($id);
    }

    public function create(array $data): Shift
    {
        $shift = Shift::create([
            'department_id' => $data['department_id'],
            'start_time'    => $data['start_time'],
            'end_time'      => $data['end_time'],
            'max_employees' => $data['max_employees'],
        ]);

        // Save associated resources
        if (!empty($data['resources'])) {
            foreach ($data['resources'] as $resourceData) {
                $shift->resources()->create([
                    'title'     => $resourceData['title'],
                ]);
            }
        }
        return $shift;
    }

    public function update(int $id, array $data): ?Shift
    {
        $shift = $this->find($id);
        if ($shift) {
            $shift->update($data);
        }
        return $shift;
    }

    public function delete(int $id): bool
    {
        $shift = $this->find($id);
        return $shift ? $shift->delete() : false;
    }
}