<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\GetChangeObjects;
use App\Http\Requests\StoreBatchObjects;
use App\Repositories\CategoryRepository;
use App\Repositories\TransactionRepository;
use App\Services\CategoryService;
use App\Services\ObjectService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class ObjectVersionController extends ApiController
{

    protected  $objectService;

    public function __construct(
        CategoryRepository  $categoryRepository,
        TransactionRepository $transactionRepository,
        CategoryService $categoryService
    )
    {
        $this->objectService = new ObjectService($categoryRepository,$transactionRepository,$categoryService);
    }
    public function getChangedTransactions(GetChangeObjects $request){
        $versions = $request->versions;
        $TABLE_NAME="transactions";

        try {
            $newServerObjects = $this->objectService->getNewServerObjects(Auth::user(),$TABLE_NAME,$versions);
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
    }

    public function getChangedCategories(GetChangeObjects $request){
        $versions = $request->versions;
        $TABLE_NAME="categories";

        try {
            $newServerObjects = $this->objectService->getNewServerObjects(Auth::user(),$TABLE_NAME,$versions);
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
    }

    public function storeBatch(StoreBatchObjects $request){
        try {
            $objects = array_map(function($obj) {
                $obj['user_id'] = auth()->user()->google_user_id;

                // Map timestamps to Laravel's format, handling null values
                $obj['created_at'] = isset($obj['created_at']) ? Carbon::createFromTimestampMs($obj['created_at'])->format('Y-m-d H:i:s') : null;
                $obj['updated_at'] = isset($obj['updated_at']) ? Carbon::createFromTimestampMs($obj['updated_at'])->format('Y-m-d H:i:s') : null;
                $obj['deleted_at'] = isset($obj['deleted_at']) ? Carbon::createFromTimestampMs($obj['deleted_at'])->format('Y-m-d H:i:s') : null;

                return $obj;
            }, $request->objects);


            $isObjectsStored = $this->objectService->storeBatchObjects($request->table_name,$objects);
            if($isObjectsStored) return $this->respondNoContent();
        }catch (\Exception $e){
            return $this->respondError("Cannot store objects.");
        }

        return $this->respondError("Cannot store objects.");
    }
}
