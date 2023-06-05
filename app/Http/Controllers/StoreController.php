<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }


    public function index(){
         try{

                $search = \Request::get("search");
                $sort = \Request::get("sort");
                $lp = \Request::get("lp");

                $store = Store::orderBy("id",$sort)
                ->where("name","LIKE","%{$search}%")
                ->paginate($lp)
                ->toArray();

                return array_reverse($store);

                $success = true;
                $message = "ສຳເລັດ!";

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


    public function add(Request $request){
        try{

    
                    $store = new Store([
                        'name' => $request->name,
                        'image' => '',
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);
                    $store->save();
    
                    $success = true;
                    $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";
    
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
}
