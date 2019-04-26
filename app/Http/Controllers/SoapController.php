<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;

class SoapController extends Controller
{
    public function server() 
    {
        //Create a new soap server
        // $server = new \nusoap_server();

        // //Define our namespace
        // $namespace = "http://localhost:8000/api";

        // //Configure our WSDL
        // $server->configureWSDL("HelloWorld",$namespace);

        // // Register our method
        // $server->register('HelloWorld',
        //     array('username' => 'xsd:string'),   // parameter
        //     array('return' => 'xsd:string')     // output
        // );

        // $server->register('storeContact',
        //     array('contact' => 'xsd:string'),
        //     array('return' => 'xsd:string')
        // );

        // // Get our posted data if the service is being consumed
        // // otherwise leave this data blank.
        // $server->service(file_get_contents("php://input"));
        // exit();
    }

    public function storeContact($contact){
        return "Hola";
    }
}