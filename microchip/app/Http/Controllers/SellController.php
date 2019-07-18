<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sell;

class SellController extends Controller
{
    public function index()
    {
        $sells = Sell::paginate(20);

        return view('sells.index',compact('sells'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show($id)
    {
        $sell = Sell::find($id);

        return view('sells.show',compact('sell'));
    }
}
