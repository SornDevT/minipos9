<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillList;


class BillsController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function print($bill_id){

        $bill = Bill::where('bill_id',$bill_id)->get();
        $bill_list = BillList::where('bill_id',$bill_id)->get();

        return view('bill')->with('bill',$bill)->with('bill_list',$bill_list);
    }
}
