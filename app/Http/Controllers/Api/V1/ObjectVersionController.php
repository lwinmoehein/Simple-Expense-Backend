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
    public function getChangedTransactions(GetChangeObjects $request){
        $versions = $request->versions;
        $TABLE_NAME="transactions";

        try {
            $newServerObjects = $this->objectService->getNewServerObjects($TABLE_NAME,$versions);
            $newClientObjectIds= $this->objectService->getNewObjectIds($TABLE_NAME,$versions);
            $toUpdateClientObjects = $this->objectService->getToUpdateClientObjects($TABLE_NAME,$versions);
            $toUpdateServerObjects = $this->objectService->getToUpdateServerObjects($TABLE_NAME,$versions);

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

    public function getChangedCategories(GetChangeObjects $request){
        $versions = $request->versions;
        $TABLE_NAME="categories";

        try {
            $newServerObjects = $this->objectService->getNewServerObjects($TABLE_NAME,$versions);
            $newClientObjectIds= $this->objectService->getNewObjectIds($TABLE_NAME,$versions);
            $toUpdateClientObjects = $this->objectService->getToUpdateClientObjects($TABLE_NAME,$versions);
            $toUpdateServerObjects = $this->objectService->getToUpdateServerObjects($TABLE_NAME,$versions);

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
            $isObjectsStored = $this->objectService->storeBatchObjects($request->table_name,$request->objects);
            if($isObjectsStored) return $this->respondNoContent();
//        }catch (\Exception $e){
//            return $this->respondError("Cannot store objects.");
//        }

        return $this->respondError("Cannot store objects.");
    }
}
