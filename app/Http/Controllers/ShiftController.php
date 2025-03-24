<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftRequest;
use App\Http\Resources\ShiftResource;
use App\Repositories\Shift\ShiftRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    private ShiftRepositoryInterface $shiftRepository;

    public function __construct(ShiftRepositoryInterface $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function index()
    {
        return ShiftResource::collection($this->shiftRepository->all());
    }

    public function show(int $id): JsonResponse
    {
        $shift = $this->shiftRepository->find($id);
        return $shift ? new ShiftResource($shift) : response()->json(['message' => 'Not found'], 404);
    }

    public function store(ShiftRequest $request): JsonResponse
    {
        $shift = $this->shiftRepository->create($request->validated());

        return response()->json([
            'message' => 'Shift created!',
            'shift' => new ShiftResource($shift)
        ], 201);
    }

    public function update(ShiftRequest $request, int $id): JsonResponse
    {
        $$shift = $this->shiftRepository->update($id, $request->validated());

        return $shift ? response()->json([
            'message' => 'Shift updated!',
            'shift' => new ShiftResource($shift)
        ]) : response()->json(['message' => 'Not found'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
         return $this->shiftRepository->delete($id)
            ? response()->json(['message' => 'Shift deleted!'])
            : response()->json(['message' => 'Not found'], 404);
    }
}
