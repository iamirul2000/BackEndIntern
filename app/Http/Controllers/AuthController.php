<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request) 
    {
        
        $fields = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|unique:users,email',
            'password'=>'required|string',
            'role'=>'required|string',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role' => $fields['role'],
        ]);

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response,201);
    }

    public function login(Request $request) 
    {
       
        $fields = $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);

        if (Auth::attempt($fields)) {
            
            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            //$encryptedToken = Crypt::encryptString($token);

            return response()->json([
                'users' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'api_token' => $token,
                ],
            ]);
        }

        // $user = User::where('email', $fields['email'])->first();

        //  if(!$user || !Hash::check($fields['password'], $user->password)){
        //     return response()->json('Wrong Credentials');
        // }

        // $token = $user->createToken('token')->plainTextToken;

        // $response = [
        //     'user' => $user,
        //     'token' => $token,
        // ];

        // return response()->json($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json('Logged Out');
    }
}
