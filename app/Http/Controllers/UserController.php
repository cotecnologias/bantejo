<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\User;

class UserController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return User::findOrFail($id);
    } 
    public function insert(Request $data)
    {         
        $user = new App\User;
        $user->name = $data['name'];
        $user->password = bcrypt($data['password']);
        $user->email = $data['email'];
        $user->api_token = str_random(60);
        $user->last_connection = Carbon::now();
        $user->save();
       return response()->json($user);

    }
}