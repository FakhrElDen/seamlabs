<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function users()
    {
        $users = User::get()->toArray();
        $response['success'] = true;
        $response['users'] = $users;
        return response()->json($response);
    }

    public function user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => ['required', "exists:users"]
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        $user = User::find($request->id)->first();

        $response['success'] = true;
        $response['user'] = $user;
        return response()->json($response);
    }
    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'              => ['required', 'exists:users'],
            'user_name'       => ['unique:users', 'string', 'max:255'],
            'date_of_birth'   => ['date', 'before:today'],
            'phone_number'    => ['unique:users', new PhoneNumber,'between:6,18'],
            'email'           => ['string', 'email', 'max:255', 'unique:'.User::class],
            'password'        => ['confirmed', 'min:6'],
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        User::find($request->id)->update($request->all());

        $response['success'] = true;
        $response['message'] = "user updated successfully";
        
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'   => ['required', "exists:users"]
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        } 

        User::find($request->id)->delete();

        $response['success'] = true;
        $response['message'] = "user deleted successfully";
        return response()->json($response);
    }
}
