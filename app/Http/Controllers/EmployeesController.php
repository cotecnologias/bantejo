<?php namespace App\Http\Controllers;


class EmployeesController extends Controller {

	public function all(Request $data)
    {
        $employees = Employee::get();
        if(!$employees->isEmpty())
        {
            return response()->json(['error'=>false,'message'=>'ok','employees'=>$employees]);
        }
        return response()->json(['error'=>true,'message'=>'no hay empleados registrados.','employees'=>null]);
    } 
    public function show($id)
    {
        $employee = Employee::where('id',$id)->get();
        if(!$employee->isEmpty())
        {
            $employee = Employee::where('id',$id)->first();
            return response()->json(['error'=>false,'message'=>'ok','employee'=>$employee]);
        }
        return response()->json(['error'=>true,'message'=>'no se encontro empleado.','employee'=>null]);
    } 
    public function add(Request $data)
    {       
        $validator = Validator::make($data->all(), [
            'name' => 'required|max:255',
			'lastname' => 'required|max:255',
			'iduser' => 'required|integer|unique:employees',
			'idoccupation' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>true,'message'=>'error al validar campos.','errors'=>$validator->errors()->all()]);
        }
        else{  
			$user = App\User::where('id',$data['iduser'])->get();
			$occupation = App\User::where('id',$data['idoccupation'])->get();
			if($user->isEmpty()){
				return response()->json(['error'=>true,'message'=>'usuario no encontrado.']);;
			}
			if($occupation->isEmpty()){
				return response()->json(['error'=>true,'message'=>'puesto no encontrado.']);;
			}
            $employee = new App\Employee;
            $employee->name = $data['name'];
			$employee->lastname = $data['lastname'];
			$employee->iduser = $data['iduser'];
			$employee->idoccupation = $data['idoccupation'];
            $employee->save();            
            return response()->json(['error'=>false,'message'=>'empleado agregado correctamente.','id'=>$employee->id]);
        }
    }
    public function delete($id)
    {
        # code...
        $employee = App\Employee::where('id', $id)->get();
        if(!$employee->isEmpty()){
            try {
                $employee = App\Employee::where('id', $id)->delete();
                return response()->json(['error'=>false,'message'=>'empleado eliminado correctamente.']);
            } catch (Exception $e) {
                return response()->json(['error'=>true,'message'=>'no se pudo eliminar empleado.','exception'=>$e->getMessage()]);
            }
        }
        return response()->json(['error'=>true,'message'=>'no se encontro empleado.']);
    }
    public function update(Request $request,$id)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
			'lastname' => 'max:255',
			'iduser' => 'integer|unique:employees',
			'idoccupation' => 'integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>true,'message'=>'error al validar campos.','errors'=>$validator->errors()->all()]);
        }
        $employee = App\Employee::where('id',$id)->get();
        if(!$employee->isEmpty()){
            try {
                if ( $request->has('name') )
                {
                    $employee->name = $request->get('name');
                }
				if ( $request->has('lastname') )
                {
                    $employee->lastname = $request->get('lastname');
                }
				if ( $request->has('iduser') )
                {
					$user = App\User::where('id',$data['iduser'])->get();					
					if($user->isEmpty()){
						return response()->json(['error'=>true,'message'=>'usuario no encontrado.']);;
					}
                    $employee->iduser = $request->get('iduser');
                }
				if ( $request->has('idoccupation') )
                {
					$occupation = App\User::where('id',$data['idoccupation'])->get();
					if($occupation->isEmpty()){
						return response()->json(['error'=>true,'message'=>'puesto no encontrado.']);;
					}
                    $employee->idoccupation = $request->get('idoccupation');
                } 
                $employee = App\Employee::where('id',$id)->find($id);          
                $employee->save();
            
                return response()->json(['error'=>false,'message'=>'empleado editado correctamente.']);
            } catch (Exception $e) {
                return response()->json(['error'=>false,'message'=>'no se pudo actualizar empleado.','errors'=>$e->getMessage()]);
            }
        }   
        else{
            return response()->json(['error'=>false,'message'=>'no se encontro empleado.']);
        }      
    }
    public function report($id)
    {
        # code...        
        return response()->json(['error'=>false,'message'=>'no se ha definido ningun reporte.']);
    }

}
