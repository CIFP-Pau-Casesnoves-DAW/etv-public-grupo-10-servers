<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValoracionControler extends Controller
{
    //
    public function show($idusuari,$idallotgament){
        try {
            $tupla = Valoracion::where('usuari_id','=',$idusuari)
                                ->where('Alojamiento_id','=',$idallotgament)
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


    public function tots(){
        $tuples= Valoracion::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    public function borra($idusuari,$idallotgament){
        try {
            $tupla = Valoracion::where('usuari_id','=',$idusuari)
                ->where('Alojamiento_id','=',$idallotgament)
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

    public function crea(Request $request){
        $reglesvalidacio=[
            'usuari_id'=>['required'],
            'Alojamiento_id'=>['required'],
            'texto'=>['required','max:255'],
            'puntuacion'=>['required']
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla= Valoracion::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }

    public function modifica(Request $request, $idusuari,$idallotgament){
        $tupla = Valoracion::where('usuari_id','=',$idusuari)
            ->where('Alojamiento_id','=',$idallotgament)
            ->first();
        if ($tupla) {
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }else{
            return response()->json(['status'=>'error','result'=>'trupla no trobada'],401);
        }
        $reglesvalidacio=[
            'texto'=>['filled','max:255'],
            'puntuacion'=>['filled']
        ];
        $missatges=[
            'filled'=>':attribute no pot estar buit',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla->update($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'validation error','result'=>$validacio->errors()],400);
        }
   }
}
