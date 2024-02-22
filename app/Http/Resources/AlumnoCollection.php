<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
class AlumnoCollection
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
