<?php

namespace Salabun\Bdh\Traits;

trait Read
{
    public function read()
    {
        $this->beforeRead();

        $className = $this->request->input('model');

        try {
            $object = $className::where($this->request["where"]);

            if($this->request->has("order_by")) {
                foreach($this->request["order_by"] as $orderParams) {
                    $object->orderBy($orderParams[0], $orderParams[1]);
                }

            }

            if($this->request->has("with")) {
                foreach($this->request["with"] as $relation) {
                    $object->with($relation);
                }
            }

            $pagination = false;
            if($this->request->has("pagination")) {
                $pagination = $this->request["pagination"];
            }

            if($pagination) {
                $records = $object->paginate($pagination);
            } else {
                $records = $object->get();
            }






            //order_by
            $this->response["response"] = $records;

        } catch (\Exception $e) {
            $this->response["error_code"] = 8;
            $this->response["status"] = 500;

            $this->response["errors"] = $e->getMessage();
            return false;
        }

        $this->afterRead();



    }
}
