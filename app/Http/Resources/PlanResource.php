<?php 
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'), // Format as needed
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'), // Format as needed
            'created_at_formatted' => $this->created_at->toFormattedDateString(),
            'updated_at_formatted' => $this->updated_at->toFormattedDateString(),
        ];
    }
}
