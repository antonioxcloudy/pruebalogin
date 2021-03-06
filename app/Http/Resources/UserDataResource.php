<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Admin\RoleResource;


class UserDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            // 'avatar' => $this->avatar ? Storage::url($this->avatar) :  '',
            'fullName' => $this->name,
            // 'ability' => AbilityResource::collection($this->permissions)
        ];
    }
}
