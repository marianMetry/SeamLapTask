<?php

namespace App\Http\Controllers\Api\PartTwo\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class EditProfileController extends Controller
{

    public function Editprofile( Request $request)
    {
            $validator = Validator::make($request->all(),[
                'user_name'=>'required|string',
                'phone'=>'required|string',
                'email' => 'required|unique:users,email,'.auth('api')->user()->id,
            ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()->first(),'status'=> 422
            ]);
        }
        try {
            $user=User::where('id',Auth::guard('api')->user()->id)->first();
            DB::beginTransaction();
                $users= User::where('id',auth('api')->user()->id)->update([
                'email' => $request->email,
                'user_name'=>$request->user_name,
                'phone'=>$request->phone,
                ]);
                DB::commit();
                return Response::json(array(
                    'status'=>200,
                    'message'=>'User Updated Successfuly',
                ));
                }
                catch (\Exception $ex) {
                DB::rollback();
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }
    }
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password'=>'required',
            'password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()->first(),'status'=> 422
            ]);
        }
        $user=Auth::guard('api')->user();
        if(Hash::check($request->old_password,$user->password)){
            User::findOrfail(Auth::guard('api')->user()->id)->update([
                'password'=>Hash::make($request->password)
            ]);
            return response()->json([
                'message'=>'Password Changed Successfully',
            ],200);
        }else
        {
            return response()->json([
                'message'=>'Password Cant Changed',
            ],400);
        }

    }
}
