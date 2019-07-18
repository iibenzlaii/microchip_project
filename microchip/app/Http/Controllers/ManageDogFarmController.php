<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DogFarm;
use App\DogBreed;
use App\Dog;
use DB;

class ManageDogFarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dog_farms = DogFarm::paginate(20);
  
        return view('manage_dog_farms.index',compact('dog_farms'))->with('i', (request()->input('page', 1) - 1) * 10);
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
        $dog_farm = new DogFarm([
            'dog_farm_name' => $request->dog_farm_name,
            'dog_farm_count' => $request->dog_farm_count,
        ]);
        $dog_farm->save();

        return redirect()->route('manage_dog_farms.index')->with('success','เพิ่มฟาร์มสุนัขแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $dog_farm_name)
    {
        $dog_farm_id = DogFarm::find($id);
        $dogs = Dog::where('dog_farm_name',$dog_farm_name)->paginate(20);
        $dog_breeds = DogBreed::all();
  
        return view('manage_dog_farms.show',compact('dog_farm_id','dogs','dog_breeds'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show_male($id, $dog_farm_name)
    {
        $dog_farm_id = DogFarm::find($id);
        $dogs = Dog::where('dog_farm_name',$dog_farm_name)->where('dog_sex','ตัวผู้')->paginate(20);
        $dog_breeds = DogBreed::all();
  
        return view('manage_dog_farms.show',compact('dog_farm_id','dogs','dog_breeds'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show_female($id, $dog_farm_name)
    {
        $dog_farm_id = DogFarm::find($id);
        $dogs = Dog::where('dog_farm_name',$dog_farm_name)->where('dog_sex','ตัวเมีย')->paginate(20);
        $dog_breeds = DogBreed::all();
  
        return view('manage_dog_farms.show',compact('dog_farm_id','dogs','dog_breeds'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function sort_breed($id, $dog_farm_name, $dog_breed)
    {
        $dog_farm_id = DogFarm::find($id);
        $dogs = Dog::where('dog_farm_name',$dog_farm_name)->where('dog_breed',$dog_breed)->paginate(20);
        $dog_breeds = DogBreed::all();

        return view('manage_dog_farms.show',compact('dog_farm_id','dogs','dog_breeds'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
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
        $dog_farm = DogFarm::find($id);
        $dog_farm->dog_farm_name = $request->dog_farm_name;
        $dog_farm->save();

        Dog::where('dog_farm_name', $request->old_value)
                ->update(['dog_farm_name' => $request->dog_farm_name]);

        return redirect()->route('manage_dog_farms.index')->with('success','แก้ไขฟาร์มสุนัขแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dog_farm = DogFarm::find($id);
        $dog_farm->delete();

        return redirect()->route('manage_dog_farms.index')->with('success','ลบฟาร์มสุนัขแล้ว');
    }
}
