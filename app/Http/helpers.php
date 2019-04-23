<?php
    if (! function_exists('HelloWorld')) {
        function HelloWorld($username) {
            return $username;
        }
    }

    if (! function_exists('storeContact')) {
        function storeContact($contact_name, $contact_phone, $contact_email, $contact_address, $contact_gender, $contact_profile_picture) {
            $contact = new Contact();
            $contact->contact_name = $request->contact_name;
            $contact->contact_phone = $request->contact_phone;
            $contact->contact_email = $request->contact_email;
            $contact->contact_address = $request->contact_address;
            $contact->contact_gender = $request->contact_gender;
            if($request->hasFile('contact_profile_picture')){
                $contact->contact_profile_picture=1;
            }
            $contact->user_id = Auth::user()->id;
            $contact->save();

            if($request->hasFile('contact_profile_picture')){
                $request->contact_profile_picture->storeAs('public/contacts', $contact->contact_id.".jpg");
            }
        }
    }