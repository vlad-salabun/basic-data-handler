<?php

namespace Salabun\Bdh\Traits;

trait Update
{
    public function update()
    {
        $this->beforeUpdate();

        $className = $this->request->input('model');

        try {
            $object = $className::where($this->request["where"])->first();

            if($object == null) {
                $this->response["status"] = 404;
                $this->response["error_code"] = 7;
                return false;
            }

            try {
                $data = $this->request->input("data");
                foreach($data as $key => $value) {
                    $object->$key = $value;
                }

                $object->save();

                $this->response["response"] = $object;
                $this->response["status_message"] = "Object updated!";
            } catch (\Exception $e) {
                $this->response["error_code"] = 5;
                $this->response["status"] = 500;

                 $this->response["errors"] = $e->getMessage();
                return false;
            }

        } catch (\Exception $e) {
            $this->response["error_code"] = 6;
            $this->response["status"] = 500;

            $this->response["errors"] = $e->getMessage();
            return false;
        }

        $this->afterUpdate();
    }









}
