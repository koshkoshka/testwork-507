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
}
