<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Transection;

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

            if($request->file('image')){ /// ກວດຊອບວ່າມີໄຟລ໌ ຊື່ image ສົ່ງມາຫຼືບໍ່
                $upload_path = "assets/img";
                $generate_new_name = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path($upload_path),$generate_new_name);

                // return $request->image->getClientOriginalExtension();
            } else {
                $generate_new_name = '';
            }

                    $store = new Store([
                        'name' => $request->name,
                        'image' => $generate_new_name,
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);
                    $store->save();

                    // ດຶງ id ທີ່ບັນທຶກລ່າສຸດ
                    $product_id = $store->id;

                    // ບັນທຶກທຸລະກຳຊື້ສິນຄ້າ

                    $number='';
                    $read_tran = Transection::all()->sortByDesc('id')->take(1)->toArray();
                    foreach($read_tran as $new){
                        $number = $new['tran_id'];
                    }

                    if($number!=''){
                        $number1 = str_replace("INC","",$number); // 00001
                        $number2 = str_replace("EXP","",$number1);
                        $number3 = (int)$number2+1; // 1+1 = 2
                        $length = 5;
                        $number = substr(str_repeat(0,$length).$number3, - $length); //00002
                    } else {
                        $number3 = 1;
                        $length = 5;
                        $number = substr(str_repeat(0,$length).$number3, - $length); //00001
                    }


                    // if($request->acc_type == "income") {
                    //     $tnum = "INC"; //INC
                    // } elseif($request->acc_type == "expense") {
                    //     $tnum = "EXP"; // EXP
                    // }

                    $tran = new Transection([
                        'tran_id' => "EXP".$number,
                        'product_id' => $product_id,
                        'tran_type' => 'expense',
                        'tran_detail' => $request->name,
                        'amount' => $request->amount,
                        'price' => $request->amount * $request->price_buy,
                    ]);
                    $tran->save();




    
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
            $upload_path = "assets/img";

            // ກວດຊອບວ່າມີອັບໂຫຼດຮູບພາບໃໝ່ຫຼືບໍ່
            if($request->file('image')){ 
                
                // ລຶບຮູບພາບເກົ່າ
                if($store->image){
                    if(file_exists($upload_path.'/'.$store->image)){
                        unlink($upload_path.'/'.$store->image); /// ລຶບຮູບພາບເກົ່າ
                    }
                }

                // ອັບໂຫຼດຮູບພາບໃໝ່
                $generate_new_name = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path($upload_path),$generate_new_name);

                $store->update([
                    "name"=>$request->name,
                    "image"=>$generate_new_name,
                    "amount"=>$request->amount,
                    "price_buy"=>$request->price_buy,
                    "price_sell"=>$request->price_sell,
                ]);


            } else {
                
                if($request->image){ // ບໍ່ມີການອັບໂຫຼດຮູບໃໝ່ ແຕ່ມີຄ່າຊື່ຮູບພາບສົ່ງມາ

                    $store->update([
                        "name"=>$request->name,
                        // "image"=>$generate_new_name,
                        "amount"=>$request->amount,
                        "price_buy"=>$request->price_buy,
                        "price_sell"=>$request->price_sell,
                    ]);


                } else { // ບໍ່ມີການອັບໂຫຼດຮູບໃໝ່ ແຕ່ ມີການລຶບຮູບເກົ່າອອກ

                        // ລຶບຮູບພາບເກົ່າ
                        if($store->image){
                            if(file_exists($upload_path.'/'.$store->image)){
                                unlink($upload_path.'/'.$store->image); /// ລຶບຮູບພາບເກົ່າ
                            }
                        }

                         $store->update([
                            "name"=>$request->name,
                            "image"=>"",
                            "amount"=>$request->amount,
                            "price_buy"=>$request->price_buy,
                            "price_sell"=>$request->price_sell,
                         ]);

                }



            }



            // $store->update([
            //     "name"=>$request->name,
            //     "image"=>'',
            //     "amount"=>$request->amount,
            //     "price_buy"=>$request->price_buy,
            //     "price_sell"=>$request->price_sell,
            // ]);

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
