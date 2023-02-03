<?php

namespace Salabun\Bdh\Traits;

trait Error
{

    public $errorCodes = [
        0 => "Unknown Error.",
        1 => "Model not specified.",
        2 => "Model not exists.",
        3 => "Request type not specified.",
        4 => "Data not specified.",
        5 => "Error while creation.",
    ];

    public function getErrorMessage($code)
    {
        if(array_key_exists($code, $this->errorCodes)) {
            return $this->errorCodes[$code];
        }

        return $this->errorCodes[0];
    }
}
