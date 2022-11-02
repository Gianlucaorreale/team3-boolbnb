<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\Message;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::orderBy('created_at', 'DESC')
        ->with(['services','user'])
        ->get();

        return response()->json($apartments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request)
    {
        $data = $request->all();
        $apartment = $data[0];
        $form = $data[1];
        $validation = Validator::make($form,
        [
            'email' => 'required|email',
            'content' => 'required|string',
        ],[
            'email.required' => 'L\'email è obbligatoria',
            'email.email' => 'La mail inserita non è valida',
            'content.required' => 'Il contenuto del messsaggio non può esssere vuoto',
        ]);

        if($validation->fails()) {
            return response()->json(['errors' => $validation->errors()]);
        }
        $new_message = new Message();
        $new_message->apartment_id = $apartment['id'];
        $new_message->email = $form['email'];
        $new_message->content = $form['content'];
        $new_message->save();
        
        return response()->json([$new_message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($descriptive_title)
    {
        $apartment = Apartment::with('services','user')->where('descriptive_title', $descriptive_title)->get();
        return response()->json($apartment);
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
