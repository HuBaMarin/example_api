<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoFormRequest;
use App\Http\Requests\UpdateAlumnoFormRequest;
use App\Http\Resources\AlumnoCollection;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\lessThanOrEqual;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $alumnos = Alumno::all();
        return new AlumnoCollection($alumnos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datos = $request->input("data.attributes");
        $alumnos = new Alumno($datos);
        $alumnos->save();
        return new AlumnoResource($alumnos);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $resource = Alumno::find($id);

        if (!$resource) {
            return response()->json([
                'errors' => [
                    [
                        'status' => '404',
                        'title' => 'Resource Not Found',
                        'detail' => $id.' Alumno does not exist or could not be found.'
                    ]
                ]
            ], 404);
        }
        return new AlumnoResource($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAlumnoFormRequest $request, int $id)
    {
        //
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'errors' => [
                    [
                        'status' => '404',
                        'title' => 'Resource Not Found',
                        'detail' => $id.' Alumno not found'
                    ]
                ]
            ], 404);
        }

        $verbo = $request->method();
        if ($verbo == "PUT") { //Valido por put
            $rules = [
                "data.attributes.nombre" => ["required", "min:5"],
                "data.attributes.direccion" => "required",
                "data.attributes.email" => ["required", "email",
                    Rule::unique("alumnos", "email")
                        ->ignore($alumno)]
            ];

        } else { //Valido por PATCH no van todos
            if ($request->has("data.attributes.nombre"))
                $rules["data.attributes.nombre"]= ["required", "min:5"];
            if ($request->has("data.attributes.direccion"))
                $rules["data.attributes.direccion"]= ["required"];
            if ($request->has("data.attributes.email"))
                $rules["data.attributes.email"]= ["required", "email",
                    Rule::unique("alumnos", "email")
                        ->ignore($alumno)];
        }

//
//        $datos->update($request->input("data.attributes"));
        $datos_validados = $request->validate($rules);

        foreach ($datos_validados['data']['attributes'] as $campo=>$valor){
            $datos[$campo]=$valor;
        }
        $alumno->update($datos);
        return new AlumnoResource($alumno);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {

        $resource = Alumno::find($id);

        if (!$resource) {
            return response()->json([
                'errors' => [
                    [
                        'status' => '404',
                        'title' => 'Resource Not Found',
                        'detail' => $id.' Alumno not found'
                    ]
                ]
            ], 404);
        }
        $resource->delete();

        return response()->noContent();
    }
}
