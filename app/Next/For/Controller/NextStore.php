<?php

namespace App\Next\ForController;

use Illuminate\Http\Request;
use App\Next\ForContract\NextInterface;
use App\Next\ForData\NextDTOInterface;
use Closure;
use Illuminate\Http\Resources\Json\JsonResource;

class NextStore
{
    public function __invoke(
        Request $request,
        NextInterface $contract,
        NextDTOInterface $dto,
        JsonResource $resource,
        string $column,
        Closure $afterStore,
        Closure $beforeStore
    )
    {
        try {
            $beforeStore($request);
            $data = $contract->store($dto);
            $afterStore($request, $data);
            return (new $resource($data))->additional([
                'status' => 1,
                'message' => $data->$column . config('message.store.positive')
            ]);
        } catch (\Exception $e) {
            return [
                'message' => $data->$column . config('message.store.negative'),
                'status' => 0,
                'exception' => $e->getMessage()
            ];
        }
    }
}
