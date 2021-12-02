<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transactions(Request $request)
    {
         if ($request->ajax()) {
            $users = User::select('*');
            return Datatables::of($users)->make(true);
         }

        return view('transactions\list');
    }
}
