<?php

namespace App\Http\Controllers;

use App\Repository\Interfaces\BookRepositoryInterface;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    private $bookRepository;
    
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->middleware('auth:api');
    }

    public function getBooks(Request $request)
    {
        return $this->bookRepository->getAll($request->input('sort'));
    }

    public function searchBooks(Request $request)
    {
        $search = $request->json('search', []);
        $sort = $request->json('sort', []);
        return $this->bookRepository->search($search, $sort);
    }

    public function searchBooks1(Request $request)
    {
        $this->validate($request, [
            'year' => 'nullable|integer', //Проверяем, чтоб год был целым числом
        ]);
        $search = [];
        $sort = [];
        if ($request->has('title')) {
            $search['title']['query'] = $request->get('title');
        }
        if ($request->has('year') && $request->has('year-condition')) {
            $search['year']['query'] = $request->get('year');
            $search['year']['type'] = $request->get('year-condition');
        }
        if ($request->has('sort')) {
            $sort[] = [
                'field' => $request->get('sort'),
                'order' => $request->get('order', 'asc'),
            ];
        }
        return $this->bookRepository->search($search, $sort);
    }
}
