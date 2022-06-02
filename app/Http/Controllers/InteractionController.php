<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiError;
use App\Models\Contact;
use App\Models\Interaction;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class InteractionController extends Controller
{
    public function index()
    {
        $list = Interaction::all();
        if($list->isNotEmpty()){
             return $list;
        }else{
            throw new ApiError("No Interaction found", 404);
        }
    }

    public function listByCostumer($id_costumer)
    {
        $contact = Contact::where('id_costumer',$id_costumer)->get()->first();
        if($contact->isNotEmpty()){
             $list = Interaction::where('id_contact', $contact->id);
             if($list->isNotEmpty()){
                return $list;
           }else{
               throw new ApiError("No Interaction found", 404);
           }
        }else{
            throw new ApiError("No Contact found", 404);
        }
    }

    public function get($id)
    {
        $interaction = Interaction::find($id);
        if($interaction == null){
            throw new ApiError("No Interaction found", 404);
        }else{
            return $interaction;
        }
    }

    public function store(Request $request){
        if(!$request["id_contact"]){
            throw new ApiError("Invalid request", 404);
        }else {
            $contact = Contact::find($request["id_contact"]);
            if(!$contact){
                throw new ApiError("Invalid request", 404);
            }else{
                $interaction = New Interaction();
                $interaction->id_contact = $request["id_contact"];
                $interaction->type = $request["type"];
                $interaction->date = $request["date"];
                $interaction->description = $request["description"];
                $interaction->save();
                return $interaction;
            }

        }     
        

    }

    public function destroy($id)
    {
        $Existente = Interaction::find($id);
        if($Existente) {
          return  $Existente->delete();
        }else{
            throw new ApiError("No interaction found", 404);
        }
    }
}
