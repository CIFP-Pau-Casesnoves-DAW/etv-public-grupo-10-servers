<?php

namespace App\Http\Controllers;

use App\Models\Idioma;
use App\Models\Servicio;
use Illuminate\Support\Facades\Validator;
use App\Models\TraduccionServicios;
use Illuminate\Http\Request;

class TraduccionServiciosControler extends Controller
{

    /**
     * Descripcion de un Servicio.
     * @urlParam id integer required ID del alojamiento a mostrar.
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tradServi/servicio/{idservicio}/idioma/{ididioma}",
     *     tags={"TraduccionServicios"},
     *     summary="Mostrar una traduccion de servicio por ID",
     *     @OA\Parameter(
     *         description="Id del servicio",
     *         in="path",
     *         name="idservicio",
     *         required=true,
     *         @OA\Schema(type="number"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID de la del servicio")
     *     ),
     *     @OA\Parameter(
     *         description="Id del idioma",
     *         in="path",
     *         name="ididioma",
     *         required=true,
     *         @OA\Schema(type="number"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del idioma")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion del Servicio.",
     *          @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="success"),
     *          @OA\Property(property="data",type="object")
     *           ),
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Hay un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="error"),
     *          @OA\Property(property="data",type="string", example="Servicio no encontrado")
     *           ),
     *     )
     * )
     */
    public function show($idservicio, $ididioma){
        try {

            $checkServ = Servicio::find($idservicio);
            if($checkServ==null){
                return response()->json(['error' => 'La ID servicio no existe'], 404);
            }
            $checkIdioma = Idioma::find($ididioma);
            if($checkIdioma==null){
                return response()->json(['error' => 'La ID idioma no existe'], 404);
            }
            $tupla = TraduccionServicios::where('servicioId', '=', $idservicio)
                ->where('idiomaId', '=', $ididioma)
                ->first();
            if ($tupla) {
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            } else {
                return response()->json(['status' => 'error', 'result' => 'trupla no trobada'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'result' => $e], 400);
        }
    }

    /**
     * Lista todos los Servicios.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/tradServi",
     *     tags={"TraduccionServicios"},
     *     summary="Mostrar todos los Servicios",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todos los Servicios."
     *     ),
     * )
     */
    public function tots(){
        $tuples= TraduccionServicios::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra una traduccion Servicio.
     * @urlParam id integer required ID de la traduccion Servicio a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/tradServi/borra/servicio/{idservicio}/idioma/{ididioma}",
     *    tags={"TraduccionServicios"},
     *    summary="Borra una traduccion servicio",
     *    description="Borra una traduccion Servicio. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="idservicio", in="path", description="Id servicio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="ididioma", in="path", description="Id idioma", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="success"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="error"),
     *         @OA\Property(property="data",type="string", example="ID no encotrada")
     *          ),
     *       )
     *      )
     *  )
     */
    public function borra($idservicio, $ididioma)
    {
        try {
            $checkServ = Servicio::find($idservicio);
            if($checkServ==null){
                return response()->json(['error' => 'La ID servicio no existe'], 404);
            }
            $checkIdioma = Idioma::find($ididioma);
            if($checkIdioma==null){
                return response()->json(['error' => 'La ID idioma no existe'], 404);
            }
            $tupla = TraduccionServicios::where('servicioId', '=', $idservicio)
                ->where('idiomaId', '=', $ididioma)
                ->delete();
            if ($tupla) {
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            } else {
                return response()->json(['status' => 'error', 'result' => 'trupla no trobada'], 401);
            }
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'result' => $e], 400);
        }
    }
    /**
     * Crea un nuevo Servicio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/tradServi/crea",
     *    tags={"TraduccionServicios"},
     *    summary="Crea una traduccion Servicio",
     *    description="Crea una traduccion Servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="servicioId", type="number", format="number", example=1),
     *          @OA\Property(property="idiomaId", type="number", format="number", example=2),
     *          @OA\Property(property="traduccion", type="string", format="string", example="Esto es una traduccion"),
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="success"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="error"),
     *         @OA\Property(property="data",type="string", example="Atributo obligatorio requerido")
     *          ),
     *       )
     *  )
     */
    public function crea(Request $request){
        $reglesvalidacio=[
            'servicioId'=>['required'],
            'idiomaId'=>['required'],
            'traduccion'=>['required']

        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= TraduccionServicios::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    /**
     * Modificar un Servicio.
     * @urlParam id integer required ID del Servicio.
     * @bodyParam NombreServicio string Nombre del Servicio.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar un Servicio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/tradServi/modifica/servicio/{idservicio}/idioma/{ididioma}",
     *    tags={"TraduccionServicios"},
     *    summary="Modifica una traduccion Servicio",
     *    description="Modifica una traduccion Servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="idservicio", in="path", description="Id Servicio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="ididioma", in="path", description="Id idioma", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(property="servicioId", type="number", format="number", example=1),
     *          @OA\Property(property="idiomaId", type="number", format="number", example=2),
     *          @OA\Property(property="traduccion", type="string", format="string", example="Esto es una traduccion"),
     *        ),
     *     ),
     *    @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="success"),
     *         @OA\Property(property="data",type="object")
     *          ),
     *       ),
     *    @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *         @OA\Property(property="status", type="integer", example="error"),
     *         @OA\Property(property="data",type="string", example="Atributo obligatorio requerido")
     *          ),
     *       )
     *  )
     */
    public function modifica(Request $request, $idservicio, $ididioma)
    {
        $reglesvalidacio = [
            'servicioId'=>['filled'],
            'idiomaId'=>['filled'],
            'traduccion'=>['filled']
        ];
        $missatges = [
            'filled' => ':attribute no pot estar buit',
            'unique' => 'Camp :attribute amb valor :input ja hi es'
        ];
        $checkServ = Servicio::find($idservicio);
        if($checkServ==null){
            return response()->json(['error' => 'La ID servicio no existe'], 404);
        }
        $checkIdioma = Idioma::find($ididioma);
        if($checkIdioma==null){
            return response()->json(['error' => 'La ID idioma no existe'], 404);
        }
        $validacio = Validator::make($request->all(), $reglesvalidacio, $missatges);
        if (!$validacio->fails()) {
            TraduccionServicios::where('servicioId', '=', $idservicio)
                ->where('idiomaId', '=', $ididioma)
                ->update($request->all());
            $creada = TraduccionServicios::where('servicioId', '=', $request->servicioId)
                ->where('idiomaId', '=', $request->idiomaId)->first();

            return response()->json(['status' => 'success', 'result' => $creada], 200);
        } else {
            return response()->json(['status' => 'validation error', 'result' => $validacio->errors()], 400);
        }
    }
}
