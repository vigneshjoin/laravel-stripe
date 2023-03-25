<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\productsModel;

/**
 * Class productsRepository.
 */
class productsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return productsModel::class;
    }

    public function getAll(){
        return $this->model->get();
    }
}
