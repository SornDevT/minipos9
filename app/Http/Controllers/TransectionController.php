<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Bill;
use App\Models\BillList;
use App\Models\Store;

class TransectionController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }


    public function index(Request $request){
         try{

                $sort = \Request::get("sort");
                $lp = \Request::get("lp");

                $month_type = $request->month_type;
                $dmy = $request->dmy;

                if($dmy == ''){

                    $tran = Transection::orderBy("id",$sort)
                    ->paginate($lp)
                    ->toArray();
                    return array_reverse($tran);

                } else {

                    $m = explode("-",$dmy)[1];
                    $y = explode("-",$dmy)[0];

                    if($month_type == 'm'){

                        $tran = Transection::orderBy("id",$sort)
                        ->whereYear("created_at","=",$y)
                        ->whereMonth("created_at","=",$m)
                        ->paginate($lp)
                        ->toArray();
                        return array_reverse($tran);

                    } else if($month_type == 'y'){

                        $tran = Transection::orderBy("id",$sort)
                        ->whereYear("created_at","=",$y)
                        ->paginate($lp)
                        ->toArray();
                        return array_reverse($tran);

                    }

                }

                

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



            /// ບັນທຶກຂໍ້ມູນໃບບິນ

            $bill_id='';
            $read_bill = Bill::all()->sortByDesc('id')->take(1)->toArray();
            foreach($read_bill as $new){
                $bill_id = $new['bill_id'];
            }

            if($bill_id!=''){
                $bill_id1 = (int)$bill_id+1; // 1+1 = 2
                $length = 5;
                $bill_id = substr(str_repeat(0,$length).$bill_id1, - $length); //00002
            } else {
                $bill_id1 = 1;
                $length = 5;
                $bill_id = substr(str_repeat(0,$length).$bill_id1, - $length); //00001
            }

            $bill = new Bill([
                'bill_id' => $bill_id,
                'customer_name' => $request->customer_name,
                'customer_tel' => $request->customer_tel,
            ]);
            $bill->save();

            /// ຈົບການບັນທຶກ ຂໍ້ມູນໃບບິນ
         
                foreach($request->listorder as $item ){

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


                    if($request->acc_type == "income") {
                        $tnum = "INC"; //INC
                    } elseif($request->acc_type == "expense") {
                        $tnum = "EXP"; // EXP
                    }

                    $tran = new Transection([
                        'tran_id' => $tnum.$number,
                        'product_id' => $item['id'],
                        'tran_type' => $request->acc_type,
                        'tran_detail' => $item['name'],
                        'amount' => $item['order_amount'],
                        'price' => $item['order_amount'] * $item['price_sell'],
                    ]);
                    $tran->save();

                    // ບັນທຶກລາຍການໃບບິນ

                    $bill_list = new BillList([
                        'bill_id' => $bill_id,
                        'name' => $item['name'],
                        'amount' => $item['order_amount'],
                        'price' => $item['price_sell'],
                    ]);
                    $bill_list->save();

                    /// ອັບເເດ ຕັດທີ

                    $store = Store::find($item['id']);

                    $store_update = Store::find($item['id']);
                    $store_update->update([
                        'amount' => $store->amount - $item['order_amount'],
                    ]);

                }

                    $success = true;
                    $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";
    
            } catch (\Illuminate\Database\QueryException $ex){
                $success = false;
                $message = $ex->getMessage();
                $bill_id = '';
            }
    
            $response = [
                "success" => $success,
                "message" => $message,
                "bill_id" => $bill_id
            ];
    
            return response()->json($response);
    }
}
