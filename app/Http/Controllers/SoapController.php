<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use nusoap_server;

class SoapController extends Controller
{
    public function server() 
    {
        //Create a new soap server
        $server = new \nusoap_server();

        //Define our namespace
        $namespace = "http://localhost:8000/api";

        //Configure our WSDL
        $server->configureWSDL("HelloWorld",$namespace);

        // Register our method
        $server->register('HelloWorld',
            array('username' => 'xsd:string'),   // parameter
            array('return' => 'xsd:string')     // output
        );

        $server->register('storeContact',
            array(
                'contact_name' => 'xsd:string',
                'contact_phone' => 'xsd:string',
                'contact_email' => 'xsd:string',
                'contact_address' => 'xsd:string',
                'contact_gender' => 'xsd:boolean',
                'contact_profile_picture' => 'xsd:boolean',
            ),
            array('return' => 'xsd:boolean')
        );


        // Get our posted data if the service is being consumed
        // otherwise leave this data blank.
        $server->service(file_get_contents("php://input"));
        exit();
    }
}