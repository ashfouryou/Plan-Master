<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EligibilityCriteriaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age_less_than' => $this->age_less_than,
            'age_greater_than' => $this->age_greater_than,
            'last_login_days_ago' => $this->last_login_days_ago,
            'income_less_than' => $this->income_less_than,
            'income_greater_than' => $this->income_greater_than,
        ];
    }
}
