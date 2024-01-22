<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class Usercontroller extends Controller
{

    function register(Request $request){
        try{
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return response([
                'message'=>['User registered successfully']
            ],200);
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    function login(Request $request){
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'message'=>['Invalid credentials']
            ],404);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;
        $response =[
            'user'=>$user,
            'token'=>$token
        ];
        // dd($response);
        return response($response,201);
    }
    function logout(Request $request)
    {
        try {
            $token = Auth::user()->currentAccessToken();
            if ($token) {
                $token->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Logout successfully.'
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'unauthorized access.',
                ]);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
