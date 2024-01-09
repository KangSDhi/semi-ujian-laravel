<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'jurusan_id'  => $this->jurusan_id,
            'NISN'      => $this->NISN,
            'name'      => $this->name,
            'role_id'   => $this->role_id
        ];
    }
}
