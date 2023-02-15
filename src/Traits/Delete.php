<?php

namespace Salabun\Bdh\Traits;

trait Delete
{
    public function delete()
    {
        $this->beforeDelete();

        if(!$this->executionIsAllowed) {
            return false;
        }

        $className = $this->request->input('model');

        try {
            $object = $className::where($this->request["where"])->first();

            if($object == null) {
                $this->response["status"] = 404;
                $this->response["status_message"] = "Object not found!";

                return false;
            }

            $object->delete();
            $this->response["status_message"] = "Object deleted!";

        } catch (\Exception $e) {
            $this->response["error_code"] = 9;
            $this->response["status"] = 500;

            $this->response["errors"] = $e->getMessage();
            return false;
        }

        $this->afterDelete();
    }


}
