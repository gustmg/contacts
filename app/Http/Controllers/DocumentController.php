<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Fpdf;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if($request->format == "doc"){
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            
            foreach($request->contacts as $contact_id){
                $contact=Contact::find($contact_id);
                if($contact->contact_profile_picture){
                    $section->addImage("storage/contacts/".$contact_id.".png", array(
                        'width'         => 100,
                        'height'        => 100,
                    ));  
                }
                else{
                    $section->addImage("storage/img/profile_picture.png", array(
                        'width'         => 100,
                        'height'        => 100,
                    )); 
                }
                
                $text = $section->addText("CONTACTO: ".$contact->contact_name);
                $text = $section->addText("TELEFONO: ".$contact->contact_phone);
                $text = $section->addText("EMAIL: ".$contact->contact_email);
                if($contact->contact_gender==0){
                    $text = $section->addText("SEXO: Masculino");
                }
                else{
                    $text = $section->addText("SEXO: Femenino");
                }
                $text = $section->addText("DIRECCION: ".$contact->contact_address);
            }

            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save('prueba.docx');
            return "prueba.docx";
        }
        else if($request->format == "pdf"){
            Fpdf::AddPage();
            Fpdf::SetFont('Arial', 'B', 10);
            
            foreach($request->contacts as $key=>$contact_id){
                $contact=Contact::find($contact_id);
                if($contact->contact_profile_picture){
                    Fpdf::Image("storage/contacts/".$contact_id.".png",10,10+(36*($key)),30,30);
                }
                else{
                    Fpdf::Image("storage/img/profile_picture.png",10,10+(36*($key)),30,30);
                }
                Fpdf::Cell(40);
                Fpdf::Cell(0, 6, 'Nombre: '.$contact->contact_name,0,1);
                Fpdf::Cell(40);
                Fpdf::Cell(0, 6, 'Email: '.$contact->contact_email,0,1);
                Fpdf::Cell(40);
                Fpdf::Cell(0, 6, 'Telefono: '.$contact->contact_phone,0,1);
                Fpdf::Cell(40);
                if($contact->contact_gender==0){
                    Fpdf::Cell(0, 6, 'Sexo: Masculino',0,1);
                }
                else{
                    Fpdf::Cell(0, 6, 'Sexo: Femenino',0,1);
                }
                
                Fpdf::Cell(40);
                Fpdf::Cell(0, 6, 'Direccion: '.$contact->contact_address,0,1);
                Fpdf::Ln();
            }

            Fpdf::Output('F', "prueba.pdf");

            return "prueba.pdf";
        }

        else if($request->format == "xls"){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(35);
            $sheet = $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $sheet = $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(35);
            $sheet = $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $sheet = $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $sheet = $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $sheet = $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(35);
            
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValueByColumnAndRow(1, 1, "CONTACTO");
            $sheet->setCellValueByColumnAndRow(2, 1, "TELEFONO");
            $sheet->setCellValueByColumnAndRow(3, 1, "EMAIL");
            $sheet->setCellValueByColumnAndRow(4, 1, "SEXO");
            $sheet->setCellValueByColumnAndRow(5, 1, "DIRECCION");
            $sheet->setCellValueByColumnAndRow(6, 1, "IMAGEN DE CONTACTO");
            foreach($request->contacts as $key=>$contact_id){
                $contact=Contact::find($contact_id);
                $sheet = $spreadsheet->getActiveSheet()->getRowDimension($key+2)->setRowHeight(110);
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValueByColumnAndRow(1, $key+2, $contact->contact_name);
                $sheet->setCellValueByColumnAndRow(2, $key+2, $contact->contact_phone);
                $sheet->setCellValueByColumnAndRow(3, $key+2, $contact->contact_email);
                if($contact->contact_gender==0){
                    $sheet->setCellValueByColumnAndRow(4, $key+2, "Masculino");
                }
                else{
                    $sheet->setCellValueByColumnAndRow(4, $key+2, "Femenino");
                }
                $sheet->setCellValueByColumnAndRow(5, $key+2, $contact->contact_address);

                if($contact->contact_profile_picture){
                    $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $objDrawing->setName('test_img');
                    $objDrawing->setDescription('test_img');
                    $objDrawing->setPath("storage/contacts/".$contact_id.".png");
                    $objDrawing->setCoordinates('F'.($key+2));                      
                    //setOffsetX works properly
                    $objDrawing->setOffsetX(5); 
                    $objDrawing->setOffsetY(5);                
                    //set width, height
                    $objDrawing->setWidth(100); 
                    $objDrawing->setHeight(100); 
                    $objDrawing->setWorksheet($spreadsheet->getActiveSheet());
                }
                else{
                    $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $objDrawing->setName('test_img');
                    $objDrawing->setDescription('test_img');
                    $objDrawing->setPath("storage/img/profile_picture.png");
                    $objDrawing->setCoordinates('F'.($key+2));                      
                    //setOffsetX works properly
                    $objDrawing->setOffsetX(5); 
                    $objDrawing->setOffsetY(5);                
                    //set width, height
                    $objDrawing->setWidth(100); 
                    $objDrawing->setHeight(100); 
                    $objDrawing->setWorksheet($spreadsheet->getActiveSheet());
                }
            }

            $writer = new Xlsx($spreadsheet);
            $writer->save('prueba.xlsx');

            return "prueba.xlsx";
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
        //
    }
}
