## Definición de API y características
> Un api es un conjunto de reglas
> y protocolos que permiten que diferentes aplicaciones se comuniquen entre
> sí

> Lo estamos haciendo para que lo use cualquier aplicación

> Al proporcionar una interfaz estándar, se utiliza para integrar y utilizar servicios externos de manera eficiente y segura

> Se crean endpoints o URLs que permiten a los clientes realizar solicitudes HTTP para acceder y manipular los datos

## Recomendación Api REST
- Se respetan 6 principios de implementación.
- Es una recomendación, no un estandar o protocolo
- Arquitectura de construcción

## Principios de implementación
### Arquitectura cliente-servidor
- Separa la lógica y la interfaz de usuario de la del servidor
### Arquitectura sin estado
- Cada solicitud del cliente tiene que contener toda la información para entender 
y procesar la solicitud

- El estado de sesión de usuario se mantiene en el cliente (tokens)
### Cacheable
- Almacenamiento en cache
### Sistema de capas

### Código bajo demanda (opcional)

### Interfaz uniforme

> Identificacion de recursos 
- Cada recurso se identifica mediante una URI
>Manipulación de recursos
- Los recursos pueden ser manipulados en diferentes formatos (json o XML)
> Mensajes autodescriptivos 
- Cada mensaje tiene que incluir suficiente información para saber cómo porcesar la información
> HATEOAS: Hypertext As The Engine Of Application State
- El servidor debe de facilitar
información que nos diga cómo navegar por
la API
## Rest FULL
- Además de seguir los 6 pricipios de implementación, utiliza **http** para la implementación
### HTTP atiende a diferentes solicitudes
> GET
- Solicitar un recurso 
> POST  
- Enviar un recurso al servidor 
> DELETE 
- Borrar un recurso
> PUT 
- Sustituir un recurso por otro, cambio total.
> PATCH
- Modificar algún valor de recursos, cambio parcial.
## Recurso
> Es una entidad que podemos identificar y nombrar, y generalmente se corresponde con los registros en las tablas.
## Representación 
> Forma concreta en la que se puede ver un recurso para enviarlo o recibirlo. Generalmente JSON

### Payload del api 

```bash
{
"id": 1,
"nombre": "María Ruiz",
"correo":"maria@gmail.net",
},
```
1. Aparece en todas las solicitudes salvo el **get**
2. Todas son correctas si son conocidas y gestionadas por el **cliente**

## Respuestas HTTP
> El servidor entregará  la respuesta con un código de estado
### 1xx Información
### 2xx ÉXITO
* 200 ok, 
* 201 Created, 
* 204 No content
### 3xx REDIRECCIONAMIENTO
 
*   301 Movido
*   302 y 303 otra url
*   307 Redirección temporal
*   308 Redirección permanente

###  4xx ERROR EN EL CLIENTE
*   400 Mala solicitud
*   401 Unauthorized
*   403 Forbidden
### 5xx ERROR EN EL SERVIDOR
*   500 Error del Servidor
*   502 Puerta GateGay incorrecta
*   503 Servicio no alzanzable

## JSON:API Specification
* Intento de estandarizar la respuesta json, la comunicación entre cliente y
  servidor
### Estructura del json
* data y errors
> Excluyentes entre sí.

> data es el principal y por tanto tiene más contenido
* meta
> Info libre
* included
* links
* jsonapi
```bash
"data": {
    "type": "project",
    "id": (string)"1",
    "attributes": {
      "id": "1",
      "titulo": "....",
    },
    "relationships": {
      "users": {
        "data": {
          "type": "users",
          "id": "3”
         }
      },
      "teachers": {  // . . .
      }
    },
    "links": {
      "self": "http://localhost:8000/projects/1"
    },
    "meta": {
    }
  }
```
## Comunicación entre cliente y API
- Tanto la solicitud, como la respuesta deben contener el header
> application/vnd.api+json
### Request GET, POST, PATCH, DELETE
- Accept: application/vnd.api+json 
- 406 Not Acceptable
### Request POST, PATCH 
- Content-Type:
- application/vnd.api+json
- 415 Unsupported Media Type


### Response All 
- Content-Type: application/vnd.api+json

- 415 Unsupported Media type

### Creación de proyecto laravel

```bash
laravel new api_ejemplo --git
```
* El --git para que cree un proyecto de git
> Establecer las rutas en api.php
* Se diferencian en los middleware que se aplican: en un caso los web,   y en el otro los api. 
* Los middleware, están descritos en el fichero kernel
### Api: Realización
* throttle  es un middleware que se  utiliza para limitar el número de
  solicitudes.

**Por ejemplo**
> \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class

 > \Illuminate\Routing\Middleware\ThrottleRequests::class.':200,1',
* de trottle: por ejemplo podríamos establecer un límite de 200 peticiones por minuto
   de throttle (limitar o restringir)
   
 \Illuminate\Routing\Middleware\SubstituteBindings::class  

