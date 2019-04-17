<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Auth;
use View;


class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts=Contact::where('user_id', Auth::user()->id)->get();
        return View::make('contacts.index', ['contacts'=>$contacts]);
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
        if($request->ajax()){
            // $validatedData = $request->validate([
            //     'contact_name' => 'required',
            //     'contact_phone' => 'required',
            //     'contact_email' => 'required',
            //     'contact_gender' => 'required'
            // ]);

            // $contact = new Contact();
            // $contact->contact_name = $request->contact_name;
            // $contact->contact_phone = $request->contact_phone;
            // $contact->contact_email = $request->contact_email;
            // $contact->contact_address = $request->contact_address;
            // $contact->contact_gender = $request->contact_gender;
            // $contact->user_id = Auth::user()->id;
            // $contact->save();

            return $request->contact_profile_picture->store('images');

            // return response()->json([
            //     "message" => "Contacto creado correctamente.",
            //     // "contact_id" => $contact->contact_id
            // ],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $contact = Contact::find($id);
        $contact->delete();

        return response()->json([
            "message" => "Contacto eliminado correctamente."
        ],200);        
    }
}
