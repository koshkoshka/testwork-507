<?php

namespace App\Repository;

use App\Repository\Interfaces\BaseRepositoryInterface;
use App\Models\Book;
use App\Repository\Interfaces\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{

    public function getAll(string $sort = null) 
    {
        $qb = Book::with('authors')
            //->has('authors')
        ;
        if (!empty($sort)) {
            $sorts = explode(',', $sort);
            foreach ($sorts as $field) {
                $field = trim($field);
                if (in_array($field, ['id', 'title', 'year', 'id desc', 'title desc', 'year desc'])) {
                    $qb->orderByRaw($field);
                }
            }
        }
        return $qb->get(['id', 'title', 'year']);
    }

    /**
     * @param int $id 
     * @return Book|null 
     */
    public function findById(int $id)
    {
        return Book::with('authors')->find($id, ['id', 'title', 'year']);
    }

    public function search(string $query = '', string $sort = '')
    {
        $qb = Book::where(function ($q) use ($query) {
            $q->where('title', 'like', "%$query%")
                ->orWhereHas('authors', function ($a) use ($query) {
                    $a->where('authors.title', 'like', "%$query%");
                });
            })
            ->has('authors')
            ->with('authors');
        if (!empty($sort)) {
            $sorts = explode(',', $sort);
            foreach ($sorts as $field) {
                $field = trim($field);
                if (in_array($field, ['id', 'title', 'year', 'id desc', 'title desc', 'year desc'])) {
                    $qb->orderByRaw($field);
                }
            }
        }
        return $qb->get(['id', 'title', 'year']);
    }
    
}
