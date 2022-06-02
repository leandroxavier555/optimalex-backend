<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use App\Exceptions\ApiError;
use App\Http\Requests\CreateCostumer;
use App\Models\Contact;
use App\Models\Interaction;
use App\Models\SalesPerson;
use Illuminate\Http\Request;

class CostumerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Costumer::where('started',false)->get();
        if($list->isNotEmpty()){
             return $list;
        }else{
            throw new ApiError("No leads found", 404);
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
        $costumer = Costumer::find($id);
        if($costumer == null){
            throw new ApiError("No leads found", 404);
        }else{
            return $costumer;
        }
    }
      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCostumer $request){
        //dd($request);
        $form = $request->validated();
        $costumer = new Costumer();
        $costumer->firstName = $form["firstName"];
        $costumer->lastName = $form["lastName"];
        $costumer->companyName = $form["companyName"];
        $costumer->industry = $form["industry"];
        $costumer->address = $form["address"];
        $costumer->phoneNumber = $form["phoneNumber"];
        $costumer->email = $form["email"];
        $costumer->started = false;
        $costumer->save();
        
        return $costumer;

    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Existente = Costumer::find($id);
        if($Existente) {
            $contact = Contact::where('id_costumer', $id)->get();
            if($contact->isNotEmpty()){
                foreach($contact as $con){
                $int = Interaction::where('id_contact',$con->id)->get();
                if($int ->isNotEmpty()){
                    foreach($int as $i){
                        $i->delete();
                    }
                }
                $con->delete();
            }
            }

          return  $Existente->delete();
        }else{
            throw new ApiError("No leads found", 404);
        }
    }

}
