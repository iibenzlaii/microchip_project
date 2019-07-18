<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InstallMicrochip;
use App\RequestChangeOwner;
use App\Dog;
use App\Microchip;
use App\User;
use DB;
use Auth;

class ServiceController extends Controller
{
    public function microchip_no_search (Request $request) {
        $search = $request->microchip_no;
        
        $install_microchip = InstallMicrochip::where('install_microchip_no',$search)
            ->where('install_microchip_status','1')->first();

        $request_changes = RequestChangeOwner::where('request_change_owner_status','1')
            ->where('install_microchip_no',$search)->get();

        if (empty($install_microchip)) {
            return redirect('/')->with('error','ไม่พบข้อมูลในระบบ');
        } else {
            $dog_id = InstallMicrochip::select('dog_id')->where('install_microchip_no',$search)->get();
            foreach ($dog_id as $row){
                $dog_id_output = $row->dog_id;
            }  
            
            $dog = Dog::select('dog_sell_price')->where('id',$dog_id_output)->first();
    
            $microchip_id = InstallMicrochip::select('microchip_id')->where('install_microchip_no',$search)->get();
            foreach ($microchip_id as $row){
                $microchip_id_output = $row->microchip_id;
            }  
            
            $microchip = Microchip::select('microchip_sell_price')->where('id',$microchip_id_output)->first();

            $provinces = DB::table('provinces')
                ->orderBy('name_th','asc')
                ->get();

            return view('microchip_logs.show',compact('install_microchip','request_changes','dog','microchip','provinces'))
                ->with('i', (request()->input('page', 1) - 1) * 10);
        }
    }

    public function microchip_install_search (Request $request) {
        $search = $request->microchip_no;
        
        $get_microchip_no = Microchip::where('microchip_no',$search)->where('microchip_status',3)
            ->where('install_status',0)->first();

        $find_install = InstallMicrochip::where('install_microchip_status','0')
            ->where('install_microchip_no',$search)->first();

        if (empty($get_microchip_no)) {
            return redirect('/')->with('error','ไม่พบข้อมูลในระบบ');
        } 
        elseif (!empty($find_install)) {
            return redirect('/')->with('error','หมายเลขไมโครชิพนี้แจ้งติดตั้งไปแล้ว');
        }
        else {
            $provinces = DB::table('provinces')
                ->orderBy('name_th','asc')
                ->get();
    
            return view('request_installs.create',compact('get_microchip_no','provinces'));
        }
    }

