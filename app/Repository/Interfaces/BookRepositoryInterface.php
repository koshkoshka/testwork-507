<?php

namespace App\Repository\Interfaces;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    
    /**
     * @param array $search 
     * @param array $sort 
     * @return mixed 
     */
    public function search(array $search = [], array $sort = []);
}
