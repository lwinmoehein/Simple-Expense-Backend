<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\GetChangeObjects;
use App\Http\Requests\StoreBatchObjects;
use App\Repositories\CategoryRepository;
use App\Repositories\TransactionRepository;
use App\Services\ObjectService;
use Illuminate\Support\Arr;


class ObjectVersionController extends ApiController
{

    protected  $objectService;

    public function __construct(
        CategoryRepository  $categoryRepository,
        TransactionRepository $transactionRepository
    )
    {
        $this->objectService = new ObjectService($categoryRepository,$transactionRepository);
    }

    public function getChangedObjects(GetChangeObjects $request){
        $versions = $request->versions;
        try {
            $newServerObjects = $this->objectService->getNewServerObjects($request->table_name,$versions);
            $newClientObjectIds= $this->objectService->getNewObjectIds($request->table_name,$versions);
            $toUpdateClientObjects = $this->objectService->getToUpdateClientObjects($request->table_name,$versions);
            $toUpdateServerObjects = $this->objectService->getToUpdateServerObjects($request->table_name,$versions);

            return $this->respondWithSuccess(["data" => [
                "new_server_objects" => $newServerObjects,
                "new_client_object_ids" => $newClientObjectIds,
                "objects_to_update_client" => $toUpdateClientObjects,
                "objects_to_update_server" => $toUpdateServerObjects
            ]]);
        }catch (\Exception $e){
            return $this->respondError("Cannot get changed objects.");
        }

        return $this->respondError("Cannot get changed objects.");
    }

    public function storeBatch(StoreBatchObjects $request){
        try {
            $isObjectsStored = $this->objectService->storeBatchObjects($request->table_name,$request->objects);
            if($isObjectsStored) return $this->respondNoContent();
        }catch (\Exception $e){
            return $this->respondError("Cannot store objects.");
        }

        return $this->respondError("Cannot store objects.");
    }
}
