<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'    => $this->tittle,
            'description' => $this->description,
            'status'      => $this->status,
            'employee_id' => $this->employee_id,
        ];
    }
}
