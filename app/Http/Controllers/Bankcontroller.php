<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Bank;

class BankController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */

    public function delete($id)
    {
        # code...
        $bank = App\bank::where('id', $id)->get();
        if(!$bank->isEmpty()){
            try {
                $bank = App\bank::where('id', $id)->delete();
                return response()->json(['error'=>false,'message'=>'Banco deshabilitado correctamente.']);
            } catch (Exception $e) {
                return response()->json(['error'=>true,'message'=>'no se pudo deshabilitar banco.','exception'=>$e->getMessage()]);
            }
        }
        return response()->json(['error'=>true,'message'=>'no se encontro banco.']);
    }

    public function add(Request $data)
    {         
        $bank = new App\bank;
        $bank->name = $data['name'];
        $bank->last_connection = Carbon::now();
        $bank->save();
       return response()->json($bank);
    }

 public function all(Request $data)
    {
        $banks = User::get(['id','name']);
        if(!$banks->isEmpty())
        {
            return response()->json(['error'=>false,'message'=>'ok','name'=>$banks]);
        }
        return response()->json(['error'=>true,'message'=>'no hay bancos registrados.','banks'=>null]);
    } 

    public function show($id)
    {
        $bank = bank::where('id',$id)->get();
        if(!$bank->isEmpty())
        {
            $bank = bank::where('id',$id)->first(['id','name']);
            return response()->json(['error'=>false,'message'=>'ok','name'=>$bank]);
        }
        return response()->json(['error'=>true,'message'=>'no se encontro banco.','name'=>null]);
    } 

    public function update(Request $request,$id)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:posts|max:60',
        ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }
        $bank = App\bank::where('id',$id)->get();
        if(!$bank->isEmpty()){
            try {
                if ( $request->has('name') )
                {
                    $bank->name = $request->get('name');
                }  
                $bank = App\bank::where('id',$id)->find($id);          
                $bank->save();
            
                return response()->json([
                    'error' => false,
                    'message' => 'Registro actualizado con existo.'
                    ]);
            } catch (Exception $e) {
                return response()->json([
                'msg' => 'No se pudo editar registro.'
            ]);
            }
        }   
        else{
            return response()->json([
                'msg' => 'No se encontro registro.'
            ]);
        }      
    }
}