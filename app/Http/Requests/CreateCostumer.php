<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCostumer extends FormRequest
{
    private $costumerRules;
    

    public function __construct()
    {
        parent::__construct();
        $this->costumerRules = [
            "firstName" => "required",
            "lastName" => "required",
            "companyName" => "required",
            "industry" => "nullable",
            "address" => "nullable",
            "phoneNumber" => "required",
            "email"=>"required|email",
        ];
        //dd($this->instrutorRules);
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
        return  $this->costumerRules;

    }
}
