<?php
namespace App\Repositories\Shift;

use App\Models\Shift;
use Illuminate\Database\Eloquent\Collection;

interface ShiftRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Shift;
    public function create(array $data): Shift;
    public function update(int $id, array $data): ?Shift;
    public function delete(int $id): bool;
}