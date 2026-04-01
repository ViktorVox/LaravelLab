<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'subject'    => $this->subject,
            'message'    => $this->message,
            'status'     => $this->status,
            'user'       => new UserResource($this->whenLoaded('user')), 
            'created_at' => $this->created_at
        ];
    }
}
