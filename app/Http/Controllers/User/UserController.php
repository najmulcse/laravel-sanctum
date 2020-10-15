<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function users(){
        try{

            $user = User::all();

            return response()->json([
               'status_code' => Response::HTTP_OK,
               'data' => $user ?? [],
               'message' => 'Users list'
            ]);

        }catch (\Exception $exception){
            return response()->json([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
               'message' => "Internal Server Error!"
            ]);
        }
    }
}
