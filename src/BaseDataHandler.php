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

    public $startTime = 0;
    public $endTime = 0;
    public $request = null;
    public $response = [
        "status" => 0,
        "response" => [],
        "execution_time" => 0,
    ];

    public $executionIsAllowed = true;

    public function __construct($request)
    {
        $this->startTime = microtime(true);

        $this->request = $request;

        if(!$this->request->has('debug')) {
            if($this->request->input('debug')) {
                $this->response['request'] = $this->request->toArray();
            }
        }
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

        if($this->request->input('request_type') == "update") {
            $this->update();
        }

        if($this->request->input('request_type') == "read") {
            $this->read();
        }

        if($this->request->input('request_type') == "delete") {
            $this->delete();
        }

        $this->afterReturn();

    }

    public function getResponse()
    {
        $this->beforeResponse();

        $this->endTime = microtime(true);
        $this->response["execution_time"] =
            number_format(($this->endTime - $this->startTime) / 60, 2);

        return $this->response;
    }

    public function stopExecution()
    {
        $this->executionIsAllowed = false;
    }


    public function beforeCreation() {}
    public function afterCreation() {}

    public function beforeRead() {}
    public function afterRead() {}

    public function beforeUpdate() {}
    public function afterUpdate() {}

    public function beforeDelete() {}
    public function afterDelete() {}

    public function afterReturn() {}
    public function beforeResponse() {}










}
