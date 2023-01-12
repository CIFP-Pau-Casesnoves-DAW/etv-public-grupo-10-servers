<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioControler extends Controller
{
    public function show($id){
        try {
            $tupla = Usuario::findOrFail($id);
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }


    public function tots(){
        $tuples=Usuario::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    public function borra($id){
        try {
            $tupla = Usuario::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    public function crea(Request $request){
        $reglesvalidacio=[
            'DNI'=>['required'],
            'nom_complet'=>['required','max:300'],
            'direccio'=>[],
            'correu'=>[],
            'telefon'=>['required'],
            'contrasenya'=>['required'],
            'administrador'=>[]
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla=Usuario::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }
}
