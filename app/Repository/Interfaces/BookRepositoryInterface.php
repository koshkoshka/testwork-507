<?php

namespace App\Repository\Interfaces;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    
    /**
     * @param string $search 
     * @return array|Collection 
     */
    public function search(string $search = '', string $sort = '');
}
