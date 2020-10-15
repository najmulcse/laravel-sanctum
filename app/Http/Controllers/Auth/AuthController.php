<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            $request->validate([
                "email" => "email|required",
                "password" => "required"
            ]);
            $credentials = request(["email", "password"]);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    "status_code" => 500,
                    "message" => "Unauthorized"
                ]);
            }
            $user = User::where("email", $request->email)->first();
            if ( ! Hash::check($request->password, $user->password, [])) {
                throw new \Exception("Error in Login");
             }
            $tokenResult = $user->createToken("authToken")->plainTextToken;
                    return response()->json([
                        "status_code" => 200,
                        "access_token" => $tokenResult,
                        "token_type" => "Bearer",
                    ]);
                } catch (Exception $error) {
                    return response()->json([
                        "status_code" => 500,
                        "message" => "Error in Login",
                        "error" => $error,
                        ]);
            }
    }

    public function revoke(Request  $request){
        try{

            $request->user()->currentAccessToken()->delete();
            return response()->json([
                "status_code" => 200,
                'message' => 'Current access token revoked.'
            ]);
        }catch (\Exception $exception){
            return response()->json([
                "status_code" => 500,
                "message" => "Revoked failed",
                "error" => '',
            ]);
        }
    }
}
