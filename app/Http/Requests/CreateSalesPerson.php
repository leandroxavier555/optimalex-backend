<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSalesPerson extends FormRequest
{
    private $sellerRules;
    

    public function __construct()
    {
        parent::__construct();
        $this->sellerRules = [
            "firstName" => "required",
            "lastName" => "required",
            "email"=>"required|email",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return  $this->sellerRules;

    }
}
