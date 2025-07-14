<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class WorkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        $locale = App::getLocale();

        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', $locale),
            'description' => $this->getTranslation('description', $locale),
            'status' => $this->status,
            'employee' => $this->whenLoaded('employee'),
            'assigned_employees' => $this->assignedEmployees()->get()->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'pivot_status' => $employee->pivot->status,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
