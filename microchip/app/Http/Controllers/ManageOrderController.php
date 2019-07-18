<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Sell;
use App\Microchip;
use App\Dog;
use App\User;
use App\Transport;
use App\InstallMicrochip;
use Auth;
use DB;

class ManageOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(20);
        $users = User::get()->where('type','Deliveryman');

        return view('manage_orders.index',compact('orders','users'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function index_sort_deliveryman($name)
    {
        $orders = Order::where('order_deliveryman',$name)->paginate(20);
        $users = User::get()->where('type','Deliveryman');

        return view('manage_orders.index',compact('orders','users'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function index_sort_status($order_status)
    {
        $orders = Order::where('order_status',$order_status)->paginate(20);
        $users = User::get()->where('type','Deliveryman');
        $order_status = Order::where('order_status',$order_status)->paginate(20);

        return view('manage_orders.index',compact('orders','users','order_status'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function index_deliveryman()
    {
        $orders = Order::where('order_deliveryman', Auth::user()->name)->paginate(20); 

        return view('manage_orders.index_deliveryman',compact('orders'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function index_deliveryman_sort_status($order_status)
    {
        $orders = Order::where('order_deliveryman', Auth::user()->name)->where('order_status',$order_status)->paginate(20);
        $order_status = Order::where('order_status',$order_status)->paginate(20);

        return view('manage_orders.index_deliveryman',compact('orders','order_status'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_dog($id)
    {
        $dog = Dog::find($id);
        $deliverymans = User::get()->where('type','Deliveryman');

        $provinces = DB::table('provinces')
            ->orderBy('name_th','asc')
            ->get();

        $transports = Transport::all();

        return view('manage_orders.create_dog_order',compact('dog','deliverymans','provinces','transports'));
    }

    public function create_microchip($id)
    {
        $microchip = Microchip::find($id);
        $deliverymans = User::get()->where('type','Deliveryman');

        $provinces = DB::table('provinces')
            ->orderBy('name_th','asc')
            ->get();

        $transports = Transport::all();

        return view('manage_orders.create_microchip_order',compact('microchip','deliverymans','provinces','transports'));
    }

    public function create_install(Request $request, $id)
    {
        $dog = Dog::find($id);
        $microchip_id = $request->microchip_id;
        $microchip = Microchip::find($microchip_id);
        $deliverymans = User::get()->where('type','Deliveryman');

        $provinces = DB::table('provinces')
            ->orderBy('name_th','asc')
            ->get();

        $transports = Transport::all();

        return view('manage_orders.create_install_order',compact('dog','microchip','deliverymans','provinces','transports'));
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
            'order_dog_discount_price' => 'nullable|numeric|digits_between:0,8|lt:order_dog_buy_price',
            'order_microchip_discount_price' => 'nullable|numeric|digits_between:0,8|lt:order_microchip_buy_price',
        ]);

        $order = new Order([
            'order_dog' => $request->order_dog, 
            'order_dog_buy_price' => $request->order_dog_buy_price, 
            'order_dog_sell_price' => $request->order_dog_sell_price, 
            'order_dog_discount_price' => $request->order_dog_discount_price, 
            'order_microchip' => $request->order_microchip, 
            'order_microchip_buy_price' => $request->order_microchip_buy_price, 
            'order_microchip_sell_price' => $request->order_microchip_sell_price, 
            'order_microchip_discount_price' => $request->order_microchip_discount_price, 
            'order_cus_name' => $request->order_cus_name,
            'order_cus_tel_no' => $request->order_cus_tel_no,
            'order_cus_house_no' => $request->order_cus_house_no,
            'order_cus_village_no' => $request->order_cus_village_no,
            'order_cus_lane' => $request->order_cus_lane,
            'order_cus_road' => $request->order_cus_road,
            'order_cus_province' => $request->order_cus_province,
            'order_cus_amphures' => $request->order_cus_amphures,
            'order_cus_districts' => $request->order_cus_districts,
            'order_cus_post_no' => $request->order_cus_post_no,
            'order_deliveryman' => $request->order_deliveryman, 
            'order_send_time' => $request->order_send_time, 
            'order_receive_time' => $request->order_receive_time, 
            'order_transport' => $request->order_transport, 
            'order_transport_price' => $request->order_transport_price, 
            'order_type' => $request->order_type,
            'order_status' => $request->order_status,
            'dog_id' => $request->dog_id,
            'microchip_id' => $request->microchip_id,
        ]);
        $order->save();

        if ($request->dog_id != null && $request->microchip_id != null) {
            $microchip_no = Microchip::where('id',$request->microchip_id)->select('microchip_no')->get();
            foreach ($microchip_no as $row){
                $output = $row->microchip_no;
            }

            $install_microchips = new InstallMicrochip([
                'install_microchip_breed' => $request->dog_breed,
                'install_microchip_color' => $request->dog_color,
                'install_microchip_sex' => $request->dog_sex,
                'install_microchip_birth_date' => $request->dog_birth_date,
                'install_microchip_image' => $request->dog_image,
                'install_microchip_owner_name' => $request->order_cus_name,
                'install_microchip_owner_tel_no' => $request->order_cus_tel_no,
                'install_microchip_owner_house_no' => $request->order_cus_house_no,
                'install_microchip_owner_village_no' => $request->order_cus_village_no,
                'install_microchip_owner_lane' => $request->order_cus_lane,
                'install_microchip_owner_road' => $request->order_cus_road,
                'install_microchip_owner_province' => $request->order_cus_province,
                'install_microchip_owner_amphures' => $request->order_cus_amphures,
                'install_microchip_owner_districts' => $request->order_cus_districts,
                'install_microchip_owner_post_no' => $request->order_cus_post_no,
                'install_microchip_status' => '1',
                'install_microchip_no' => $output,
                'microchip_id' => $request->microchip_id,
                'dog_id' => $request->dog_id,
            ]);
            $install_microchips->save();

            // link id
            Dog::where('id', $request->dog_id)
            ->update(['microchip_id' => $request->microchip_id]);
            Microchip::where('id', $request->microchip_id)
                ->update(['dog_id' => $request->dog_id]);

            // Update status dog & microchip
            Dog::where('id', $request->dog_id)
                ->update(['install_status' => 1]);
            Microchip::where('id', $request->microchip_id)
                ->update(['install_status' => 1]);
        }

        Transport::where('transport_name', $request->order_transport)
            ->increment('transport_count',1);

        // Update status
        if ($request->dog_id != null) {
            Dog::where('id', $request->dog_id)->update(['dog_status' => 1]);
        }

        if ($request->microchip_id != null) {
            Microchip::where('id', $request->microchip_id)->update(['microchip_status' => 1]);
        }

        return redirect()->route('manage_orders.index')->with('success','เพิ่มรายการจัดส่งสินค้าแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        return view('manage_orders.show',compact('order'));
    }

    public function show_deliveryman($id)
    {
        $order = Order::find($id);

        return view('manage_orders.show_deliveryman',compact('order'));
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
        //
    }

    public function confirm(Request $request, $id)
    {
        $order = Order::find($id);

        // Update status
        Order::where('id', $request->id)
            ->update(['order_status' => 3]);

        if ($request->dog_id != null && $request->microchip_id == null) {
            // save dog owner
            Dog::where('id', $request->dog_id)
                ->update(['dog_owner' => $request->order_cus_name]);

            // Update status
            Dog::where('id', $request->dog_id)->update(['dog_status' => 3]);
        }

        if ($request->microchip_id != null && $request->dog_id == null) {
            // save microchip owner
            Microchip::where('id', $request->microchip_id)
                ->update(['microchip_owner' => $request->order_cus_name]);

            // Update status
            Microchip::where('id', $request->microchip_id)->update(['microchip_status' => 3]);
        }

        if ($request->dog_id != null && $request->microchip_id != null) {
            // save microchip owner
            Dog::where('id', $request->dog_id)
                ->update(['dog_owner' => $request->order_cus_name]);
            Microchip::where('id', $request->microchip_id)
                ->update(['microchip_owner' => $request->order_cus_name]);

            // link id
            Dog::where('id', $request->dog_id)
            ->update(['microchip_id' => $request->microchip_id]);
            Microchip::where('id', $request->microchip_id)
                ->update(['dog_id' => $request->dog_id]);

            // Update status
            Dog::where('id', $request->dog_id)->update(['dog_status' => 3]);
            Dog::where('id', $request->dog_id)->update(['install_status' => 1]);
            Microchip::where('id', $request->microchip_id)->update(['microchip_status' => 3]);
            Microchip::where('id', $request->microchip_id)->update(['install_status' => 1]);
        }

        // Create Sell
        $sell = new Sell([
            'sell_dog' => $request->sell_dog, 
            'sell_dog_buy_price' => $request->sell_dog_buy_price, 
            'sell_dog_sell_price' => $request->sell_dog_sell_price, 
            'sell_dog_discount_price' => $request->sell_dog_discount_price, 
            'sell_microchip' => $request->sell_microchip, 
            'sell_microchip_buy_price' => $request->sell_microchip_buy_price, 
            'sell_microchip_sell_price' => $request->sell_microchip_sell_price, 
            'sell_microchip_discount_price' => $request->sell_microchip_discount_price, 
            'sell_cus_name' => $request->sell_cus_name,
            'sell_cus_tel_no' => $request->sell_cus_tel_no,
            'sell_cus_address' => $request->sell_cus_address,
            'sell_transport_price' => $request->sell_transport_price, 
        ]);
        $sell->save();

        return redirect()->route('manage_orders.index')->with('success','ยืนยันรายการจัดส่งสินค้าแล้ว');
    }

    public function resend(Request $request,$id)
    {
        // Update status
        Order::where('id', $id)
            ->update(['order_status' => 2]);

            if ($request->dog_id != null && $request->microchip_id == null) {
                // Update status
                Dog::where('id', $request->dog_id)->update(['dog_status' => 1]);
            }
    
            if ($request->microchip_id != null && $request->dog_id == null) {
                // Update status
                Microchip::where('id', $request->microchip_id)->update(['microchip_status' => 1]);
            }

            if ($request->order_type == 2){
                Dog::where('id', $request->dog_id)->update(['dog_status' => 1]);
                Microchip::where('id', $request->microchip_id)->update(['microchip_status' => 1]);
            }

        return redirect()->route('manage_orders.index')->with('success','ยืนยันการจัดส่งสินค้าใหม่แล้ว');
    }
    
    public function confirm_deliveryman(Request $request, $id)
    {
        $order = Order::find($id);
        $order->order_tracking_no = $request->order_tracking_no;
        $order->save();

        // Update status
        Order::where('id', $request->id)
            ->update(['order_status' => 1]);

        if ($request->dog_id != null) {
            Dog::where('id', $request->dog_id)->update(['dog_status' => 2]);
        }

        if ($request->microchip_id != null) {
            Microchip::where('id', $request->microchip_id)->update(['microchip_status' => 2]);
        }

        return redirect()->route('manage_orders.index_deliveryman')->with('success','ยืนยันรายการจัดส่งสินค้าแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Update status
        if ($request->dog_id != null) {
            Dog::where('id', $request->dog_id)->update(['dog_status' => 0]);
        }

        if ($request->microchip_id != null) {
            Microchip::where('id', $request->microchip_id)->update(['microchip_status' => 0]);
        }

        if ($request->order_type == 2){
            Dog::where('id', $request->dog_id)->update(['install_status' => 0]);
            Microchip::where('id', $request->microchip_id)->update(['install_status' => 0]);
            $install = InstallMicrochip::where('dog_id',$request->dog_id)->where('microchip_id',$request->microchip_id)->first();
            $install->delete();
        }

       $order = Order::find($id);
       $order->delete();

        Transport::where('transport_name', $request->order_transport)
            ->decrement('transport_count',1);

        return redirect()->route('manage_orders.index')-> with('success','ยกเลิกรายการจัดส่งสินค้าแล้ว');
    }

    // Dynamic Dropdown
    function dropdown_province(Request $request){
        $name_th = $request->get('select');
        $result = array();
        $query = DB::table('provinces')
            ->join('amphures','provinces.id','=','amphures.province_id')
            ->select('amphures.id','amphures.name_th')
            ->where('provinces.name_th',$name_th)
            ->groupBy('amphures.id','amphures.name_th')
            ->get();

        $output = '<option value="" selected disabled>เลือกอำเภอ</option>';
        foreach ($query as $row){
            $output.='<option value="'.$row->name_th.'">'.$row->name_th.'</option>';
        }
        echo $output;
    }
    
    function dropdown_amphures(Request $request){
        $name_th = $request->get('select');
        $result = array();
        $query = DB::table('amphures')
            ->join('districts','amphures.id','=','districts.amphure_id')
            ->select('districts.id','districts.name_th')
            ->where('amphures.name_th',$name_th)
            ->groupBy('districts.id','districts.name_th')
            ->get();

        $output = '<option value="" selected disabled>เลือกตำบล</option>';
        foreach ($query as $row){
            $output.='<option value="'.$row->name_th.'">'.$row->name_th.'</option>';
        }
        echo $output;
    }

    // ดึงราคา ค่าส่งตามภูมิภาค
    function delivery_fee(Request $request){
        $transport_name = $request->get('select');
        $result = array();

        $query = DB::table('transports')
            ->select('transports.transport_price')
            ->where('transports.transport_name',$transport_name)
            ->get();

        $output = '<label>ค่าจัดส่ง</label>';
        foreach ($query as $row){
            $output .='<input type="number" class="form-control" name="order_transport_price" value="'.$row->transport_price.'" required>';
        }
        echo $output;
    }
}
