<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
use App\User;
use App\Car;
use Validator;

class WishController extends Controller
{

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|numeric',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'mensaje' => 'Error de validacion', 'errors' => $validator->errors()]);
        }

    	return Auth::user()->car_wish()->attach($request->car_id);
    }

    public function getWish()
    {
    	return response()->json(Auth::user()->car_wish()->get());
    }

    public function getContact()
    {
        
        $results = DB::select('select wishs.user_id, cars.id as cars_id
                               from users, cars, wishs 
                               where cars.user_id = users.id and
                                     cars.user_id = :user_id and
                                     wishs.car_id = cars.id', ['user_id' => Auth::user()->id]);
    	
        $i = 0;
        foreach ($results as $result) 
        {
            $user = User::find($result->user_id);
            $car = Car::find($result->cars_id);
            $respuesta[$i] = ['user' => $user, 'car' => $car];
            $i++;
        }

        if(!isset($respuesta))
            $respuesta = ['mensaje' => 'no tiene compradores'];
        
        return response()->json($respuesta);
    }
}
