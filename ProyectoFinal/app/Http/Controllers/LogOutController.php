<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LogOutController extends Controller
{
    /**
     * Cerrar sesión con LogOut.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @OA\Post(
     *    path="/api/Log/out",
     *    tags={"Logout"},
     *    summary="Salir",
     *    description="Cierre sesión",
     *    security={{"bearerAuth":{}}},
     *
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
    public function logout(Request $request)
    {
        if($request->header('Authorization')){
            $key = explode(' ',$request->header('Authorization'));
            $token="xxx";

            if (count($key)==2) {
                $token= $key[1]; //key[0]->Bearer key[1]->token

            }

            $user = Usuario::where('apiToken', $token)->first();

            if (!empty($user)) {
                $user["apiToken"] = "";
                $user->save();
                return response()->json(['status' => 'Logout OK', 'result'], 200);
            }
            else {
                return response()->json(['status' => 'error', 'data' => "Accés no autoritzat"], 401);
            }
        }else{
            return response()->json(['status'=>'Error Logout'],401);
        }
    }
}
