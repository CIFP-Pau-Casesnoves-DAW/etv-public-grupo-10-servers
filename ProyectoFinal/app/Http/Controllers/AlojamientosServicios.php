<?php

namespace App\Http\Controllers;

use App\Models\Alojamiento;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlojamientosServicios extends Controller
{
    /**
     * Descripcion de una Valoracion.
     * @urlParam id integer required ID de la Valoracion a mostrar.
     * Display the specified resource.
     *
     * @param  int  $idusuari
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/AlojaServi/servicio/{idservei}/alojamiento/{idallotjament}",
     *     tags={"AlojamientosServicios"},
     *     summary="Mostrar una Valoracion por ID servicio y la ID de alojamiento",
     *      @OA\Parameter(name="idservei", in="path", description="Id del servicio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="idallotjament", in="path", description="Id del alojamiento", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *
     *
     *     @OA\Response(
     *         response=200,
     *         description="Informacion de la Valoracion.",
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
     *          @OA\Property(property="data",type="string", example="Valoracion no encontrada")
     *           ),
     *     )
     * )
     */
    public function show($idservei,$idallotjament){
        try {
            $checkServi = Servicio::find($idservei);
            if($checkServi==null){
                return response()->json(['error' => 'La ID servicio no existe'], 404);
            }
            $checkAloja = Alojamiento::find($idallotjament);
            if($checkAloja==null){
                return response()->json(['error' => 'La ID alojamiento no existe'], 404);
            }
            $tupla = \App\Models\AlojamientosServicios::where('servicioId','=',$idservei)
                ->where('alojamientoId','=',$idallotjament)
                ->first();
            if ($tupla) {
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }else{
                return response()->json(['status'=>'error','result'=>'trupla no trobada'],401);
            }
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Descripcion de una AlojamientosServicios.
     * @urlParam id integer required ID de la alojamiento a mostrar.
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/AlojaServi/aloja/{AlojamientoId}",
     *     tags={"AlojamientosServicios"},
     *     summary="Mostrar servicios por ID alojamiento",
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         description="Id del Alojamiento",
     *         in="path",
     *         name="AlojamientoId",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="id", value="1", summary="Introduce el numero de ID del alojamiento")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Informacion del servicio.",
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Hay un error.",
     *         @OA\JsonContent(
     *          @OA\Property(property="status", type="string", example="error"),
     *          @OA\Property(property="data",type="string", example="Valoracion no encontrada")
     *           ),
     * )
     * )
     */
    public function mostraAloSer($idallotjament)
    {
        try {

            $checkAloja = Alojamiento::find($idallotjament);
            if($checkAloja==null){
                return response()->json(['error' => 'La ID alojamiento no existe'], 404);
            }

            $tupla = \App\Models\AlojamientosServicios::where('alojamientoId','=', $idallotjament)->get();


            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Lista todas los servicios.
     *
     *
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/AlojaServi",
     *     tags={"AlojamientosServicios"},
     *     summary="Mostrar todas las servicios con su ID alojamiento",
     *     @OA\Response(
     *         response=200,
     *         description="Mostrar todas las Valoraciones."
     *     ),
     * )
     */
    public function tots(){
        $tuples= \App\Models\AlojamientosServicios::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    /**
     * Borra una Valoracion.
     * @urlParam id integer required ID de la Valoracion a borrar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Delete(
     *    path="/api/AlojaServi/borra/servicio/{idservei}/alojamiento/{idallotjament}",
     *    tags={"AlojamientosServicios"},
     *    summary="Borra un servicio por su ID y la ID alojamiento",
     *    description="Borra un servicio asociado a un alojamiento. Solo por Administradores",
     *    security={{"bearerAuth":{}}},
     *    @OA\Parameter(name="idservei", in="path", description="Id del servicio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="idallotjament", in="path", description="Id del alojamiento", required=true,
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
    public function borra($idservei,$idallotjament){
        try {
            $checkServi = Servicio::find($idservei);
            if($checkServi==null){
                return response()->json(['error' => 'La ID servicio no existe'], 404);
            }
            $checkAloja = Alojamiento::find($idallotjament);
            if($checkAloja==null){
                return response()->json(['error' => 'La ID alojamiento no existe'], 404);
            }
            $tupla = \App\Models\AlojamientosServicios::where('servicioId','=',$idservei)
                ->where('alojamientoId','=',$idallotjament)
                ->delete();
            if ($tupla) {
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }else{
                return response()->json(['status'=>'error','result'=>'trupla no trobada'],401);
            }
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    /**
     * Crea un nuevo alojamiento servicio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/AlojaServi/crea",
     *    tags={"AlojamientosServicios"},
     *    summary="Crea un servicio asociado a una ID alojamiento",
     *    description="Crea un servicio. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *
     *           @OA\Property(property="servicioId", type="number", format="number", example=2),
     *           @OA\Property(property="alojamientoId", type="number", format="number", example=1),
     *
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
            'alojamientoId'=>['required'],
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= \App\Models\AlojamientosServicios::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    /**
     * Modificar una Valoracion.
     * @urlParam usuari_id integer required ID de la Valoracion.
     * @urlParam Alojamiento_id integer required ID de la Valoracion.
     * @bodyParam textp string Contenido de la Valoracion.
     * @bodyParam puntuacion integer Esto es la Puntuacion de la Valoracion.
     * @response scenario=success {
     *  "status": "success",
     * }
     * @response status=400 scenario="validation error" {"status": "Validation error"}
     */

    /**
     * Modificar una Valoracion.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Put(
     *    path="/api/AlojaServi/modifica/servicio/{idservei}/alojamiento/{idallotjament}",
     *    tags={"AlojamientosServicios"},
     *    summary="Modifica una Valoracion",
     *    description="Modifica una Valoracion. Solo por Administradores.",
     *    security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="idservei", in="path", description="Id del servicio", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="idallotjament", in="path", description="Id del alojamiento", required=true,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *           @OA\Property(property="servicioId", type="number", format="number", example=2),
     *           @OA\Property(property="alojamientoId", type="number", format="number", example=1),
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
    public function modifica(Request $request, $idservei,$idallotjament){

        $reglesvalidacio=[
            'servicioId'=>['filled'],
            'alojamientoId'=>['filled'],
        ];
        $missatges=[
            'filled'=>':attribute no pot estar buit',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $checkServi = Servicio::find($idservei);
        if($checkServi==null){
            return response()->json(['error' => 'La ID servicio no existe'], 404);
        }
        $checkAloja = Alojamiento::find($idallotjament);
        if($checkAloja==null){
            return response()->json(['error' => 'La ID alojamiento no existe'], 404);
        }
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            \App\Models\AlojamientosServicios::where('servicioId', '=', $idservei)
                ->where('alojamientoId', '=', $idallotjament)
                ->update($request->all());
            $creada = \App\Models\AlojamientosServicios::where('servicioId', '=', $request->servicioId)
                ->where('alojamientoId', '=', $request->alojamientoId)->first();
            return response()->json(['status'=>'success','result'=>$creada],200);
        }else {
            return response()->json(['status'=>'validation error','result'=>$validacio->errors()],400);
        }
    }
}