    public function index_my_list()
    {
        $dog_installs = InstallMicrochip::where('user_id',Auth::user()->id)->paginate(10);

        return view('my_dog_lists',compact('dog_installs'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show_my_list (Request $request) {
        $install_microchip = InstallMicrochip::where('install_microchip_no',$request->install_microchip_no)
            ->where('install_microchip_status','1')->first();

        $request_changes = RequestChangeOwner::where('request_change_owner_status','1')
            ->where('install_microchip_no',$request->install_microchip_no)->get();

        $dog = Dog::select('dog_sell_price')->where('id',$request->dog_id)->first();
            
        $microchip = Microchip::select('microchip_sell_price')->where('id',$request->microchip_id)->first();

        $provinces = DB::table('provinces')
            ->orderBy('name_th','asc')
            ->get();

        return view('microchip_logs.show',compact('install_microchip','request_changes','dog','microchip','provinces'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function add_my_list(Request $request, $id)
    {
        // Update status
        InstallMicrochip::where('id', $id)
            ->update(['user_id' => $request->user_id]);

        return redirect()->route('my_lists.index')->with('success','เพิ่มในรายการสุนัขของฉันแล้ว');
    }

    public function delete_my_list(Request $request, $id)
    {
        // Update status
        InstallMicrochip::where('id', $id)
            ->update(['user_id' => 0]);

        return redirect()->route('my_lists.index')->with('success','ลบออกจากรายการสุนัขของฉันแล้ว');
    }

    public function request_install (Request $request) {
        request()->validate([
            'install_microchip_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasfile('install_microchip_image')){
            $image_name = time().'.'.request()->install_microchip_image->getClientOriginalExtension();
            request()->install_microchip_image->move(public_path('image/dogs'), $image_name);

            $install_microchips = new InstallMicrochip([
                'install_microchip_breed' => $request->install_microchip_breed,
                'install_microchip_color' => $request->install_microchip_color,
                'install_microchip_sex' => $request->install_microchip_sex,
                'install_microchip_image' => $image_name,
                'install_microchip_owner_name' => $request->install_microchip_owner_name,
                'install_microchip_owner_tel_no' => $request->install_microchip_owner_tel_no,
                'install_microchip_owner_house_no' => $request->install_microchip_owner_name,
                'install_microchip_owner_village_no' => $request->install_microchip_owner_village_no,
                'install_microchip_owner_lane' => $request->install_microchip_owner_house_no,
                'install_microchip_owner_road' => $request->install_microchip_owner_road,
                'install_microchip_owner_province' => $request->install_microchip_owner_province,
                'install_microchip_owner_amphures' => $request->install_microchip_owner_amphures,
                'install_microchip_owner_districts' => $request->install_microchip_owner_districts,
                'install_microchip_owner_post_no' => $request->install_microchip_owner_post_no,
                'install_microchip_booking_date' => $request->install_microchip_booking_date,
                'install_microchip_status' => $request->install_microchip_status,
                'install_microchip_no' => $request->install_microchip_no,
                'microchip_id' => $request->microchip_id,
            ]);
            $install_microchips->save();
        } else {
            $install_microchips = new InstallMicrochip([
                'install_microchip_breed' => $request->install_microchip_breed,
                'install_microchip_color' => $request->install_microchip_color,
                'install_microchip_sex' => $request->install_microchip_sex,
                'install_microchip_owner_name' => $request->install_microchip_owner_name,
                'install_microchip_owner_tel_no' => $request->install_microchip_owner_tel_no,
                'install_microchip_owner_house_no' => $request->install_microchip_owner_name,
                'install_microchip_owner_village_no' => $request->install_microchip_owner_village_no,
                'install_microchip_owner_lane' => $request->install_microchip_owner_house_no,
                'install_microchip_owner_road' => $request->install_microchip_owner_road,
                'install_microchip_owner_province' => $request->install_microchip_owner_province,
                'install_microchip_owner_amphures' => $request->install_microchip_owner_amphures,
                'install_microchip_owner_districts' => $request->install_microchip_owner_districts,
                'install_microchip_owner_post_no' => $request->install_microchip_owner_post_no,
                'install_microchip_booking_date' => $request->install_microchip_booking_date,
                'install_microchip_status' => $request->install_microchip_status,
                'install_microchip_no' => $request->install_microchip_no,
                'microchip_id' => $request->microchip_id,
            ]);
            $install_microchips->save();
        }

        return redirect('/')->with('success','แจ้งความประสงค์ขอติดตั้งไมโครชิพแล้ว');
    }

    // Request Install
    public function index_request_install () {
        $request_installs = InstallMicrochip::where('install_microchip_status','0')
            ->paginate(10);

        return view('request_installs.index', compact('request_installs'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function confirm_request_install(Request $request, $id)
    {
        // Update status
        InstallMicrochip::where('id', $request->id)
            ->update(['install_microchip_status' => 1]);

        Microchip::where('id', $request->microchip_id)
            ->update(['install_status' => '1']);

        return redirect()->route('request_install.index')->with('success','อนุมัติคำขอติดตั้งไมโครชิพแล้ว');
    }

    public function delete_request_install(Request $request, $id)
    {
        $request_installs = InstallMicrochip::find($id);
        $request_installs->delete();

        return redirect()->route('request_install.index')-> with('success','ไม่อนุมัติคำขอติดตั้งไมโครชิพแล้ว');
    }

    // Change Owner
    public function index_request_change_owner () {
        $request_changes = RequestChangeOwner::where('request_change_owner_status','0')
            ->paginate(10);

        return view('request_change_owners.index', compact('request_changes'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function store_request_change_owner (Request $request) {
        $request_change = new RequestChangeOwner([
            'install_microchip_breed' => $request->install_microchip_breed,
            'install_microchip_color' => $request->install_microchip_color,
            'install_microchip_sex' => $request->install_microchip_sex,
            'install_microchip_no' => $request->install_microchip_no,
            'old_owner_name' => $request->old_owner_name,
            'old_owner_tel_no' => $request->old_owner_tel_no,
            'old_owner_house_no' => $request->old_owner_house_no,
            'old_owner_village_no' => $request->old_owner_village_no,
            'old_owner_lane' => $request->old_owner_lane,
            'old_owner_road' => $request->old_owner_road,
            'old_owner_province' => $request->old_owner_province,
            'old_owner_amphures' => $request->old_owner_amphures,
            'old_owner_districts' => $request->old_owner_districts,
            'old_owner_post_no' => $request->old_owner_post_no,
            'request_change_owner_name' => $request->request_change_owner_name,
            'request_change_owner_tel_no' => $request->request_change_owner_tel_no,
            'request_change_owner_house_no' => $request->request_change_owner_house_no,
            'request_change_owner_village_no' => $request->request_change_owner_village_no,
            'request_change_owner_lane' => $request->request_change_owner_lane,
            'request_change_owner_road' => $request->request_change_owner_road,
            'request_change_owner_province' => $request->request_change_owner_province,
            'request_change_owner_amphures' => $request->request_change_owner_amphures,
            'request_change_owner_districts' => $request->request_change_owner_districts,
            'request_change_owner_post_no' => $request->request_change_owner_post_no,
            'request_change_owner_status' => $request->request_change_owner_status,
            'install_microchip_id' => $request->install_microchip_id,
            'microchip_id' => $request->microchip_id,
            'dog_id' => $request->dog_id,
        ]);
        $request_change->save();

        return redirect('/')->with('success','แจ้งขอเปลี่ยนข้อมูลแล้ว');
    }

    public function confirm_request_change_owner(Request $request, $id)
    {
        $request_change = RequestChangeOwner::find($id);

        // Update status
        RequestChangeOwner::where('id', $request->id)
            ->update(['request_change_owner_status' => 1]);
        
        $install_microchip = InstallMicrochip::find($request->install_microchip_id);
        $install_microchip->install_microchip_owner_name = $request->request_change_owner_name;
        $install_microchip->install_microchip_owner_tel_no = $request->request_change_owner_tel_no;
        $install_microchip->install_microchip_owner_house_no = $request->request_change_owner_house_no;
        $install_microchip->install_microchip_owner_village_no = $request->request_change_owner_village_no;
        $install_microchip->install_microchip_owner_lane = $request->request_change_owner_lane;
        $install_microchip->install_microchip_owner_road = $request->request_change_owner_road;
        $install_microchip->install_microchip_owner_province = $request->request_change_owner_province;
        $install_microchip->install_microchip_owner_amphures = $request->request_change_owner_amphures;
        $install_microchip->install_microchip_owner_districts = $request->request_change_owner_districts;
        $install_microchip->install_microchip_owner_post_no = $request->request_change_owner_post_no;
        $install_microchip->save();

        Dog::where('id', $request->dog_id)
            ->update(['dog_owner' => $request->request_change_owner_name]);

        Microchip::where('id', $request->microchip_id)
            ->update(['microchip_owner' => $request->request_change_owner_name]);

        return redirect()->route('request_change_owners.index')->with('success','อนุมัติการเปลี่ยนข้อมูลเจ้าของแล้ว');
    }

    public function delete_request_change_owner(Request $request, $id)
    {
        $request_change = RequestChangeOwner::find($id);
        $request_change->delete();

        return redirect()->route('request_change_owners.index')-> with('success','ไม่อนุมัติการเปลี่ยนข้อมูลเจ้าของแล้ว');
    }

    // Change Personal Info
    public function show_change_info($id)
    {
        $user = User::find($id);

        return view('change_personal_info',compact('user')); 
    }

    public function update_change_info(Request $request, $id)
    {
        // request()->validate([
        //     'password' =>  'min:8',
        // ]);

        $user = User::find($id);
        $user->name = $request->name;
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('change_personal_info.show',$id)->with('success','แก้ไขข้อมูลส่วนตัวแล้ว'); 
    }
}
