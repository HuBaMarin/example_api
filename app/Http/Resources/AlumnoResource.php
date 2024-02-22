<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AlumnoResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => (string)$this->id,
            "type" => "Alumnos",
            "attributes" => [
                "id" => $this->id,
                "nombre" => $this->nombre,
                "email" => $this->email
            ],
            'links' => [
                'self' => url('api/alumnos/' . $this->id)
            ]];
    }
}
