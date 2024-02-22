<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumnoResource extends JsonResource
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
    public function with(Request $request)
    {
        return ["jsonapi" =>
            ["version" => "1.0"]];
    }

}
