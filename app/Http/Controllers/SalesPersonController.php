<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiError;
use App\Http\Requests\CreateSalesPerson;
use App\Models\SalesPerson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SalesPersonController extends Controller
{
    public function index()
    {
        $list = SalesPerson::all();
        if($list->isNotEmpty()){
             return $list;
        }else{
            throw new ApiError("No seller found", 404);
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
        $seller = SalesPerson::find($id);
        if($seller == null){
            throw new ApiError("No seller found", 404);
        }else{
            return $seller;
        }
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSalesPerson $request){
        $form = $request->validated();
        $user = new User();
        $user->email = $form["email"];
        $user->name = $form["firstName"];
        $user->password = Hash::make($form["lastName"]);//maybe create function that changes password on first access
        $user->save();
        $seller = new SalesPerson();
        $seller->id = $user->id;
        $seller->firstName = $form["firstName"];
        $seller->lastName = $form["lastName"];
        $seller->email = $form["email"];
        $seller->save();
       
        
        return $seller;

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Existente = SalesPerson::find($id);
        if($Existente) {
          return  $Existente->delete();
        }else{
            throw new ApiError("No seller found", 404);
        }
    }
}
