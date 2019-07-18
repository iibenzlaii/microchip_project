<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DogBreed;
use App\DogFarm;
use App\Dog;

class ManageDogBreedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dog_breeds = DogBreed::paginate(20);
  
        return view('manage_dog_breeds.index',compact('dog_breeds'))->with('i', (request()->input('page', 1) - 1) * 10);
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
        $dog_breed = new DogBreed([
            'dog_breed' => $request->dog_breed,
            'dog_breed_male_count' => $request->dog_breed_male_count,
            'dog_breed_female_count' => $request->dog_breed_female_count,
        ]);
        $dog_breed->save();

        return redirect()->route('manage_dog_breeds.index')->with('success','เพิ่มสายพันธ์สุนัขแล้ว');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $dog_breed)
    {
        $dog_breed_id = DogBreed::find($id);
        $dogs = Dog::where('dog_breed',$dog_breed)->paginate(20);
        $dog_farms = DogFarm::all();
  
        return view('manage_dog_breeds.show',compact('dog_breed_id','dogs','dog_farms'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show_male($id, $dog_breed)
    {
        $dog_breed_id = DogBreed::find($id);
        $dogs = Dog::where('dog_breed',$dog_breed)->where('dog_sex','ตัวผู้')->paginate(20);
        $dog_farms = DogFarm::all();
  
        return view('manage_dog_breeds.show',compact('dog_breed_id','dogs','dog_farms'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show_female($id, $dog_breed)
    {
        $dog_breed_id = DogBreed::find($id);
        $dogs = Dog::where('dog_breed',$dog_breed)->where('dog_sex','ตัวเมีย')->paginate(20);
        $dog_farms = DogFarm::all();
  
        return view('manage_dog_breeds.show',compact('dog_breed_id','dogs','dog_farms'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function sort_farm($id, $dog_breed, $dog_farm_name)
    {
        $dog_breed_id = DogBreed::find($id);
        $dogs = Dog::where('dog_breed',$dog_breed)->where('dog_farm_name',$dog_farm_name)->paginate(20);
        $dog_farms = DogFarm::all();

        return view('manage_dog_breeds.show',compact('dog_breed_id','dogs','dog_farms'))
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
        $dog_breed = DogBreed::find($id);
        $dog_breed->dog_breed = $request->dog_breed;
        $dog_breed->save();

        Dog::where('dog_breed', $request->old_value)
            ->update(['dog_breed' => $request->dog_breed]);

        return redirect()->route('manage_dog_breeds.index')->with('success','แก้ไขสายพันธ์สุนัขแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dog_breed = DogBreed::find($id);
        $dog_breed->delete();

        return redirect()->route('manage_dog_breeds.index')->with('success','ลบสายพันธ์สุนัขแล้ว');
    }
}
