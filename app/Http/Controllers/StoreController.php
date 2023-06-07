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
                // $message = "ການບັນທຶກຂໍ້ມູນບໍ່ສຳເລັດ! ກະລຸນາຕິດຕໍ່ Admin!";
            }
    
            $response = [
                "success" => $success,
                "message" => $message
            ];
    
            return response()->json($response);
    }

    public function edit($id){

        //ແບບງ່າຍ
        $store = Store::find($id);
        return $store;

        // try{

        //     $store = Store::find($id);

        //     $success = true;
        //     $message = "ດຶງຂໍ້ມູນສຳເລັດ!";

        // } catch (\Illuminate\Database\QueryException $ex){
        //     $success = false;
        //     $message = $ex->getMessage();
        //     $store = null;
        // }

        // $response = [
        //     "store" => $store,
        //     "success" => $success,
        //     "message" => $message
        // ];
        // return response()->json($response);
    }
    public function update($id,Request $request){

            try{

            $store = Store::find($id);
            $store->update([
                "name"=>$request->name,
                "image"=>'',
                "amount"=>$request->amount,
                "price_buy"=>$request->price_buy,
                "price_sell"=>$request->price_sell,
            ]);

            $success = true;
            $message = "ອັບເດດຂໍ້ມູນ ສຳເລັດ!";

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

    public function delete($id){
        try{

            $store = Store::find($id);
            $store->delete();

            $success = true;
            $message = "ລຶບຂໍ້ມູນ ສຳເລັດ!";
            // $message = "ລຶບຂໍ້ມູນ ບໍ່ສຳເລັດ!";

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