* SubstituteBindings se utiliza para cargar automáticamente los modelos
  basados en los parámetros de ruta. 
* Cuando un
  método recibe un $id de un modelo realiza el binding y obtiene el modelo cuyo id coincida con el entero

- **En las API  no necesitamos sesiones, cookies ni compartir errores entre ficheros (son los
  middleware que aparecen en las rutas de grupo de web).**

### Creación de modelo
```bash
 cd api_ejemplo
 ```

```bash
php artisan make:model Ejemplo -mf --api
```

* Crea un controlador EjemploController

* Crea un modelo llamado Ejemplo.
En el modelo
```bash
class Ejemplo extends Model
{
    use HasFactory;

    protected $fillable=["nombre","direccion","email"];
}
```

* **-m** Esta opción indica a Artisan que genere una migración para este modelo.
* **-f** Esta opción indica a Artisan que también genere una fábrica para este modelo.
* **--api** Esta opción indica a Artisan que también genere un controlador de recursos API para este modelo.

### Para crear las rutas (una vez echo lo anterior)
> Ponerlo dentro del fichero api.php
```bash
Route::apiResource("ejemplos", EjemploController::class);
```
### Listado de rutas (Comprobación de rutas)
```bash
php artisan route:list –path='api/ejemplo'
```
### Crear la tabla a partir de la migración

```bash
public function up(): void{
Schema::create('alumnos', function (Blueprint $table) {
$table->id();
$table->string('nombre');
$table->string('password');
$table->string('email');
$table->timestamps();
});
}
```
### Creamos los registros en el factory
```bash

public function definition(): array
{
   return [
'nombre' =>$this->faker->name(),
'password' => bcrypt('12345678'),
'email' => $this->faker->email(),
   ];
}
```
### Población en el seeder
```bash
public function run(): void{
\App\Models\Alumno::factory(10)->create();
   }
```
### Configuración fichero .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_alumnos
DB_USERNAME=root
DB_PASSWORD=
```
### Migracion y seeder
```bash
php artisan migrate:fresh –seed
```
### Postman
>Instalación
```bash
sudo snap install postman
```

### Método index
> http://localhost:8000/api/ejemplos => obtener todos los ejemplos

> http://localhost:8000/api/ejemplos/1 => obtener los ejemplos de id 1

````bash
public function index()
{
$ejemplos= Ejemplo::all();
return response()->json($ejemplos);
}
````
### AlumnoResource
>Método toArray
```bash
public function toArray(Request $request): array
{
   return [
       "id" => (string)$this->id,
       "type" => "Ejemplos",
       "attributes" => [
           "id" => $this->id,
           "nombre" => $this->name,
           "email" => $this->email
           ],
       'links' => [
           'self' => url('api/ejemplos/' . $this->id)
       ]];
}
```
## AlumnoController
```bash
public function index()
{
   $ejemplos = Ejemplo::all();
   return new EjemploCollection($ejemplos);
}
```
### AlumnoCollection
```bash
Ahora el index, llamará a Collection que retornará la colección (collection), pero de 
forma implícita cada elemento de la colección será adaptado a un recurso
public function toArray(Request $request): array
{
  return ["data"=>$this->collection];
}
```
>Queremos agregar algún campo mas, en el resource lo añade al elemento del resource

> En el collection, lo añadirá al json que retorna 
```bash
public function with(Request $request)
{
   return ["jsonapi" => 
["version" => "1.0"]];
}
```

### Crear middleware
```bash
php artisan make:middleware HeaderMiddleware
```
> /home/alumno/laravel/api_ejemplo/app/Http/Middleware/HeaderMiddleware.php
```bash
public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('accept') != 'application/vnd.api+json') {
            return response()->json([
                'error' => 'Error procesando la respuesta',
                'status' => 406,
                "details" => 'Error procesando la respuesta'
            ], 406);
        }
        return $next($request);
    }
```

### El método show visualiza un registro concreto
```bash
public function show( int $id)
{
   $resource = Alumno::find($id);
   if (!$resource) {
       return response()->json([
           'errors' => [
               [
                   'status' => '404',
                   'title' => 'Resource Not Found',
                   'detail' => 'The requested resource does not exist or could not be found.'
               ]
           ]
       ], 404);
   }
   return     new AlumnoResource($resource);
}

```
Si un recurso no se encuentraen GET, se devuelve un 404.

Middleware SubstituteBindings
$ejemplo es el valor del parámetro en la ruta

Se produce un envoltorio del valor al modelo Ejemplo, busca el ejemplo con id de ese valor y $ejemplo pasa a ser un modelo Ejemplo, con el contenido con su id.

####En el middleware
Metodo POST
```bash
if ($request->isMethod('POST')||$request->isMethod('PATCH') ){
           if ($request->header('content-type')!=="application/vnd.api+json"){
//                throw new \HttpException(415);
               return response()->json([
                   'error' => 'Unsupportted Media Type',
                   'status' => 415
               ], 415);
           }
       }
