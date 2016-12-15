<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\User;
use Validator;

class UserController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
     
     public function all(Request $data)
    {
        $users = User::get(['id','name','email']);
        if(!$users->isEmpty())
        {
            return response()->json(['error'=>false,'message'=>'ok','user'=>$users]);
        }
        return response()->json(['error'=>true,'message'=>'no hay usuarios registrados.','users'=>null]);
    } 
    public function show($id)
    {
        $user = User::where('id',$id)->get();
        if(!$user->isEmpty())
        {
            $user = User::where('id',$id)->first(['id','name','email']);
            return response()->json(['error'=>false,'message'=>'ok','user'=>$user]);
        }
        return response()->json(['error'=>true,'message'=>'no se encontro usuario.','user'=>null]);
    } 
    public function add(Request $data)
    {       
        $validator = Validator::make($data->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>true,'message'=>'error al validar campos.','errors'=>$validator->errors()->all()]);
        }
        else{  
            $user = new App\User;
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);
            $user->email = $data['email'];
            $user->api_token = str_random(60);
            $user->last_connection = Carbon::now();
            $user->last_ip = str_random(15);
            $user->save();            
            return response()->json(['error'=>false,'message'=>'usuario agregado correctamente.','id'=>$user->id]);
        }
    }
    public function delete($id)
    {
        # code...
        $user = App\User::where('id', $id)->get();
        if(!$user->isEmpty()){
            try {
                $user = App\User::where('id', $id)->delete();
                return response()->json(['error'=>false,'message'=>'usuario eliminado correctamente.']);
            } catch (Exception $e) {
                return response()->json(['error'=>true,'message'=>'no se pudo eliminar usuario.','exception'=>$e->getMessage()]);
            }
        }
        return response()->json(['error'=>true,'message'=>'no se encontro usuario.']);
    }
    public function update(Request $request,$id)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|max:255|unique:users',
            'password' => 'min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>true,'message'=>'error al validar campos.','errors'=>$validator->errors()->all()]);
        }
        $user = App\User::where('id',$id)->get();
        if(!$user->isEmpty()){
            try {
                if ( $request->has('name') )
                {
                    $user->name = $request->get('name');
                }
            
                if ( $request->has('password') )
                {
                    $user->password = bcrypt($request->get('password'));
                }
                if ( $request->has('email') )
                {
                    $user->email = $request->get('email');
                }  
                $user = App\User::where('id',$id)->find($id);          
                $user->save();
            
                return response()->json(['error'=>false,'message'=>'usuario editado correctamente.']);
            } catch (Exception $e) {
                return response()->json(['error'=>false,'message'=>'usuario eliminado correctamente.','errors'=>$e->getMessage()]);
            }
        }   
        else{
            return response()->json(['error'=>false,'message'=>'no se encontro usuario.']);
        }      
    }
    public function report($id)
    {
        # code...        
        return response()->json(['error'=>false,'message'=>'no se ha definido ningun reporte.']);
    }
}