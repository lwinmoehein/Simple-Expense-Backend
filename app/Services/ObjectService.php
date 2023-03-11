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
            return !isset($versions[$category->unique_id]);
        });
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
        $clientVersions = array_keys($versions);

        return array_values(array_filter($clientVersions,function ($key) use ($serverVersions){
            return !in_array($key,$serverVersions);
        }));
    }
    public function getToUpdateServerObjects($table_name,array $versions):Collection{
        $allObjects = $this->getAllObjectsByTable($table_name);

        return $allObjects->filter(function ($category) use ($versions) {
            return isset($versions[$category->unique_id]) && $category->version<$versions[$category->unique_id];
        });
    }
    public function getAllObjectsByTable($table_name){
        switch ($table_name){
            case "transactions":
                return $this->transactionRepository->getAll();
            default:
                return $this->categoryRepository->getAll();
        }
    }
}
