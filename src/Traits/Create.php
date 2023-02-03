<?php

namespace Salabun\Bdh\Traits;

trait Create
{
    public function create()
    {
        $this->beforeCreation();
        // TODO: try-catch
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
        $this->beforeReturn();
    }

    public function beforeCreation() {}
    public function afterCreation() {}
    public function beforeReturn() {}
}
