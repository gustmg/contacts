<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Auth;
use View;
use File;


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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        // if($request->ajax()){
        //     $validatedData = $request->validate([
        //         'contact_name' => 'required',
        //         'contact_phone' => 'required',
        //         'contact_email' => 'required',
        //         'contact_gender' => 'required'
        //     ]);

        //     $contact = new Contact();
        //     $contact->contact_name = $request->contact_name;
        //     $contact->contact_phone = $request->contact_phone;
        //     $contact->contact_email = $request->contact_email;
        //     $contact->contact_address = $request->contact_address;
        //     $contact->contact_gender = $request->contact_gender;
        //     if($request->hasFile('contact_profile_picture')){
        //         $contact->contact_profile_picture=1;
        //     }
        //     $contact->user_id = Auth::user()->id;
        //     $contact->save();

        //     if($request->hasFile('contact_profile_picture')){
        //         $request->contact_profile_picture->storeAs('public/contacts', $contact->contact_id.".jpg");
        //     }

        //     return response()->json([
        //         "message" => "Contacto creado correctamente.",
        //         "contact_id" => $contact->contact_id
        //     ],200);
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $contact_id)
    {
        if($request->ajax()){
            $validatedData = $request->validate([
                'contact_name' => 'required',
                'contact_phone' => 'required',
                'contact_email' => 'required',
                'contact_gender' => 'required'
            ]);

            $contact = Contact::find($contact_id);
            $contact->contact_name = $request->contact_name;
            $contact->contact_phone = $request->contact_phone;
            $contact->contact_email = $request->contact_email;
            $contact->contact_address = $request->contact_address;
            $contact->contact_gender = $request->contact_gender;
            if($request->hasFile('contact_profile_picture')){
                $contact->contact_profile_picture=1;
            }
            else{
                $contact->contact_profile_picture=0;
            }
            $contact->user_id = Auth::user()->id;
            $contact->save();

            if($request->hasFile('contact_profile_picture')){
                if(File::exists('public/contacts'.$contact->contact_id.".jpg")){
                    File::delete('public/contacts'.$contact->contact_id.".jpg");
                }
                $request->contact_profile_picture->storeAs('public/contacts', $contact->contact_id.".jpg");
            }

            return response()->json([
                "message" => "Contacto actualizado correctamente.",
                "request" => $request->contact_name
            ],200);
        }
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