```
###Validar datos del formulario
un ModeloRequest

```bash
php artisan make:request EjemploStoreRequest
```

```bash
php artisan make:request EjemploUpdateRequest
```
Extienden de FormRequest, autorizan la accion y validan los campos del recurso Ejemplo.

####El StoreRequest
```bash
class EjemploStoreRequest extends FormRequest
{
   public function authorize(): bool
   {
       return true;
   }
   /**
    * Get the validation rules that apply to the request.
    */
   public function rules(): array
   {
       return [
               'data.attributes.nombre' => 'required|string|max:255',
               'data.attributes.email' => 'required|string|email|max:255|unique:users',
               'data.attributes.password' => 'required|string|min:8',
         
       ];
   }
}
```


## Clase Handler

 _api_ejemplo/app/Exceptions/Handler.php_
```bash
class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Errores de base de datos)
        if ($exception instanceof QueryException) {
            return response()->json([
                'errors' => [
                    [
                        'status' => '500',
                        'title' => 'Database Error',
                        'detail' => 'Error procesando la respuesta. Inténtelo más tarde.'
                    ]
                ]
            ], 500);
        }

        if ($exception instanceof ValidationException) {//reciba por post los campos y no cumpla
            return $this->invalidJson($request, $exception);
        }
        // Delegar a la implementación predeterminada para otras excepciones no manejadas
        return parent::render($request, $exception);
    }

    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {//devolver un error por cada uno de no requisitos del formulario
        return response()->json([
            'errors' => collect($exception->errors())->map(function ($message, $field) use
            ($exception) {
                return [
                    'status' => '422',
                    'title'  => 'Validation Error',
                    'details' => $message[0],
                    'source' => [
                        'pointer' => '/data/attributes/' . $field
                    ]
                ];
            })->values()
        ], $exception->status);
    }
}
```

invalidJson
```bash
 protected function invalidJson($request, ValidationException $exception): JsonResponse
    {//devolver un error por cad uno de no requisitos del formulario
        return response()->json([
            'errors' => collect($exception->errors())->map(function ($message, $field) use
            ($exception) {
                return [
                    'status' => '422',
                    'title'  => 'Validation Error',
                    'details' => $message[0],
                    'source' => [
                        'pointer' => '/data/attributes/' . $field
                    ]
                ];
            })->values()
        ], $exception->status);
    }
```
- Gestionar excepciones de formulario de acceso a bases de datos

#### Método GET
En postman, se comprueba la solicitud
con http://localhost:8080/api/alumnos
y se introduce el verbo get, se le da a send
Un alumno solo es :  

http://localhost:8080/api/alumnos/id

El POST
Ir a body de postman, 
dentro de form-data 
poner llaves de la tabla con sus valores

para pasar un post, especificarlo por raw

```bash
{
 "data": {
  "attributes": {
    "key_1":"valor_1"
    [...]
  }
 }
}
```

En el controlador el store

```bash
public function store(Request $request)
{
$alumno = new Alumno($request->input());
$alumno->password = bcrypt($alumno->password);
$alumno->save();
return response()->json($ejemplo,201);
}
```

Se cifra la contraseña con bcrypt
Se recomienda pasarle un 201 (recurso creado)
## Controlador

### Update
En postman, 
PUT(completa)
Aquí se editan todos.
PATCH(parcial)
Como es parcial no se le pasan todos los datos, si no sólo los que se vayan a cambiar.
```bash 
public function update(Request $request, int $id)
{

    $alumno = Alumno::find($id);
    if (!$alumno) {
        return response()->json([
            "errors" => [
                "status" => 404,
                "title" => "Resource not found",
                "details" => "$id Alumno not found"
            ]
        ], 404);
    }
    $verbo = $request->method();
    //En función del verbo creo unas reglas de
    // validación u otras
    if ($verbo == "PUT") { //Valido por put
        $rules = [
            "data.attributes.nombre" => ["required", "min:5"],
            "data.attributes.direccion" => "required",
            "data.attributes.email" => ["required", "email",
                Rule::unique("alumnos", "email")
                    ->ignore($this->alumno)]
        ];

    } else { //Valido por PATCH
        if ($request->has("data.attributes.nombre"))
            $rules["data.attributes.nombre"]= ["required", "min:5"];
        if ($request->has("data.attributes.direccion"))
            $rules["data.attributes.direccion"]= ["required"];
        if ($request->has("data.attributes.email"))
            $rules["data.attributes.email"]= ["required", "email",
                Rule::unique("alumnos", "email")
                    ->ignore($this->alumno)];
    }
```


Leer los datos y con ellos, actualizar el recurso

Se devuelve un 200

### Delete
http://localhost:8080/api/alumnos/id

```bash

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
```
Devuelvo un 404 si no se ha encontrado
Si se encuentra, se borra (delete())

se devuelve un noContent o 204




