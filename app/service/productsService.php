<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\productsModel;

class productsService extends Model
{
    public $productsModel;

    public function __construct(productsModel $productsModel){
        $this->productsModel = $productsModel;
    }

    public function getAll(){
        return $this->productsModel->get();
    }

    public function getProductById($productId){
        return $this->productsModel->find($productId);
    }
}
