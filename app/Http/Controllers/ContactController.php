<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiError;
use App\Models\Contact;
use App\Models\Costumer;
use App\Models\Interaction;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use stdClass;

class ContactController extends Controller
{
    public function index()
    {
        $list = Contact::all();
        if($list->isNotEmpty()){
             return $list;
        }else{
            throw new ApiError("No contact found", 404);
        }
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listBySeler($id_seller)
    {
        $list = Contact::where('id_sales_person',$id_seller)->get();
        $result = array();
        
       
        if($list->isNotEmpty()){
             foreach($list as $con){
                 $inter = Interaction::where('id_contact', $con->id)->get();
                 $costumer = Costumer::find($con->id_costumer);
                 $aux = ["contact" => $con, "costumer" => $costumer , "interactions"=>$inter];
                 $obj2 = new class{};
                 $obj2->contact = $con;
                 $obj2->costumer = $costumer;
                 $obj2->interactions = $inter;
                $aux2 =   (array) $obj2 ;
                array_push($result, $obj2);
             }
             return $result;
        }else{
            throw new ApiError("No contact found", 404);
        }
    }

    public function changeInteractions(Request $request){
        $contact = Contact::find($request["contactId"]);
        $contact->stage = $request["stage"];
        $contact->save();
        $interactions = $request["interactions"];
        $ids = [];
        foreach($interactions as $inte){
            if(array_key_exists('id', $inte)){
                $existente = Interaction::find($inte["id"]);
                $existente->type = $inte["type"];
                $existente->description = $inte["description"];
                $existente->date = $inte["date"];
                $existente->save();
                array_push($ids,$inte["id"]);
            }else{
                $new = new Interaction();
                $new->type = $inte["type"];
                $new->description = $inte["description"];
                $new->date = $inte["date"];
                $new->id_contact = $contact->id;
                $new->save();
                array_push($ids,$new->id);
            }
        }
        //now delete interactions that are not in the list
        $allInteractions = Interaction::where('id_contact',$contact->id)->get();
        foreach($allInteractions as $int){
            if(!in_array($int->id, $ids)){
                $int->delete();
            }
        }
    }

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $contact = Contact::find($id);
        if($contact == null){
            throw new ApiError("No contact found", 404);
        }else{
            return $contact;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $costumer = Costumer::find($request["id_costumer"]);
        $seller = SalesPerson::find($request["id_sales_person"]);
        if(!$costumer){
            throw new ApiError("Costumer is a required field", 404);
        }else if(!$seller){
            throw new ApiError("Salesperson is a required field", 404);
        }else{
                $contact = New Contact();
                $contact->id_costumer = $request["id_costumer"];
                $contact->id_sales_person = $request["id_sales_person"];
                $contact->first_contact_date = $request["first_contact_date"];
                $contact->note = $request["note"];
                $contact->stage = "Lead";
                $contact->save();
                $costumer->started = true;
                $costumer->save();
                return $contact;

        }     
        

    }

    public function destroy($id)
    {
        $Existente = Contact::find($id);
        if($Existente) {
          return  $Existente->delete();
        }else{
            throw new ApiError("No contact found", 404);
        }
    }
}
