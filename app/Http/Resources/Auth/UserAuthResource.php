<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAuthResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'is_verified' => (bool)$this->email_verified_at != null,
            // 'access_token' => $this->createToken('Token Name')->accessToken,
            'access_token' => $this->createToken('User API Token')->plainTextToken,
        ];
    }
}
