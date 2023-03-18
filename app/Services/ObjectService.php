<?php
namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;

class  ObjectService {
    protected  $categoryRepository;
    protected $transactionRepository;

    public function __construct(
        CategoryRepository  $categoryRepository,
        TransactionRepository $transactionRepository
    ){
        $this->categoryRepository = $categoryRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function getNewServerObjects($table_name,array $versions):Collection{
        $allObjects = $this->getAllObjectsByTable($table_name);


        return $allObjects->filter(function ($category) use ($versions) {
            if(in_array($category->unique_id,array_column($versions,"unique_id"))){
                return false;
            }
            return true;
        });

    }
    public function storeBatchObjects(string $tableName,array $objects):bool{
        return $this->storeObjectsByTableName($tableName,$objects);
    }

    public function getToUpdateClientObjects($table_name,array $versions):Collection{
        $allObjects = $this->getAllObjectsByTable($table_name);

        return $allObjects->filter(function ($category) use ($versions) {
            return isset($versions[$category->unique_id]) && $category->version>=$versions[$category->unique_id];
        });
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
