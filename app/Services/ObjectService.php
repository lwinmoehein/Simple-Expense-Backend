<?php
namespace App\Services;

use App\Models\Category;
use App\Models\User;
use App\Repositories\CategoryRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;


class  ObjectService {
    protected  $categoryRepository;
    protected $transactionRepository;

    protected $categoryService;

    public function __construct(
        CategoryRepository  $categoryRepository,
        TransactionRepository $transactionRepository,
        CategoryService $categoryService
    ){
        $this->categoryRepository = $categoryRepository;
        $this->transactionRepository = $transactionRepository;
        $this->categoryService = $categoryService;
    }

    public function getNewServerObjects(User $user,$table_name,array $versions):Collection{
        $allObjects = $this->getAllObjectsByTable($table_name);

        return $allObjects->filter(function ($category) use ($versions) {
            if(in_array($category->unique_id,array_column($versions,"unique_id"))){
                return false;
            }
            return true;
        })->values();
    }
    public function storeBatchObjects(string $tableName,array $objects):bool{
        return $this->storeObjectsByTableName($tableName,$objects);
    }

    public function getToUpdateClientObjects($table_name,array $versions):Collection{
        $allObjects = $this->getAllObjectsByTable($table_name);
        $allClientObjectIds = array_map(function($obj) {
            return $obj["unique_id"];
        }, $versions);

        return $allObjects->filter(function ($item) use ($versions,$allClientObjectIds) {
            foreach ($versions as $v){
                $serverVersionUpdatedAt = Carbon::createFromFormat("Y-m-d H:i:s", $item->updated_at);
                $clientVersionUpdatedAt = Carbon::createFromTimestamp($v['updated_at']);

                if(($v["unique_id"]==$item->unique_id &&  ($item->version>$v['version'] || ($item->version==$v['version'] && $serverVersionUpdatedAt->gt($clientVersionUpdatedAt) )) && $item->deleted_at==null)){
                    return true;
                }
            }
            return false;

        })->values();
    }
    public function getNewObjectIds($table_name,array $versions): array
    {
        $allObjects = $this->getAllObjectsByTable($table_name)->toArray();
        $serverVersions = array_column($allObjects, 'unique_id');
        $clientVersions = $versions;
        $serverUniqueIds = array_column($allObjects,"unique_id");

        $newClientVersions =  array_filter($clientVersions,function($version) use ($serverUniqueIds){
            return !in_array($version["unique_id"],$serverUniqueIds);
        });
        return array_column($newClientVersions,"unique_id");
    }
    public function getToUpdateServerObjects($table_name,array $versions):Collection{
        $allObjects = $this->getAllObjectsByTable($table_name);

        $filteredObjects =  $allObjects->filter(function ($category) use ($versions) {
            foreach ($versions as $v){
              if($v["unique_id"]==$category->unique_id && $category->version<$v['version']){
                  return true;
              }
            }
            return false;
        });
        return $filteredObjects->values();
    }
    public function getAllObjectsByTable($table_name){
        switch ($table_name){
            case "transactions":
                return $this->transactionRepository->getAll();
            default:
                return $this->categoryRepository->getAll();
        }
    }
    public function storeObjectsByTableName($table_name,$objects){
        switch ($table_name){
            case "transactions":
                return $this->transactionRepository->batchUpdateOrCreate($objects);
            default:
                return $this->categoryRepository->batchUpdateOrCreate($objects);
        }
    }
}
