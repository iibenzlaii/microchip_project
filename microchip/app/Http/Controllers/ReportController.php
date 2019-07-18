<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; 
use PDF;
use App\Contact;
use App\Order;
use App\Sell;
use App\InstallMicrochip;

class ReportController extends Controller
{
    public function report_install(){
        $installs = InstallMicrochip::paginate(20);

        return view('reports.install_microchip',compact('installs'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function search_report_install(Request $request){
        $search = $request->get('search');
        $installs = InstallMicrochip::where('install_microchip_no', 'like', '%'.$search.'%')
            ->paginate(20);
            
        //dd($installs);
        return view('reports.install_microchip',compact('installs'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function total_sell()
    {
        $sells = Sell::all();
        $select_months = Sell::select('created_at')->orderBy('created_at','asc')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        $select_years = Sell::select('created_at')->orderBy('created_at','asc')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y'); // grouping by years
        });

        return view('reports.total_sell', compact('sells','select_months','select_years'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function total_sell_sort(Request $request)
    {
        $select_months = Sell::select('created_at')->orderBy('created_at','asc')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        $select_years = Sell::select('created_at')->orderBy('created_at','asc')->get()->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y'); // grouping by years
        });

        $view_option = $request->options;
        if($view_option == 'op_date') {
            $get_date = $request->getDate;
            $sells = Sell::whereDate('created_at', $get_date)->get();
        } elseif ($view_option == 'op_month') {
            $get_month = Carbon::parse($request->getMonth)->format('m');
            $get_year = Carbon::parse($request->getMonth)->format('Y');
            $sells = Sell::whereMonth('created_at', $get_month)
                ->whereYear('created_at', $get_year)
                ->get();
        } elseif ($view_option == 'op_year') {
            $get_year = $request->getYear;
            $sells = Sell::whereYear('created_at', $get_year)->get();
        } elseif ($view_option == 'op_all') {
            $sells = Sell::all();
        }
        return view('reports.total_sell', compact('sells','select_months','select_years'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function index_sort_breed($dog_breed)
    {
        $dogs = Dog::where('dog_breed',$dog_breed)->paginate(20);
        $dog_breeds = DogBreed::all();
        $dog_farms = DogFarm::all();
        $microchips = Microchip::where('microchip_status', '=', 0)->get();

        return view('manage_dogs.index',compact('dogs','dog_breeds','dog_farms','microchips'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function pdf_order($id){
        $order = Order::find($id);
        $contact = Contact::first();
        
        $pdf = PDF::loadView('reports.pdf_order', compact(
            'order', 'contact'
        ));
        $pdf->setPaper('A4');
        return @$pdf->stream('ใบเสร็จรับเงิน.pdf');
    }

    public function pdf_sell($id){
        $sell = Sell::find($id);
        $contact = Contact::first();
        
        $pdf = PDF::loadView('reports.pdf_sell', compact(
            'sell', 'contact'
        ));
        $pdf->setPaper('A4');
        return @$pdf->stream('ใบรายการขาย.pdf');
    }

    public function pdf_install_microchip($id){
        $install = InstallMicrochip::find($id);
        $contact = Contact::first();
        
        $pdf = PDF::loadView('reports.pdf_install_microchip', compact(
            'install', 'contact'
        ));
        $pdf->setPaper('A5', 'landscape');
        return @$pdf->stream('Certifies.pdf');
    }
}
