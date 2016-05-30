<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\Car;

class CarController extends Controller
{

    public function create(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|min:1',
            'model' => 'required|min:1',
            'color' => 'required|min:1',
            'year' => 'required|numeric|min:4',
            'price' => 'required|numeric|min:1',
            'user_id' => 'required|numeric|min:1',
        ]);

        if($validator->fails()) {
            return response()->json(['status' => 'failed', 'mensaje' => 'error de validacion', 'errors' => $validator->errors]);
        }

    	return Car::create([
    		'brand' => $request['brand'],
    		'model' => $request['model'],
    		'color' => $request['color'],
    		'year' => $request['year'],
    		'price' => $request['price'],
    		'user_id' => Auth::user()->id,
    		]);
    }

    public function getAll(){
        return response()->json(Car::All());
    }

}
