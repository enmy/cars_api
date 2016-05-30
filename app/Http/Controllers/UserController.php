<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required|min:4',
            'city' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'mensaje' => 'error de validacion', 'errors' => $validator->errors]);
        }

        return response()->json(
        	User::create([
	            'name' => $request['name'],
	            'email' => $request['email'],
	            'password' => bcrypt($request['password']),
	            'city' => $request['city'],
	            'phone' => $request['phone'],
        	])
    	);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'mensaje' => 'error de validacion', 'errors' => $validator->errors]);
        }

    	if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            
            return response()->json([
            	'status' => 'succes',
                'user' => Auth::user(),
            	]);
        }
        else return response(['status' => 'failure'], 401);
    }

    public function logout(){

        Auth::logout();
    }

    public function user($user) {
        $usuario = User::find($user);
       
        if(empty($usuario))
            return response()->json(['status' => 'failure', 'mensaje' => 'Usuario no encontrado']);

        return response()->json($usuario);
    }

    
}
