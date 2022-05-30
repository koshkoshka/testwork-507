<?php

namespace App\Repository\Interfaces;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /** @return array|Collection  */
    public function getAll(string $sort = null);

    /**
     * @param int $id 
     * @return Model|null 
     */
    public function findById(int $id);

}
