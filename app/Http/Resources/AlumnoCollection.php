<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AlumnoCollection extends ResourceCollection
{

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    public function with(Request $request)
    {
        return ["jsonapi" =>
            ["version" => "1.0"]];
    }
}
