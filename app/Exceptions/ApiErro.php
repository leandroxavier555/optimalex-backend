<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ApiError extends Exception
{
    // public function __construct($msg,$statusCode) {
    //     $this->$message = $msg;
    //     $this->$statusCode = $statusCode;
    // }
    //

    public function report() {
        // Log::
    }

    // public function render() {
    //     return response()->json(['message' => parent::getMessage(),'code' => parent::getCode()]);
    // }
}
