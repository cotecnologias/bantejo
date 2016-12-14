<?php 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\User;
use App\Page;
use App\Permission;
use App\Employee;
use App\Occupation;

class Api_authsController extends Controller {

	public function checkAuth(Request $data)
	{
		# code...
		$token = $data->header('token');
		$user = new App\User;
		$user = App\User::where('api_token',$token)->where('api_token','!=','')->get();
		if(!$user->isEmpty()){
			$user = App\User::where('api_token',$token)->first();
			$lastCon = Carbon::parse($user->last_connection);
			$now = Carbon::now();
			if($user->last_ip != $data->ip()){
				return response()->json(['error'=>true,'message'=>'ip no coincide']);
			}
			if($now->diffInDays($lastCon)>0){
				return response()->json(['error'=>true,'message'=>'limite de conexion alcanzado']);
			}
			return response()->json(['error'=>false,'message'=>'ok','user'=>$user]);
		}
		else{
			return response()->json(['error'=>true,'message'=>'token inexistente o no coincide']);
		}
	}
	public function checkRole(Request $data)
	{
		# code...
		$auth = $this->checkAuth($data);
		if(!$auth->getData()->error){
			$user = $auth->getData()->user;
			$path = $data->segments();
			$page = App\Page::where('url',$path[0])->get();
			if(!$page->isEmpty()){
				$page = App\Page::where('url',$path[0])->first();
				$permission = App\Permission::where('iduser',$user->id)->where('idpage',$page->id)->get();
				if(!$permission->isEmpty()){
					$permission = App\Permission::where('iduser',$user->id)->where('idpage',$page->id)->first();
					switch ($path[1]) {
						case 'show':
							if($permission->show == 1)
								return response()->json(['error'=>false,'message'=>'rol ok']);
							break;
						case 'all':
							if($permission->show)
								return response()->json(['error'=>false,'message'=>'rol ok']);
							break;
						case 'add':
							if($permission->insert)
								return response()->json(['error'=>false,'message'=>'rol ok']);
							break;
						case 'update':
							if($permission->edit)
								return response()->json(['error'=>false,'message'=>'rol ok']);
							break;
						case 'delete':
							if($permission->delete)
								return response()->json(['error'=>false,'message'=>'rol ok']);
							break;
						case 'report':
							if($permission->report)
								return response()->json(['error'=>false,'message'=>'rol ok']);
							break;
						default:
							return response()->json(['error'=>true,'message'=>'no tiene ese permiso.']);
					}
				}
				return response()->json(['error'=>true,'message'=>'no tiene acceso a esta ruta.']);
			}
			return response()->json(['error'=>true,'message'=>'no existe ruta.']);
		}
		else{
			if($auth->getData()->message != 'token inexistente o no coincide'){
				return response()->json(['error'=>true,'message'=>$auth->getData()->message]);
			}
			$this->Logout($data);
			return response()->json(['error'=>true,'message'=>$auth->getData()->message]);
		}
	}

	public function LogOut(Request $data)
	{
			$token = $data->header('token');
			$user = new App\User;
			$user = App\User::where('api_token',$token)->where('api_token','!=','')->get();
			if(!$user->isEmpty()){
				$user = App\User::where('api_token',$token)->first();
				$user->last_ip = str_random(15);
				$user->api_token = str_random(60);
				$user->save();
				return response()->json(['error'=>false,'message'=>'LogOut OK.']);
			}
			else{
				return response()->json(['error'=>true,'message'=>'token no existe.']);
			}
	}
	
	public function LogIn(Request $data)
	{
		# code...		
		$user = new App\User;
		$user = App\User::where('email',$data->email)->get();
		if(!$user->isEmpty()){
			$user = App\User::where('email',$data->email)->first();
			if(password_verify($data->password, $user->password)){
				$user->last_ip = $data->ip();
				$user->api_token = str_random(60);
				$user->last_connection = Carbon::now();
				$user->save();
				return response()->json(['error'=>false,'message'=>'LogIn correcto.','token'=>$user->api_token,'nombre'=>$user->name]);
			}
			else{
				return response()->json(['error'=>true,'message'=>'Contraseña erronea.']);
			}			
		}
		return response()->json(['error'=>true,'message'=>'Email incorrecto.']);
	}
	
}
