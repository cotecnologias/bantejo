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
    public function show($id)
    {
        return Bank::findOrFail($id);
    } 
    public function insert(Request $data)
    {         
        $bank = new App\bank;
        $bank->name = $data['name'];
        $bank->last_connection = Carbon::now();
        $bank->save();
       return response()->json($bank);
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