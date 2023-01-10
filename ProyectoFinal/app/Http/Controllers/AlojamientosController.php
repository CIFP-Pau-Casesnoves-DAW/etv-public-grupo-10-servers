<?php

namespace App\Http\Controllers;

use App\Models\Editor;
use Illuminate\Http\Request;
use App\Models\Alojamiento;
use Illuminate\Support\Facades\Validator;

class AlojamientosController extends Controller
{
    public function show($id){
            try {
                $tupla = Alojamiento::findOrFail($id);
                return response()->json(['status' => 'success', 'result' => $tupla], 200);
            }catch (\Exception $e){
                return response()->json(['status'=>'error','result'=>$e],400);
            }
        }


    public function tots(){
        $tuples=Alojamiento::paginate(10);
        return response()->json(['status'=>'success','result'=>$tuples],200);
    }

    public function borra($id){
        try {
            $tupla = Alojamiento::findOrFail($id)->delete();
            return response()->json(['status' => 'success', 'result' => $tupla], 200);
        }catch (\Exception $e){
            return response()->json(['status'=>'error','result'=>$e],400);
        }
    }

    public function crea(Request $request){
        $reglesvalidacio=[
            'nombre'=>['required','max:100','unique:alojamientos,nombre'],
            'adresa'=>['required','max:300'],
            'numpero_personas'=>['required'],
            'numero_habitaciones'=>['required'],
            'numero_camas'=>['required'],
            'numero_banos'=>['required'],
            'tipo_alojamiento'=>['required'],
            'tipo_vacacional'=>['required'],
            'categoria'=>['required'],
            'municipio'=>['required'],
            'usuari'=>['required'],
        ];
        $missatges=[
            'required'=>'El camp :attribute es obligat',
            'unique'=>'Camp :attribute amb valor :input ja hi es'
        ];
        $validacio=Validator::make($request->all(),$reglesvalidacio,$missatges);
        if(!$validacio->fails()){
            $tupla=Alojamiento::create($request->all());
            return response()->json(['status'=>'success','result'=>$tupla],200);
        }else {
            return response()->json(['status'=>'error','result'=>$validacio->errors()],400);
        }
    }
}
