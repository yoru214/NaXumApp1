<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function transactions(Request $request)
    {
         if ($request->ajax()) {
             
            //var_dump($input['start']);
            //var_dump($input['length']);
            $users = \DB::select('CALL transaction_listing()');
            $data = Datatables::of($users)->setTotalRecords(100)->make(true);
            $input = $request->all();
            return $data;
         }

        return view('transactions\list');
    }
}
