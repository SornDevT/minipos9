<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register(Request $request){

        try{

            $check_email = User::where("email",$request->email);

            // return $check_email->count();


            if($check_email->count()){
                $success = false;
                $message = "ອີເມວລ໌ນີ້: ".$request->email." ໄດ້ເຄີຍລົງທະບຽນແລ້ວ!";
            } else {

                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = hash::make($request->password);
                $user->save();

                $success = true;
                $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";

            }
            
            

        } catch (\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            "success" => $success,
            "message" => $message
        ];

        return response()->json($response);

    }

    public function login(Request $request){

        $check_user_login = [
            "email"=>$request->email,
            "password"=>$request->password
        ];

        $token = JWTAUTH::attempt($check_user_login);
        $user = Auth::user();

        if(!$token){
            return response()->json([
                'success' => false,
                'message' => 'ອີເມວລ໌ ຫຼືລະຫັດຜ່ານ ບໍ່ຖຶກຕ້ອງ!'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'ເຂົ້າສູ່ລະບົບສຳເລັດ!',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer'
                ]
            ]);
        }

    }

    public function logout(){

        $token = Auth::getToken();
        $invalidate = Auth::invalidate($token);

        if($invalidate){
            return response()->json([
                'success' => true,
                'message' => 'ອອກຈາກລະບົບສຳເລັດ!'
            ]);
        }
    }
}
