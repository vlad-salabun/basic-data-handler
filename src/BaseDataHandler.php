<?php

namespace Salabun\Bdh;

use Salabun\Bdh\Traits\Create;
use Salabun\Bdh\Traits\Read;
use Salabun\Bdh\Traits\Update;
use Salabun\Bdh\Traits\Delete;
use Salabun\Bdh\Traits\Error;

class BaseDataHandler
{
    use Create, Read, Update, Delete, Error;

    public $request = null;
    public $response = [
        "status" => 0,
        "request" => [],
        "response" => [],
        "execution_time" => 0,
    ];

    public function __construct($request)
    {
        $this->request = $request;
        $this->response['request'] = $this->request->toArray();

        return $this->request;
    }

    public function handleRequest()
    {
        if(!$this->request->has('model')) {
            $this->response["errors"] = $this->getErrorMessage(1);
            $this->response["error_code"] = 1;
            $this->response["status"] = 500;
            return false;
        }

        if(!$this->request->has('request_type')) {
            $this->response["errors"] = $this->getErrorMessage(3);
            $this->response["error_code"] = 3;
            $this->response["status"] = 500;
            return false;
        }

        if(!$this->request->has('data')) {
            $this->response["errors"] = $this->getErrorMessage(4);
            $this->response["error_code"] = 4;
            $this->response["status"] = 500;
            return false;
        }


        if(!class_exists($this->request->input('model'))) {
            $this->response["errors"] = $this->getErrorMessage(2);
            $this->response["error_code"] = 2;
            $this->response["status"] = 400;
            return false;
        }

        $this->response["status"] = 200;

        if($this->request->input('request_type') == "create") {
            $this->create();
        }

        $this->afterReturn();

    }

    public function getResponse()
    {
        $this->beforeResponse();
        return $this->response;
    }

    public function afterReturn() {}
    public function beforeResponse() {}










}
