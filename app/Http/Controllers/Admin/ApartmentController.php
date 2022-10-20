<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::findOrFail(auth()->user()->id)->get();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apartment = new Apartment();
        $services = Service::all();
        return view('admin.apartments.create', compact('apartment', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [ 
                'descriptive_title' => 'required|string|min:4|max:255',
                'num_rooms' => 'required|number|min:1|max:255',
                'num_bathroom' => 'required|number|min:1|max:255',
                'num_bed' => 'required|number|min:1|max:255',
                'square_meters' => 'required|number|min:5|max:60000',
                'address' => 'required|string',
                'image' => 'require|url',
            ],
            [
                'descriptive_title.required' => 'Devi inserire il titolo',
                'descriptive_title.min' => 'il titolo deve essere minimo :min caratteri',
                'descriptive_title.max' => 'il titolo deve essere massimo :max caratteri',

                'num_rooms.required' => 'Questo è un parametro obbligatorio',
                'num_rooms.number' => 'Questo campo deve essere un numero',
                'num_rooms.min' => 'il numero delle stanze deve essere minimo :min',
                'num_rooms.max' => 'il numero delle stanze deve essere massimo :max',

                'num_bathroom.required' => 'Questo è un parametro obbligatorio',
                'num_bathroom.number' => 'Questo campo deve essere un numero',
                'num_bathroom.min' => 'il numero dei bagni deve essere minimo :min',
                'num_bathroom.max' => 'il numero dei bagni deve essere massimo :max',

                'num_bed.required' => 'Questo è un parametro obbligatorio',
                'num_bed.number' => 'Questo campo deve essere un numero',
                'num_bed.min' => 'il numero dei letti deve essere minimo :min',
                'num_bed.max' => 'il numero dei letti deve essere massimo :max',

                'square_meters.required' => 'Questo è un parametro obbligatorio',
                'square_meters.number' => 'Questo campo deve essere un numero',
                'square_meters.min' => 'i metri quadri devono essere minimo :min',
                'square_meters.max' => 'i metri quadri devono essere massimo :max',

                'address.required' => 'Questo è un parametro obbligatorio',

                'image.required' => 'Questo è un parametro obbligatorio',
                'image.url' => 'Questo campo deve essere un url valido',
            ]
        );
        $data = $request->all();
        $apartment = new Apartment();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
