<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\GetChangeObjects;
use App\Repositories\CategoryRepository;
use App\Repositories\TransactionRepository;
use App\Services\ObjectService;


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
        try {
            $newServerObjects = $this->objectService->getNewServerObjects($request->table_name,$request->versions);
            $newClientObjectIds= $this->objectService->getNewObjectIds($request->table_name,$request->versions);
            $toUpdateClientObjects = $this->objectService->getToUpdateClientObjects($request->table_name,$request->versions);
            $toUpdateServerObjects = $this->objectService->getToUpdateServerObjects($request->table_name,$request->versions);

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
}
