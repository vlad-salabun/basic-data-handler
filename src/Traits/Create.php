<?php

namespace Salabun\Bdh\Traits;

trait Create
{
    public function create()
    {
        $this->beforeCreation();

        if(!$this->executionIsAllowed) {
            return false;
        }

        $className = $this->request->input('model');
        $object = new $className();

        try {
            $data = $this->request->input("data");
            foreach($data as $key => $value) {
                $object->$key = $value;
            }

            $object->save();

            $this->response["response"] = $object;
            $this->response["status_message"] = "Object created!";
        } catch (\Exception $e) {
            $this->response["error_code"] = 5;
            $this->response["status"] = 500;

            $this->response["errors"] = $e->getMessage();
            return false;
        }

        $this->afterCreation();
    }


}
