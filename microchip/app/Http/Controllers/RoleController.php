<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dog;
use App\Microchip;
use App\DogFarm;
use App\User;
use App\Order;
use App\Transport;
use Auth;
use App\Charts\DogGender;
use App\Charts\SellChart;

class RoleController extends Controller
{
    public function dashboard_admin()
    {
        $count_dog = Dog::count();
        $count_microchip = Microchip::count();
        $count_dog_farm = DogFarm::count();
        $count_user = User::count();

        // Dog Gender Chart
        $dog_male = Dog::where('dog_sex', 'ตัวผู้')->count();
        $dog_female = Dog::where('dog_sex', 'ตัวเมีย')->count();  
        $dog_gender_chart = new DogGender;
        $dog_gender_chart->labels(['ตัวผู้', 'ตัวเมีย']);
        $dog_gender_chart->dataset('เพศ', 'pie', [$dog_male,$dog_female])->options([
            'backgroundColor' => '#2196F3',
        ]);

        // SellChart
        $sell_dog = Order::where('order_type', '0')->where('order_status', '3')->count();
        $sell_microchip = Order::where('order_type', '1')->where('order_status', '3')->count();
        $sell_install = Order::where('order_type', '2')->where('order_status', '3')->count();
        $sell_chart = new SellChart;
        $sell_chart->labels(['จำนวนการขาย']);
        $sell_chart->dataset('จำนวนขายสุนัข', 'bar', [$sell_dog])->options([
            'backgroundColor' => '#03A9F4',
        ]);
        $sell_chart->dataset('จำนวนขายไมโครชิพ', 'bar', [$sell_microchip])->options([
            'backgroundColor' => '#f44336',
        ]);
        $sell_chart->dataset('จำนวนติดตั้งไมโครชิพ', 'bar', [$sell_install])->options([
            'backgroundColor' => '#424242',
        ]);

        return view('/dashboards/admin',compact('count_dog','count_microchip','count_dog_farm','count_user','dog_gender_chart','sell_chart'));
    }

    public function dashboard_deliveryman()
    {
        $count_order = Order::where('order_deliveryman', Auth::user()->name)->count();
        $count_transport = Transport::count();
        $new_orders = Order::where('order_deliveryman', Auth::user()->name)
            ->where('order_status', '0')->paginate(10); 

        // Transports Chart
        $tran1 = Order::where('order_type', '0')->where('order_deliveryman', Auth::user()->name)->count();
        $tran2 = Order::where('order_type', '1')->where('order_deliveryman', Auth::user()->name)->count();  
        $tran3 = Order::where('order_type', '2')->where('order_deliveryman', Auth::user()->name)->count();  
        $transport_chart = new DogGender;
        $transport_chart->labels(['จัดส่งสุนัข', 'จัดส่งไมโครชิพ','จัดส่งติดตั้งไมโครชิพ']);
        $transport_chart->dataset('ช่องทางจัดส่ง', 'pie', [$tran1,$tran2,$tran3])->options([
            'backgroundColor' => '#2196F3',
        ]);

        return view('/dashboards/deliveryman',compact('count_order','count_transport','new_orders','transport_chart'));
    }
}
