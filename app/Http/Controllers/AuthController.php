<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_name'       => ['required', 'unique:users', 'string', 'max:255'],
            'date_of_birth'   => ['required', 'date', 'before:today'],
            'phone_number'    => ['required', 'unique:users', new PhoneNumber,'between:6,18'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'        => ['required', 'confirmed', 'min:6'],
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        $user = User::create($request->all());

        $response['success'] = true;
        $response['user'] = $user;
        
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name'       => ['required', "exists:users", 'string', 'max:255'],
            'password'        => ['required'],
        ]);
    
        if ($validator->fails()) {
            return $validator->messages();
        }

        if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
            $response['success'] = true;
            $response['user'] = auth()->user();
            return response()->json($response);
        } else {
            $response['success'] = false;
            $response['message'] = "wrong password";
            return response()->json($response);
        }

    }
}
