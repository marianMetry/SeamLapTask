<?php

namespace App\Http\Controllers\Api\PartTwo\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'phone'=>'required|string',
            'date_of_birth'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone'=>$request->phone,
            'date_of_birth'=>$request->date_of_birth,
        ]);

        return response()->json([
            'status' => '200',
            'message' => 'Login Successfully',
            'user' => $user,
        ]);
    }

     //login
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'user_name' =>  'required|string|between:2,100' ,
            'password' => 'required|string' ,
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        $credentials = request(['user_name', 'password']);
        if (! $token = auth::guard('api')->attempt($credentials)) {
            return response()->json(['message' => 'Password is incorrect'], 401);
        }

        return $this->respondWithToken($token);


    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'status'=>200,
            'message'=>'Login Successfully',
            'user'=>Auth::guard('api')->user(),
        ]);
    }

    public function getUserById($id)
{
    $user=User::where('id',$id)->first();
    return Response::json(array(
        'status'=>200,
        'message'=>'true',
        'data'=>$user,
    ));
}

public function getAllUsers()
{
    $users =  User::all();
    return response()->json([
        'success'=>true,
        'message'=> 'Display a listing of the resource.',
        'data'  => $users
    ]);
}

public function deleteUser($id , Request $request)
{
User::where('id',$id)->delete();
return Response::json(array(
    'status'=>200,
    'message'=>'User Deleted Successfully',
));
}

}
