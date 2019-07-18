<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DogFarm;
use App\DogBreed;
use App\Dog;
use App\Microchip;
use App\InstallMicrochip;

class ManageDogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dogs = Dog::paginate(20);
        $dog_breeds = DogBreed::all();
        $dog_farms = DogFarm::all();
        $microchips = Microchip::where('microchip_status', '=', 0)->get();
  
        return view('manage_dogs.index',compact('dogs','dog_breeds','dog_farms','microchips'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
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

    public function index_sort_farm($dog_farm_name)
    {
        $dogs = Dog::where('dog_farm_name',$dog_farm_name)->paginate(20);
        $dog_breeds = DogBreed::all();
        $dog_farms = DogFarm::all();
        $microchips = Microchip::where('microchip_status', '=', 0)->get();

        return view('manage_dogs.index',compact('dogs','dog_breeds','dog_farms','microchips'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function index_sort_sex($id)
    {
        $dogs = Dog::where('dog_sex',$id)->paginate(20);
        $dog_breeds = DogBreed::all();
        $dog_farms = DogFarm::all();
        $dog_sex = Dog::where('dog_sex',$id)->paginate(20);
        $microchips = Microchip::where('microchip_status', '=', 0)->get();

        return view('manage_dogs.index',compact('dogs','dog_breeds','dog_farms','dog_sex','microchips'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function index_sort_status($dog_status)
    {
        $dogs = Dog::where('dog_status',$dog_status)->paginate(20);
        $dog_breeds = DogBreed::all();
        $dog_farms = DogFarm::all();
        $dog_status = Dog::where('dog_status',$dog_status)->paginate(20);
        $microchips = Microchip::where('microchip_status', '=', 0)->get();

        return view('manage_dogs.index',compact('dogs','dog_breeds','dog_farms','dog_status','microchips'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dog_farms = DogFarm::all();
        $dog_breeds = DogBreed::all();

        return view('manage_dogs.create',compact('dog_farms','dog_breeds'));
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
            'dog_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dog_buy_price' => 'numeric|digits_between:0,8',
            'dog_sell_price' => 'numeric|digits_between:0,8|gt:dog_buy_price',
        ]);

        if ($request->hasfile('dog_image')) {
            $image_name = time().'.'.request()->dog_image->getClientOriginalExtension();
            request()->dog_image->move(public_path('image/dogs'), $image_name);

            $dog = new Dog([
                'dog_breed' => $request->dog_breed,
                'dog_color' => $request->dog_color,
                'dog_sex' => $request->dog_sex,
                'dog_birth_date' => $request->dog_birth_date,
                'dog_farm_name' => $request->dog_farm_name,
                'dog_buy_price' => $request->dog_buy_price,
                'dog_sell_price' => $request->dog_sell_price,
                'dog_image' => $image_name,
                'dog_status' => $request->dog_status,
                'install_status' => $request->install_status,
                'microchip_id' => $request->microchip_id,
            ]);
            $dog->save();
        } 
        else {
            $dog = new Dog([
                'dog_breed' => $request->dog_breed,
                'dog_color' => $request->dog_color,
                'dog_sex' => $request->dog_sex,
                'dog_birth_date' => $request->dog_birth_date,
                'dog_farm_name' => $request->dog_farm_name,
                'dog_buy_price' => $request->dog_buy_price,
                'dog_sell_price' => $request->dog_sell_price,
                'dog_status' => $request->dog_status,
                'install_status' => $request->install_status,
                'microchip_id' => $request->microchip_id,
            ]);
            $dog->save();
        }

        // เพิ่มจำนวนนับฟาร์ม
        DogFarm::where('dog_farm_name', $request->dog_farm_name)
            ->increment('dog_farm_count',1);

        // เพิ่มจำนวนนับสายพันธ์
        if ($request->dog_sex == "ตัวผู้"){
            DogBreed::where('dog_breed', $request->dog_breed)
                ->increment('dog_breed_male_count',1);
        }
        elseif ($request->dog_sex == "ตัวเมีย"){
            DogBreed::where('dog_breed', $request->dog_breed)
                ->increment('dog_breed_female_count',1);
        }

        return redirect()->route('manage_dogs.index')->with('success','เพิ่มสุนัขแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dog = Dog::find($id);
        $dog_farms = DogFarm::all();
        $dog_breeds = DogBreed::all();
        $microchips = Microchip::where('microchip_status', '=', 0)->get();

        return view('manage_dogs.show',compact('dog','dog_farms','dog_breeds','microchips'));
    }

    public function show_install($id)
    {
        $install_microchip = InstallMicrochip::where('dog_id',$id)->first();

        return view('manage_dogs.show_install',compact('install_microchip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dog = Dog::find($id);
        $dog_farms = DogFarm::all();
        $dog_breeds = DogBreed::all();

        return view('manage_dogs.edit',compact('dog','dog_farms','dog_breeds'));
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
            'dog_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dog_buy_price' => 'numeric|digits_between:0,8',
            'dog_sell_price' => 'numeric|digits_between:0,8|gt:dog_buy_price',
        ]);

        if ($request->hasfile('dog_image')){
            $image_name = time().'.'.request()->dog_image->getClientOriginalExtension();
            request()->dog_image->move(public_path('image/dogs'), $image_name);

            $dog = Dog::find($id);
            $dog->dog_breed = $request->dog_breed;
            $dog->dog_color = $request->dog_color;
            $dog->dog_sex = $request->dog_sex; 
            $dog->dog_birth_date = $request->dog_birth_date; 
            $dog->dog_farm_name = $request->dog_farm_name; 
            $dog->dog_buy_price = $request->dog_buy_price; 
            $dog->dog_sell_price = $request->dog_sell_price; 
            $dog->dog_image = $image_name; 
            $dog->dog_status = $request->dog_status; 
            $dog->install_status = $request->install_status; 
            $dog->microchip_id = $request->microchip_id; 
            $dog->save();
        }
        else {
            $dog = Dog::find($id);
            $dog->dog_breed = $request->dog_breed;
            $dog->dog_color = $request->dog_color;
            $dog->dog_sex = $request->dog_sex; 
            $dog->dog_birth_date = $request->dog_birth_date; 
            $dog->dog_farm_name = $request->dog_farm_name; 
            $dog->dog_buy_price = $request->dog_buy_price; 
            $dog->dog_sell_price = $request->dog_sell_price; 
            $dog->dog_status = $request->dog_status; 
            $dog->install_status = $request->install_status; 
            $dog->microchip_id = $request->microchip_id; 
            $dog->save();
        }
        
        return redirect()->route('manage_dogs.index')-> with('success','แก้ไขสุนัขแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $dog = Dog::find($id);
        $dog->delete();

        // ลบจำนวนนับฟาร์ม
        DogFarm::where('dog_farm_name', $request->dog_farm_name)
            ->decrement('dog_farm_count',1);

        // ลบจำนวนนับสายพันธ์
        if ($request->dog_sex == "ตัวผู้"){
            DogBreed::where('dog_breed', $request->dog_breed)
                ->decrement('dog_breed_male_count',1);
        }
        elseif ($request->dog_sex == "ตัวเมีย"){
            DogBreed::where('dog_breed', $request->dog_breed)
                ->decrement('dog_breed_female_count',1);
        }

        return redirect()->route('manage_dogs.index')-> with('success','ลบสุนัขแล้ว');
    }
}
