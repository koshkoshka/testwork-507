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
            ->has('authors')
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

    public function search(array $search = [], array $sort = [])
    {
        $qb = Book::where(function ($q) use ($search) {
            foreach ($search as $field => $parameters) {
                $query = $parameters['query'] ?? null;
                $type = $parameters['type'] ?? null;
                if (empty($query)) continue;
                switch ($field) {
                    case 'title':
                        $q->where('title', 'like', "%$query%");//Заголовок всегда ищем по вхождению
                    break;
                    case 'year':
                    case 'id':
                        switch ($type) {
                            case '=':
                            case '>=':
                            case '<=':
                            case '<':
                            case '>':
                            case '!=':
                                if (is_numeric($query)) $q->where($field, $type, $query);
                                break;
                            default:
                                if (is_numeric($query)) $q->where($field, $query);
                        }
                    break;
                }
            }
        })
        ->has('authors')
        ->with('authors');
        foreach ($sort as $parameters) {
            $field = $parameters['field'] ?? null;
            $order = $parameters['order'] ?? 'asc';
            if (empty($field)) continue;
            if (!in_array($field, ['id', 'title', 'year'])) continue;
            switch ($order) {
                case 'asc':
                    $qb->orderBy($field);
                break;
                case 'desc':
                    $qb->orderByDesc($field);
                break;
                default:
                    $qb->orderBy($field);
            }
        }
        return $qb->get(['id', 'title', 'year']);
    }
    
}
