<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Microchip;
use App\InstallMicrochip;

class ManageMicrochipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $microchips = Microchip::paginate(20);
  
        return view('manage_microchips.index',compact('microchips'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function index_sort_status($microchip_status)
    {
        $microchips = Microchip::where('microchip_status',$microchip_status)->paginate(20);
        $microchip_status = Microchip::where('microchip_status',$microchip_status)->paginate(20);

        return view('manage_microchips.index',compact('microchips','microchip_status'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'microchip_no' => 'unique:microchips',
            'microchip_buy_price' => 'numeric|digits_between:0,8',
            'microchip_sell_price' => 'numeric|digits_between:0,8|gt:microchip_buy_price',
        ]);

        $microchip = new Microchip([
            'microchip_no' => $request->microchip_no,
            'microchip_buy_price' => $request->microchip_buy_price,
            'microchip_sell_price' => $request->microchip_sell_price,
            'microchip_status' => $request->microchip_status,
            'install_status' => $request->install_status,
        ]);
        $microchip->save();

        return redirect()->route('manage_microchips.index')->with('success','เพิ่มไมโครชิพแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $microchip = Microchip::find($id);
        // $microchips = Microchip::where('microchip_status', '=', 0)->get();

        return view('manage_microchips.show',compact('microchip'));
    }

    public function show_install($id)
    {
        $install_microchip = InstallMicrochip::where('microchip_id',$id)->first();

        return view('manage_microchips.show_install',compact('install_microchip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'microchip_no' => 'unique:microchips',
            'microchip_buy_price' => 'numeric|digits_between:0,8',
            'microchip_sell_price' => 'numeric|digits_between:0,8|gt:microchip_buy_price',
        ]);

        $microchip = Microchip::find($id);
        $microchip->microchip_no = $request->microchip_no;
        $microchip->microchip_buy_price = $request->microchip_buy_price;
        $microchip->microchip_sell_price = $request->microchip_sell_price;
        $microchip->microchip_status = $request->microchip_status;
        $microchip->install_status = $request->install_status;
        $microchip->save();

        return redirect()->route('manage_microchips.index')->with('success','แก้ไขไมโครชิพแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $microchip = Microchip::find($id);
        $microchip->delete();

        return redirect()->route('manage_microchips.index')->with('success','ลบไมโครชิพแล้ว');
    }
}
