<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Message;
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
        $apartments = Apartment::where('user_id',Auth::id())->get();
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
        $services_ids = [];
        return view('admin.apartments.create', compact('apartment', 'services', 'services_ids'));
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
                'num_rooms' => 'required|numeric|min:1|max:255',
                'num_bathroom' => 'required|numeric|min:1|max:255',
                'num_bed' => 'required|numeric|min:1|max:255',
                'square_meters' => 'required|numeric|min:5|max:60000',
                'address' => 'required|string',
                'image' => 'required|image',
            ],
            [
                'descriptive_title.required' => 'Devi inserire il titolo',
                'descriptive_title.min' => 'Il titolo deve essere minimo :min caratteri',
                'descriptive_title.max' => 'Il titolo deve essere massimo :max caratteri',

                'num_rooms.required' => 'Devi inserire il numero di stanze',
                'num_rooms.min' => 'Il numero delle stanze deve essere minimo :min',
                'num_rooms.max' => 'Il numero delle stanze deve essere massimo :max',

                'num_bathroom.required' => 'Devi inserire il numero di bagni',
                'num_bathroom.min' => 'Il numero dei bagni deve essere minimo :min',
                'num_bathroom.max' => 'Il numero dei bagni deve essere massimo :max',

                'num_bed.required' => 'Devi inserire il numero di letti',
                'num_bed.min' => 'Il numero dei letti deve essere minimo :min',
                'num_bed.max' => 'Il numero dei letti deve essere massimo :max',

                'square_meters.required' => 'Devi inserire i metri quadri',
                'square_meters.min' => 'I metri quadri devono essere minimo :min',
                'square_meters.max' => 'I metri quadri devono essere massimo :max',

                'address.required' => 'Devi inserire l\'indirizzo',

                'image.required' => 'Devi inserire un\'immagine',
                'image.mimes' => 'L\'immagine deve avere uno di questi formati: jpeg, jpg, svg, png ',
                'image.image' => ' Il file deve essere un immagine'
            ]
        );
        $data = $request->all();
        $new_apartment = new Apartment();
        $new_apartment->user_id = Auth::id();
        $new_apartment->fill($data);
        $new_apartment->visibility = array_key_exists('visibility', $data);
        
       

        if(array_key_exists('image', $data)){
            $image_url = Storage::put('apartments', $data['image']);
            $new_apartment->image = $image_url;
        }
        $new_apartment->save();
        $services = [];
        if(array_key_exists('services_array', $data)){
            $new_apartment->services()->attach($data['services_array']);
        }
        return redirect()->route('admin.apartments.show', $new_apartment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        if($apartment->user_id != Auth::id()) return abort('404');

        $messages = Message::where('apartment_id', $apartment->id)->get();

        return view('admin.apartments.show', compact('apartment', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {   
        if($apartment->user_id != Auth::id()) return abort('404');

        $services = Service::all();
        $services_ids = $apartment->services->pluck('id')->toArray();
        return view('admin.apartments.edit', compact('apartment', 'services', 'services_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $request->validate(
            [ 
                'descriptive_title' => 'required|string|min:4|max:255',
                'num_rooms' => 'required|numeric|min:1|max:255',
                'num_bathroom' => 'required|numeric|min:1|max:255',
                'num_bed' => 'required|numeric|min:1|max:255',
                'square_meters' => 'required|numeric|min:5|max:60000',
                'address' => 'required|string',
                'image' => 'nullable|image',
            ],
            [
                'descriptive_title.required' => 'Devi inserire il titolo',
                'descriptive_title.min' => 'Il titolo deve essere minimo :min caratteri',
                'descriptive_title.max' => 'Il titolo deve essere massimo :max caratteri',

                'num_rooms.required' => 'Devi inserire il numero di stanze',
                'num_rooms.min' => 'Il numero delle stanze deve essere minimo :min',
                'num_rooms.max' => 'Il numero delle stanze deve essere massimo :max',

                'num_bathroom.required' => 'Devi inserire il numero di bagni',
                'num_bathroom.min' => 'Il numero dei bagni deve essere minimo :min',
                'num_bathroom.max' => 'Il numero dei bagni deve essere massimo :max',

                'num_bed.required' => 'Devi inserire il numero di letti',
                'num_bed.min' => 'Il numero dei letti deve essere minimo :min',
                'num_bed.max' => 'Il numero dei letti deve essere massimo :max',

                'square_meters.required' => 'Devi inserire i metri quadri',
                'square_meters.min' => 'I metri quadri devono essere minimo :min',
                'square_meters.max' => 'I metri quadri devono essere massimo :max',

                'address.required' => 'Devi inserire l\'indirizzo',

                'image.required' => 'Devi inserire un\'immagine',
                'image.mimes' => 'L\'immagine deve avere uno di questi formati: jpeg, jpg, svg, png ',
                'image.image' => ' Il file deve essere un immagine'
            ]
        );
        $data = $request->all();
        if(!array_key_exists('visibility', $data)) {
            $apartment->visibility = 0;
        };

        if(array_key_exists('image', $data)){
            if($apartment->image)Storage::delete($apartment->image);
            $image_url = Storage::put('apartments', $data['image']);
            $apartment->image = $image_url;
        }
        $apartment->update($data);

        if(array_key_exists('services_array', $data)){
            $apartment->services()->sync($data['services_array']);
        }
        return redirect()->route('admin.apartments.show', $apartment);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        if($apartment->user_id != Auth::id()) return abort('404');

        if($apartment->image)Storage::delete($apartment->image);
        $apartment->delete();
        return redirect()->route('admin.apartments.index');
    }
}
